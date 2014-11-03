<?php

/**
 * This is the model class for table "users_authitem".
 *
 * The followings are the available columns in table 'users_authitem':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property UsersAuthassignment[] $usersAuthassignments
 * @property UsersAuthitemchild[] $usersAuthitemchildren
 * @property UsersAuthitemchild[] $usersAuthitemchildren1
 */
class UsersAuthitem extends Model
{
	public $type=2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_authitem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'unique', 'className'=>'UsersAuthitem','attributeName'=>'name'),
			array('name, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('type', 'length', 'max'=>11),
			array('description, bizrule, data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'usersAuthassignments' => array(self::HAS_MANY, 'UsersAuthassignment', 'itemname'),
			'usersAuthitemchildren' => array(self::HAS_MANY, 'UsersAuthitemchild', 'parent'),
			'usersAuthitemchildren1' => array(self::HAS_MANY, 'UsersAuthitemchild', 'child'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('app','Name'),
			'type' => Yii::t('app','Type'),
			'description' => Yii::t('app','Description'),
			'bizrule' => Yii::t('app','Bizrule'),
			'data' => Yii::t('app','Data'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * This method is in order to 
	 * Return listData element for fill the select input "dropDownList"
	 * in others forms
	 * @return array key value
	 */
	public static function listData()
	{
		return CHtml::listData(self::model()->findAll(),'name','name');
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersAuthitem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function types($type=null)
	{
		$types=array('Operation','Task','Role');
		if($type===null)
			return $types;
		if(isset($types[$type]))
			return $types[$type];
		return "Empty";
	}
}
