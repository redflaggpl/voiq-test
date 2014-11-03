<?php

class ModelCode extends CCodeModel
{
	public $connectionId='db';
	public $tablePrefix;
	public $tableName;
	public $moduleName;
	public $modelClass;
	public $modelPath='application.models';
	public $baseClass='Model';
	public $buildRelations=true;
	public $commentsAsLabels=false;

	/**
	 * @var array list of candidate relation code. The array are indexed by AR class names and relation names.
	 * Each element represents the code of the one relation in one AR class.
	 */
	protected $relations;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('tablePrefix, baseClass, tableName, modelClass, modelPath, connectionId', 'filter', 'filter'=>'trim'),
			array('connectionId, tableName, modelPath, baseClass, moduleName', 'required'),
			array('tablePrefix, tableName, modelPath', 'match', 'pattern'=>'/^(\w+[\w\.]*|\*?|\w+\.\*)$/', 'message'=>'{attribute} should only contain word characters, dots, and an optional ending asterisk.'),
			array('connectionId', 'validateConnectionId', 'skipOnError'=>true),
			array('tableName', 'validateTableName', 'skipOnError'=>true),
			array('tablePrefix, modelClass', 'match', 'pattern'=>'/^[a-zA-Z_]\w*$/', 'message'=>'{attribute} should only contain word characters.'),
		    array('baseClass', 'match', 'pattern'=>'/^[a-zA-Z_][\w\\\\]*$/', 'message'=>'{attribute} should only contain word characters and backslashes.'),
			array('moduleName', 'validateModelPath'),
			array('baseClass, modelClass', 'validateReservedWord', 'skipOnError'=>true),
			array('baseClass', 'validateBaseClass', 'skipOnError'=>true),
			array('connectionId, tablePrefix, modelPath, baseClass, buildRelations, commentsAsLabels', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'tablePrefix'=>'Table Prefix',
			'tableName'=>'Table Name',
			'modelPath'=>'Model Path',
			'modelClass'=>'Model Class',
			'baseClass'=>'Base Class',
			'buildRelations'=>'Build Relations',
			'commentsAsLabels'=>'Use Column Comments as Attribute Labels',
			'connectionId'=>'Database Connection',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'model.php',
		);
	}

	public function init()
	{
		if(Yii::app()->{$this->connectionId}===null)
			throw new CHttpException(500,'A valid database connection is required to run this generator.');
		$this->tablePrefix=Yii::app()->{$this->connectionId}->tablePrefix;
		parent::init();
	}

	public function prepare()
	{
		if(($pos=strrpos($this->tableName,'.'))!==false)
		{
			$schema=substr($this->tableName,0,$pos);
			$tableName=substr($this->tableName,$pos+1);
		}
		else
		{
			$schema='';
			$tableName=$this->tableName;
		}
		if($tableName[strlen($tableName)-1]==='*')
		{
			$tables=Yii::app()->{$this->connectionId}->schema->getTables($schema);
			if($this->tablePrefix!='')
			{
				foreach($tables as $i=>$table)
				{
					if(strpos($table->name,$this->tablePrefix)!==0)
						unset($tables[$i]);
				}
			}
		}
		else
			$tables=array($this->getTableSchema($this->tableName));

		$this->files=array();
		$templatePath=$this->templatePath;
		$this->relations=$this->generateRelations();

		foreach($tables as $table)
		{
			$tableName=$this->removePrefix($table->name);
			$className=$this->generateClassName($table->name);
			$params=array(
				'tableName'=>$schema==='' ? $tableName : $schema.'.'.$tableName,
				'modelClass'=>$className,
				'columns'=>$table->columns,
				'labels'=>$this->generateLabels($table),
				'rules'=>$this->generateRules($table),
				'relations'=>isset($this->relations[$className]) ? $this->relations[$className] : array(),
				'connectionId'=>$this->connectionId,
			);
			$this->files[]=new CCodeFile(
				Yii::getPathOfAlias($this->modelPath).'/base/Base'.$className.'.php',
				$this->render($templatePath.'/base.php', $params)
			);
			if(!file_exists(Yii::getPathOfAlias($this->modelPath).'/'.$className.'.php'))
			{
				$this->files[]=new CCodeFile(
					Yii::getPathOfAlias($this->modelPath).'/'.$className.'.php',
					$this->render($templatePath.'/model.php', $params)
				);
			}
		}
	}

	public function validateTableName($attribute,$params)
	{
		if($this->hasErrors())
			return;

		$invalidTables=array();
		$invalidColumns=array();

		if($this->tableName[strlen($this->tableName)-1]==='*')
		{
			if(($pos=strrpos($this->tableName,'.'))!==false)
				$schema=substr($this->tableName,0,$pos);
			else
				$schema='';

			$this->modelClass='';
			$tables=Yii::app()->{$this->connectionId}->schema->getTables($schema);
			foreach($tables as $table)
			{
				if($this->tablePrefix=='' || strpos($table->name,$this->tablePrefix)===0)
				{
					if(in_array(strtolower($table->name),self::$keywords))
						$invalidTables[]=$table->name;
					if(($invalidColumn=$this->checkColumns($table))!==null)
						$invalidColumns[]=$invalidColumn;
				}
			}
		}
		else
		{
			if(($table=$this->getTableSchema($this->tableName))===null)
				$this->addError('tableName',"Table '{$this->tableName}' does not exist.");
			if($this->modelClass==='')
				$this->addError('modelClass','Model Class cannot be blank.');

			if(!$this->hasErrors($attribute) && ($invalidColumn=$this->checkColumns($table))!==null)
					$invalidColumns[]=$invalidColumn;
		}

		if($invalidTables!=array())
			$this->addError('tableName', 'Model class cannot take a reserved PHP keyword! Table name: '.implode(', ', $invalidTables).".");
		if($invalidColumns!=array())
			$this->addError('tableName', 'Column names that does not follow PHP variable naming convention: '.implode(', ', $invalidColumns).".");
	}

	/*
	 * Check that all database field names conform to PHP variable naming rules
	 * For example mysql allows field name like "2011aa", but PHP does not allow variable like "$model->2011aa"
	 * @param CDbTableSchema $table the table schema object
	 * @return string the invalid table column name. Null if no error.
	 */
	public function checkColumns($table)
	{
		foreach($table->columns as $column)
		{
			if(!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/',$column->name))
				return $table->name.'.'.$column->name;
		}
	}

	public function validateModelPath($attribute,$params)
	{
		if(is_dir(Yii::getPathOfAlias(strtr($this->modelPath,array('.models'=>''))))===false)
			$this->addError('moduleName','Model Path must be a valid module.');
	}

	public function validateBaseClass($attribute,$params)
	{
		$class=@Yii::import($this->baseClass,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('baseClass', "Class '{$this->baseClass}' does not exist or has syntax error.");
		elseif($class!=='CActiveRecord' && !is_subclass_of($class,'CActiveRecord'))
			$this->addError('baseClass', "'{$this->model}' must extend from CActiveRecord.");
	}

	public function getTableSchema($tableName)
	{
		$connection=Yii::app()->{$this->connectionId};
		return $connection->getSchema()->getTable($tableName, $connection->schemaCachingDuration!==0);
	}

	public function generateLabels($table)
	{
		$labels=array();
		foreach($table->columns as $column)
		{
			if($this->commentsAsLabels && $column->comment)
				$labels[$column->name]=$column->comment;
			else
			{
				$columnName=strtr($column->name, Yii::app()->getModule('gii')->arrayClean);
				$label=ucwords(trim(strtolower(str_replace(array('-','_'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $columnName)))));
				$label=preg_replace('/\s+/',' ',$label);
				if(strcasecmp(substr($label,-3),' id')===0)
					$label=substr($label,0,-3);
				if($label==='Id')
					$label='ID';
				$label=str_replace("'","\\'",$label);
				$labels[$column->name]=$label;
			}
		}
		return $labels;
	}

	public function generateRules($table)
	{
		$rules=array();
		$required=array();
		$integers=array();
		$numerical=array();
		$length=array();
		$safe=array();
		$boolean=array();
		$email=array();
		$foreignKeys=array();
		$urls=array();
		$time=array();
		$date=array();
		$dateTime=array();
		$users=array();
		$password=array();

		foreach($table->columns as $column)
		{
			// echo $column->dbType;
			if($column->autoIncrement)
				continue;
			$r=!$column->allowNull && $column->defaultValue===null;
			if($r)
				$required[]=$column->name;
			if(strpos($column->dbType,'tinyint(1)')!==false)
			{
				$boolean[]=$column->name;
				$safe[]=$column->name;
			}
			elseif(strpos($column->dbType,'decimal')!==false or strpos($column->dbType,'float')!==false or stripos($column->name,'money_')!==false)
				$numerical[]=$column->name;
			elseif(stripos($column->name,'url_')!==false or stripos($column->name,'link_')!==false)
				$urls[]=$column->name;
			elseif($column->name==='users_users_id')
				$users[]=$column->name;
			elseif($column->type==='integer')
			{
				$integers[]=$column->name;
				if($column->size>0)
					$length[$column->size][]=$column->name;
			}
			elseif($column->dbType==='time')
				$time[]=$column->name;
			elseif($column->dbType==='datetime')
				$dateTime[]=$column->name;
			elseif($column->dbType==='date')
				$date[]=$column->name;
			elseif($column->type==='string' && $column->size>0)
			{
				if($column->size>0)
					$length[$column->size][]=$column->name;
				if(strpos($column->name, 'email')!==false)
					$email[]=$column->name;
			}
			elseif((stripos($column->dbType,'text')!==false) && (stripos($column->comment,'len:')!==false))
			{
				$d=explode(':', $column->comment);
				$length[$d[1]][]=$column->name;
			}
			elseif(!$column->isPrimaryKey && !$r)
				$safe[]=$column->name;
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name) or strpos($column->name,'contrasena')!==false)
				$password[]=$column->name;

		}
		// exit;
		if($password!==array())
			$rules[]="array('".implode(', ',$password)."', 'ext.validators.PasswordStrength','strength'=>'weak'/*weak or strong*/)";
		if($required!==array())
			$rules[]="array('".implode(', ',$required)."', 'required')";
		if($integers!==array())
			$rules[]="array('".implode(', ',$integers)."', 'numerical', 'integerOnly'=>true)";
		if($boolean!==array())
			$rules[]="array('".implode(', ',$boolean)."', 'boolean')";
		if($numerical!==array())
			$rules[]="array('".implode(', ',$numerical)."', 'numerical')";
		if($email!==array())
			$rules[]="array('".implode(', ',$email)."', 'email')";
		if($urls!==array())
			$rules[]="array('".implode(', ',$urls)."', 'url')";
		if($time!==array())
			$rules[]="array('".implode(', ',$time)."', 'type', 'type'=>'time', 'timeFormat'=>'hh:mm:ss', 'message'=>'{attribute} have wrong format should be hh:mm:ss')";
		if($dateTime!==array())
			$rules[]="array('".implode(', ',$dateTime)."', 'type', 'type'=>'datetime', 'datetimeFormat'=>'yyyy-MM-dd hh:mm:ss', 'message'=>'{attribute} have wrong format should be yyyy-MM-dd hh:mm:ss')";
		if($date!==array())
			$rules[]="array('".implode(', ',$date)."', 'type', 'type'=>'date', 'dateFormat'=>'yyyy-MM-dd', 'message'=>'{attribute} have wrong format should be yyyy-MM-dd')";
		if($users!==array())
        	$rules[]="array('".implode(', ',$users)."', 'exist', 'attributeName'=>'id', 'className'=>'Users')";
		if($length!==array())
		{
			foreach($length as $len=>$cols)
				$rules[]="array('".implode(', ',$cols)."', 'length', 'max'=>$len)";
		}
		if($safe!==array())
			$rules[]="array('".implode(', ',$safe)."', 'safe')";

$relations=isset($this->relations[$this->modelClass]) ? $this->relations[$this->modelClass] : array();
if(!empty($relations)):
foreach($relations as $name=>$relation):

	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];
        $fieldName = $matches[3];

        switch($relationType){
            case 'HAS_ONE':
	            // if($required!==array() and )
	            // 	$allow=",'allowEmpty'=>false'";
            	$rules[]="// array('".$fieldName."', 'exist', 'attributeName'=>'id', 'className'=>'".$relationModel."'".$allow.")";
            break;
            case 'BELONGS_TO':
				$rules[]="// array('".$fieldName."', 'exist', 'attributeName'=>'id', 'className'=>'".$relationModel."')";
            break;
    //         case 'HAS_MANY':
				// $rules[]="array('".$fieldName."', 'exist', 'attributeName'=>'id', 'className'=>'".$relationModel."')";
    //         break;
    //         case 'MANY_MANY':
				// $rules[]="array('".$fieldName."', 'exist', 'attributeName'=>'id', 'className'=>'".$relationModel."')";
    //         break;
            default:
        }
	}
endforeach;
endif;

		return $rules;
	}

	public function getRelations($className)
	{
		return isset($this->relations[$className]) ? $this->relations[$className] : array();
	}

	protected function removePrefix($tableName,$addBrackets=true)
	{
		if($addBrackets && Yii::app()->{$this->connectionId}->tablePrefix=='')
			return $tableName;
		$prefix=$this->tablePrefix!='' ? $this->tablePrefix : Yii::app()->{$this->connectionId}->tablePrefix;
		if($prefix!='')
		{
			if($addBrackets && Yii::app()->{$this->connectionId}->tablePrefix!='')
			{
				$prefix=Yii::app()->{$this->connectionId}->tablePrefix;
				$lb='{{';
				$rb='}}';
			}
			else
				$lb=$rb='';
			if(($pos=strrpos($tableName,'.'))!==false)
			{
				$schema=substr($tableName,0,$pos);
				$name=substr($tableName,$pos+1);
				if(strpos($name,$prefix)===0)
					return $schema.'.'.$lb.substr($name,strlen($prefix)).$rb;
			}
			elseif(strpos($tableName,$prefix)===0)
				return $lb.substr($tableName,strlen($prefix)).$rb;
		}
		return $tableName;
	}

	protected function generateRelations()
	{
		if(!$this->buildRelations)
			return array();

		$schemaName='';
		if(($pos=strpos($this->tableName,'.'))!==false)
			$schemaName=substr($this->tableName,0,$pos);

		$relations=array();
		foreach(Yii::app()->{$this->connectionId}->schema->getTables($schemaName) as $table)
		{
			if($this->tablePrefix!='' && strpos($table->name,$this->tablePrefix)!==0)
				continue;
			$tableName=$table->name;

			if ($this->isRelationTable($table))
			{
				$pks=$table->primaryKey;
				$fks=$table->foreignKeys;

				$table0=$fks[$pks[0]][0];
				$table1=$fks[$pks[1]][0];
				$className0=$this->generateClassName($table0);
				$className1=$this->generateClassName($table1);

				$unprefixedTableName=$this->removePrefix($tableName);

				$relationName=$this->generateRelationName($table0, $table1, true);
				$relations[$className0][$relationName]="array(self::MANY_MANY, '$className1', '$unprefixedTableName($pks[0], $pks[1])')";

				$relationName=$this->generateRelationName($table1, $table0, true);

				$i=1;
				$rawName=$relationName;
				while(isset($relations[$className1][$relationName]))
					$relationName=$rawName.$i++;

				$relations[$className1][$relationName]="array(self::MANY_MANY, '$className0', '$unprefixedTableName($pks[1], $pks[0])')";
			}
			else
			{
				$className=$this->generateClassName($tableName);
				foreach ($table->foreignKeys as $fkName => $fkEntry)
				{
					// Put table and key name in variables for easier reading
					$refTable=$fkEntry[0]; // Table name that current fk references to
					$refKey=$fkEntry[1];   // Key in that table being referenced
					$refClassName=$this->generateClassName($refTable);

					// Add relation for this table
					$relationName=$this->generateRelationName($tableName, $fkName, false);
					$relations[$className][$relationName]="array(self::BELONGS_TO, '$refClassName', '$fkName')";

					// Add relation for the referenced table
					$relationType=$table->primaryKey === $fkName ? 'HAS_ONE' : 'HAS_MANY';
					$relationName=$this->generateRelationName($refTable, $this->removePrefix($tableName,false), $relationType==='HAS_MANY');
					$i=1;
					$rawName=$relationName;
					while(isset($relations[$refClassName][$relationName]))
						$relationName=$rawName.($i++);
					$relations[$refClassName][$relationName]="array(self::$relationType, '$className', '$fkName')";
				}
			}
		}
		return $relations;
	}

	/**
	 * Checks if the given table is a "many to many" pivot table.
	 * Their PK has 2 fields, and both of those fields are also FK to other separate tables.
	 * @param CDbTableSchema table to inspect
	 * @return boolean true if table matches description of helpter table.
	 */
	protected function isRelationTable($table)
	{
		$pk=$table->primaryKey;
		return (count($pk) === 2 // we want 2 columns
			&& isset($table->foreignKeys[$pk[0]]) // pk column 1 is also a foreign key
			&& isset($table->foreignKeys[$pk[1]]) // pk column 2 is also a foriegn key
			&& $table->foreignKeys[$pk[0]][0] !== $table->foreignKeys[$pk[1]][0]); // and the foreign keys point different tables
	}

	protected function generateClassName($tableName)
	{
		if($this->tableName===$tableName || ($pos=strrpos($this->tableName,'.'))!==false && substr($this->tableName,$pos+1)===$tableName)
			return $this->modelClass;

		$tableName=$this->removePrefix($tableName,false);
		if(($pos=strpos($tableName,'.'))!==false) // remove schema part (e.g. remove 'public2.' from 'public2.post')
			$tableName=substr($tableName,$pos+1);
		$className='';
		foreach(explode('_',$tableName) as $name)
		{
			if($name!=='')
				$className.=ucfirst($name);
		}
		if($className==='UsersUsers')
			$className='Users';
		return $className;
	}

	/**
	 * Generate a name for use as a relation name (inside relations() function in a model).
	 * @param string the name of the table to hold the relation
	 * @param string the foreign key name
	 * @param boolean whether the relation would contain multiple objects
	 * @return string the relation name
	 */
	protected function generateRelationName($tableName, $fkName, $multiple)
	{
		if(strcasecmp(substr($fkName,-2),'id')===0 && strcasecmp($fkName,'id'))
			$relationName=rtrim(substr($fkName, 0, -2),'_');
		else
			$relationName=$fkName;
		$relationName[0]=strtolower($relationName);

		if($multiple)
			$relationName=$this->pluralize($relationName);

		$names=preg_split('/_+/',$relationName,-1,PREG_SPLIT_NO_EMPTY);
		if(empty($names)) return $relationName;  // unlikely
		for($name=$names[0], $i=1;$i<count($names);++$i)
			$name.=ucfirst($names[$i]);

		$rawName=$name;
		$table=Yii::app()->{$this->connectionId}->schema->getTable($tableName);
		$i=0;
		while(isset($table->columns[$name]))
			$name=$rawName.($i++);

		return $name;
	}

	public function validateConnectionId($attribute, $params)
	{
		if(Yii::app()->hasComponent($this->connectionId)===false || !(Yii::app()->getComponent($this->connectionId) instanceof CDbConnection))
			$this->addError('connectionId','A valid database connection is required to run this generator.');
	}

	public function listDataTables()
	{
		$tables=Yii::app()->hasComponent($this->connectionId) ? array_keys(Yii::app()->{$this->connectionId}->schema->getTables()) : array();
		$result=array();
		foreach($tables as $table)
			$result[$table]=$table;
		return $result;
	}
}
