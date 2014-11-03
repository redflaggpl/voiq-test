<?php

/**
 * This is the model class for table "settings_settings".
 *
 * The followings are the available columns in table 'settings_settings':
 * @property integer $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $admin_email
 * @property integer $offline
 * @property string $editor_offline_message
 */
class Settings extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keywords, description, admin_email, editor_offline_message', 'required'),
			array('offline', 'boolean'),
			array('admin_email', 'email'),
			array('title', 'length', 'max'=>100),
			array('admin_email', 'length', 'max'=>255),
			array('offline', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, keywords, description, admin_email, offline, editor_offline_message', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'title' => Yii::t('app','Title'),
			'keywords' => Yii::t('app','Keywords'),
			'description' => Yii::t('app','Description'),
			'admin_email' => Yii::t('app','Admin Email'),
			'offline' => Yii::t('app','Offline'),
			'editor_offline_message' => Yii::t('app','Editor Offline Message'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('admin_email',$this->admin_email,true);
		$criteria->compare('offline',$this->offline);
		$criteria->compare('editor_offline_message',$this->editor_offline_message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Settings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * This method is in order to 
	 * Return listData element for fill the select input "dropDownList"
	 * in others forms
	 * @return array key value
	 */
	public static function listData()
	{
		return CHtml::listData(self::model()->findAll(),'id','description'); // change description for your input naem in db table
	}
}
