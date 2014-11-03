<?php
Yii::import('ext.modules.gii.CCodeModel');
class CrudCode extends CCodeModel
{
	public $model;
	public $controller;
	public $foraneKey;
	public $moduleName;
	public $baseControllerClass='Controller';
	
	public $labelName;
	public $fontIcon;


	public $title='CRUD Generator';
	public $subTitle='CRUD Generator code';

	private $_modelClass;
	private $_table;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller', 'filter', 'filter'=>'trim'),
			array('controller', 'filter', 'filter'=>'strtolower'),
			array('model, controller, baseControllerClass, moduleName, labelName, fontIcon', 'required'),
			array('model', 'match', 'pattern'=>'/^\w+[\w+\\.]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass', 'match', 'pattern'=>'/^[a-zA-Z_][\w\\\\]*$/', 'message'=>'{attribute} should only contain word characters and backslashes.'),
			array('baseControllerClass', 'validateReservedWord', 'skipOnError'=>true),
			array('controller', 'validateController'),
			array('model', 'validateModel'),
			array('foraneKey', 'validateForeign'),
			// array('foraneKey', 'safe'),
			array('baseControllerClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model'=>'Model Class',
			'controller'=>'Controller ID',
			'baseControllerClass'=>'Base Controller Class',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function init()
	{
		if(Yii::app()->db===null)
			throw new CHttpException(500,'An active "db" connection is required to run this generator.');
		parent::init();
	}

	public function successMessage()
	{
		$link=CHtml::link('try it now', strtr(Yii::app()->createUrl($this->moduleName.'/'.$this->controller),array('.html'=>'')), array('target'=>'_blank'));
		$output="The controller has been generated successfully. You may $link.<br>";
		if($this->template==='cms-manny-modal')
		{
$orderString='';
foreach($this->tableSchema->columns as $column)
{
	if($column->name=='orden_id')
	{
		$orderString="\$criteria->order='orden_id';";
		break;
	}
}


		$code="
<?php
////////////////////////////////////////////////
// REPLACE THIS ON VIEW OR UPDATE CONTROLLER  //
////////////////////////////////////////////////

//\$model=\$this->loadModel(\$id);

\$".$this->getControllerID()."=new ".$this->modelClass.";
\$criteria=new CDbCriteria;
\$criteria->compare('".$this->foraneKey."',\$id);
{$orderString}
\$".$this->getControllerID()."DataProvider=new CActiveDataProvider('".$this->modelClass."',array(
	\"criteria\"=>\$criteria,
));


\$typeRender=Yii::app()->request->isAjaxRequest?\"renderPartial\":\"render\";
\$this->{\$typeRender}('view',array(
	'model'=>\$model,
	'".$this->getControllerID()."'=>\$".$this->getControllerID().",
	'".$this->getControllerID()."DataProvider'=>\$".$this->getControllerID()."DataProvider,
));

////////////////////////////////////////////////////////////
// PASTE THIS CONTENT ON THE VIE OF SAME CONTROLLER ABOVE //
////////////////////////////////////////////////////////////

<?php \$this->renderPartial('../{$this->getControllerID()}/view_embed',array(\n
	'model'=>\$model,
	'".$this->getControllerID()."DataProvider'=>\$".$this->getControllerID()."DataProvider,
	'".$this->getControllerID()."'=>\$".$this->getControllerID().",
))?>";
			$output=<<<EOD
<p>The controller has been generated successfully. You may {$link}.</p>
EOD;

			return $output.highlight_string($code,true);
		}
		elseif($this->template==='cms-manny-grid')
		{
$orderString='';
		$code="
<?php
	// Right now you can create access for your new CRUD menu method in module ".ucfirst($this->moduleName)."Module class
	// something like this:
	/*
	 * HOeee!! Do you want a multi-level menu?
	 * Here is
	*/
	public function menuItems()
	{
		return array(
            array('label'=>Yii::t('app','".ucfirst($this->moduleName)."'), 'icon'=>'fa fa-puzzle-piece', 'url'=>array('#'), 'items'=>array(
			    array('label'=>Yii::t('app','".$this->labelName."'), 'icon'=>'fa ".$this->fontIcon."', 'url'=>array('/'.\$this->id.'/".$this->getControllerID()."/admin')),
            	// ... Put here more sub-menues like this 
            )),
       );
	}";
		$output=<<<EOD
<p>The controller has been generated successfully. You may {$link}.</p>
EOD;

			return $output.highlight_string($code,true);
		}
		else
			return $output;
	}

	public function validateController($attribute,$params)
	{
		if($this->template=='cms-api' and strpos($this->controller,'api_')!==0)
			$this->addError('controller', "If Your template is <strong>cms-api</strong> enter first a controller prefixed eg. <strong>"."api_".$this->controller."</strong>.");
		if($this->template=='cms-manny-grid' and strpos($this->controller,'api_')===0)
			$this->addError('controller', "If Your template is <strong>cms-manny-grid</strong> enter first a controller without prefixed eg. just wrhite <strong>".strtr($this->controller,array('api_'=>''))."</strong>.");
	}

	public function validateForeign($attribute,$params)
	{
		if($this->template=='cms-manny-modal' and empty($this->foraneKey))
			$this->addError('foraneKey', "If Your template is <strong>cms-manny-modal</strong> enter first a foraneKey eg. <strong>"."foraneKey_id</strong>.");
		
		if($this->template=='cms-manny-modal')
		{
			$key=false;
			foreach($this->tableSchema->columns as $column)
			{
				if($column->name==$this->foraneKey)
					$key=true;
			}
			if(!$key)
				$this->addError('foraneKey', "ForaneKey <strong>".$this->foraneKey."</strong> not found.");
		}
	}

	public function validateModel($attribute,$params)
	{
		if($this->hasErrors('model'))
			return;
		if(empty($this->moduleName))
			$this->addError('model', "Select first a module.");

		$class=@Yii::import($this->moduleName.'.models.'.$this->model,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
		elseif(!is_subclass_of($class,'CActiveRecord'))
			$this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
		else
		{
			$table=CActiveRecord::model($class)->tableSchema;
			if($table->primaryKey===null)
				$this->addError('model',"Table '{$table->name}' does not have a primary key.");
			elseif(is_array($table->primaryKey))
				$this->addError('model',"Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			else
			{
				$this->_modelClass=$class;
				$this->_table=$table;
			}
		}
	}

	public function prepare()
	{
		$this->files=array();
		$model=$this->model;
		$controller=$this->controller;
		$nameController=$this->controller;
		
		$this->model=$this->moduleName.'.models.'.$this->model;
		$this->controller=$this->moduleName.'/'.$this->controller;
		
		
		$templatePath=$this->templatePath;
		$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';

		$this->files[]=new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);

		$files=scandir($templatePath);
		foreach($files as $file)
		{
			if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
			{
				if(strpos($file, '.doc.php')!==false)
				{
					// $file=$nameController.'.doc.php';
					$this->files[]=new CCodeFile(
						strtr($this->controllerFile,array('Controller.php'=>'.doc.php')),
						$this->render($templatePath.'/'.$file)
					);
				}
				else
				{
					$this->files[]=new CCodeFile(
						$this->viewPath.DIRECTORY_SEPARATOR.$file,
						$this->render($templatePath.'/'.$file)
					);
				}
			}
		}

		$this->model=$model;
		$this->controller=$controller;
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}

	public function getControllerID()
	{
		if($this->getModule()!==Yii::app())
			$id=substr($this->controller,strpos($this->controller,'/')+1);
		else
			$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getUniqueControllerID()
	{
		$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}

	public function getViewPath()
	{
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass,$column)
	{
		return "CHtml::activeLabelEx(\$model,'{$column->name}')";
	}

	public function generateInputField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "CHtml::activeCheckBox(\$model,'{$column->name}')";
		elseif(stripos($column->dbType,'text')!==false)
			return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='activePasswordField';
			else
				$inputField='activeTextField';

			if($column->type!=='string' || $column->size===null)
				return "CHtml::{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function guessNameColumn($columns)
	{
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'name'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'title'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if($column->isPrimaryKey)
				return $column->name;
		}
		return 'id';
	}

	public function generateActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\$model,'{$column->name}',array('class'=>'control-label'))";
	}

	public function generateActiveField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "\$form->checkBox(\$model,'{$column->name}')";
		elseif(strpos($column->dbType,'tinyint(1)')!==false)
			return "\$form->checkBox(\$model,'{$column->name}')";
		elseif(strpos($column->dbType,'datetime')!==false)
			return $this->textFieldWidget("datetime",$column->name);
		elseif(strpos($column->dbType,'date')!==false)
			return $this->textFieldWidget("date",$column->name);
		elseif(strpos($column->dbType,'time')!==false)
			return $this->textFieldWidget("hour",$column->name);
		elseif(stripos($column->name,'hour_')!==false)
			return $this->textFieldWidget("hour",$column->name);
		elseif(stripos($column->name,'cms_')!==false)
			return $this->textFieldWidget("cms",$column->name);
		elseif(stripos($column->name,'map_')!==false)
			return $this->textFieldWidget("map",$column->name);
		elseif(stripos($column->name,'money_')!==false)
			return $this->textFieldWidget("money",$column->name);
		elseif(stripos($column->name,'redactor_')!==false)
			return $this->textFieldWidget("redactor",$column->name);
		elseif(stripos($column->name,'code_')!==false)
			return $this->textFieldWidget("code",$column->name);
		elseif(stripos($column->name,'img_')!==false)
			return $this->textFieldWidget("img",$column->name);
		elseif(stripos($column->name,'class_')!==false)
			return $this->textFieldWidget("class",$column->name);
		elseif(stripos($column->name,'icon_')!==false)
			return $this->textFieldWidget("icon",$column->name);
		elseif(stripos($column->name,'radio_')!==false)
			return $this->textFieldWidget("radio",$column->name);
		elseif(stripos($column->name,'file_')!==false)
			return $this->textFieldWidget("file",$column->name);
		elseif(stripos($column->name,'editor_')!==false)
			return $this->textFieldWidget("editor",$column->name);
		elseif(stripos($column->name,'color_')!==false)
			return $this->textFieldWidget("color",$column->name);
		elseif($column->name==='users_users_id')
			return "\$form->dropDownList(\$model,'{$column->name}',Users::listData(),array('empty'=>'Select users...','class'=>'form-control'))";
		elseif(strpos($column->name,'_id')!==false or stripos($column->name,'select_')!==false)
			// return $this->textFieldWidget("select",$column->name);
			return "\$form->dropDownList(\$model,'{$column->name}',array('1'=>'Value 1','2'=>'Value 2','3'=>'Value 3')/* CHtml::listData(NameModelRelated::model()->findAll(array('condition'=>'1=1')),'id','nameValueToShow')*/,array('empty'=>'Select a...','class'=>'form-control'))";
		elseif(stripos($column->dbType,'text')!==false)
		{
			if(stripos($column->comment,'len:')!==false)
			{
				$d=explode(':', $column->comment);
				return $this->textFieldWidget("textArea",$column->name,$d[1]);
			}
			return $this->textFieldWidget("textArea",$column->name,1000);
			// return "\$form->textArea(\$model,'{$column->name}',array('rows'=>5, 'cols'=>50,'class'=>'form-control'))";
		}
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordField';
			else
				$inputField='textField';

			// if($column->type!=='string' || $column->size===null)
			if($column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'form-control'))";
			else
			{
				$size=$maxLength=$column->size;
				// if(($size=$maxLength=$column->size)>60)
				// 	$size=60;
				return $this->textFieldWidget($inputField,$column->name,$size);
			}
		}
	}

	public function textFieldWidget($inputField,$name,$size=255)
	{
		if($inputField=='textField')
		{
			return "\$this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>\$model,
				'attribute'=>'{$name}',
				'allowed' => {$size},
				'htmlOptions' => array('class'=>'form-control'),
			),true)";
		}
		if($inputField=='textArea')
		{
			return "\$this->widget('ext.inputs.counter.GTextarea',array(
				'model'=>\$model,
				'attribute'=>'{$name}',
				'allowed' => {$size},
				'htmlOptions' => array('class'=>'form-control','rows'=>5, 'cols'=>50),
			),true)";
		}
		if($inputField=='date')
		{
			return "\$this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
				'model'=>\$model,
				'attribute'=>'{$name}',
		        'pluginOptions' => array(
		            'format' => 'yyyy-mm-dd'
		        ),
				'htmlOptions' => array('class'=>'form-control'),
		    ),true)";
		}
		if($inputField=='datetime')
		{
			return "\$this->widget('yiiwheels.widgets.datetimepicker.WhDateTimePicker', array(
		        'model' => \$model,
		        'attribute' => '{$name}',
				'pluginOptions'=>array( 
			        'pick12HourFormat' => false,
		    		'format' => 'YYYY-MM-DD HH:mm:ss',
					'showButtonPanel' => true,
			        'changeYear' => true,
			    ),
				'htmlOptions' => array('class'=>'form-control'),
		    ),true)";
		}
		if($inputField=='map')
		{
			return "\$this->widget('ext.inputs.map.GMap', array(
			    'model' => \$model,
			    'attribute' => '{$name}',
			),true)";
		}
		if($inputField=='img')
		{
			return "\$this->widget('ext.inputs.uploader.GUpload', array(
			    'model' => \$model,
			    'attribute' => '{$name}',
			    // 'sizeValidate' => array('width'=>'width','height'=>'height'),
			    'actionUrl' => \$this->createUrl('upload'),
			),true)";
		}
		if($inputField=='hour')
		{
			return "\$this->widget('yiiwheels.widgets.maskinput.WhMaskInput', array(
			    'model' => \$model,
			    'attribute' => '{$name}',
                'mask' => '00:00:00',
                'htmlOptions' => array(
                	'placeholder' => '00:00:00', 
                	'class' => 'form-control'
            	),
            ),true)";
		}
		if($inputField=='file')
		{
			return "\$this->widget('ext.inputs.uploader.GUpload', array(
			    'model' => \$model,
			    'attribute' => '{$name}',
			    // Put this same array extensions allowed in your upload action
			    'allowedExtensions' => array('png','jpg','jpeg','csv','xls','xlsx','doc','docx','pdf','rar','zip','txt','mp4','mp3','mov','swf'),
			    'actionUrl' => \$this->createUrl('upload'),
			),true)";
		}
		if($inputField=='editor')
		{
			return "\$this->widget('ext.widgets.xheditor.XHeditor',array(
			    'model'=>\$model,
			    'modelAttribute'=>'{$name}',
			    'config'=>array(
			    	'id'=>'xheditor_1',
			        'tools'=>'mfull', // mini, simple, mfull, full or from XHeditor::\$_tools, tool names are case sensitive
			        'skin'=>'default', // default, nostyle, o2007blue, o2007silver, vista
			        'width'=>'100%',
			        'height'=>'300px',
			        'upImgUrl'=>\$this->createUrl('request/uploadFile'), // NB! Access restricted by IP        'upImgExt'=>'jpg,jpeg,gif,png',
			    ),
			),true)";
		}
		if($inputField=='class')
		{
			return "\$this->widget('ext.inputs.radio.GStatus',array(
				'model'=>\$model,
				'attribute'=>'{$name}',
				'listData'=>array(
				  	'default'=>'<span class=\"label label-default\">Default</span>',
					'primary'=>'<span class=\"label label-primary\">Primary</span>',
					'success'=>'<span class=\"label label-success\">Success</span>',
					'info'=>'<span class=\"label label-info\">Info</span>',
					'warning'=>'<span class=\"label label-warning\">Warning</span>',
					'danger'=>'<span class=\"label label-danger\">Danger</span>'
				)
			),true)";
		}
		if($inputField=='radio')
		{
			return "\$this->widget('ext.inputs.radio.GThumbnail',array(
				'model'=>\$model,
				'attribute'=>'{$name}',
				//'listData'=>CHtml::listData(MyModelRelated::model()->findAll(array('condition'=>'1=1')),'id','propertyModelToreturnHtmlToShow'),
				'listData'=>array(
				  	'1'=>'Example <strong>html</strong> support 1',
					'2'=>'Example <strong>html</strong> support 2',
					'3'=>'Example <strong>html</strong> support 3',
					'4'=>'Example <strong>html</strong> support 4',
					'5'=>'Example <strong>html</strong> support 5',
					'6'=>'Example <strong>html</strong> support 6'
				)
			),true)";
		}
		if($inputField=='icon')
		{
			return "\$this->widget('ext.inputs.radio.GFontAwesome',array(
				'model'=>\$model,
				'attribute'=>'{$name}',
			),true)";
		}
		if($inputField=='color')
		{
			return "\$this->widget('ext.inputs.colorpicker.EColorPicker', array(
                'model'=>\$model,
                'attribute'=>'{$name}',
                'htmlOptions'=>array('class'=>'form-control'),
                'mode'=>'textfield',
                'fade' => false,
                'slide' => false,
                'curtain' => true,
           ),true)";
		}
		if($inputField=='select')
		{
			return "\$this->widget('yiiwheels.widgets.formhelpers.WhSelectBox', array(
            	'model'=>\$model,
                'attribute'=>'{$name}',
				/* 'data' => CHtml::listData(NameModelRelated::model()->findAll(array('condition'=>'1=1')),'id','nameValueToShow') */
                'data' => array(
                	'1'=>'Value 1',
                	'2'=>'Value 2',
                	'3'=>'Value 3'
            	)
            ),true)";
		}
		if($inputField=='money')
		{
			return "\"\";
			\$model->{$name}=Yii::app()->format->money(\$model->{$name});
			echo \$this->widget('yiiwheels.widgets.maskmoney.WhMaskMoney', array(
            	'model'=>\$model,
                'attribute'=>'{$name}',
                'htmlOptions' => array(
                    'class' => 'form-control'
                )
			),true)";
		}
		if($inputField=='redactor')
		{
			return "\$this->widget('yiiwheels.widgets.redactor.WhRedactor', array(
            	'model'=>\$model,
                'attribute'=>'{$name}',
            	'height'=>'250px',
                'htmlOptions' => array(
                    'class' => 'form-control',
                )
			),true)";
		}
		if($inputField=='code')
		{
			return "\$this->widget('yiiwheels.widgets.ace.WhAceEditor', array(
            	'model'=>\$model,
                'attribute'=>'{$name}',
                'htmlOptions' => array(
                    'class' => 'form-control',
                    'style'=> 'width:100%;height:150px',
                )
			),true)";
		}
		if($inputField=='cms')
		{
			return "\$this->widget('ext.inputs.sir-trevor.GSirTrevor',array(
			    'model'=>\$model,
			    'attribute'=>'{$name}',
				'uploadUrl'=>\$this->createUrl('upload'),
				// list of avalilables blocks
				'blockTypes'=>array(
					\"Heading\",
					\"Text\",
					\"List\",
					\"Quote\",
					\"Image\",
					\"Video\",
					\"Tweet\"
				),
				'blockLimit'=>0, // 0 is infinite bloks
				'required'=>array('Text'),
				'onEditorRender'=>'js:function(){
					console.log(\"Do something\")
				}',
				// 'blockTypeLimits'=>array(
				// 	'Text'=>'2',
				// 	'Image'=>'1',
				// ),
			),true)";
		}
		return "\$form->{$inputField}(\$model,'{$name}',array('class'=>'form-control'))";
	}
}