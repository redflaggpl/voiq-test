<?php

/**
 * This is the model class for table "smpt_config".
 *
 * The followings are the available columns in table 'smpt_config':
 * @property integer $id
 * @property integer $enabled
 * @property string $host_email_server
 * @property integer $port_email_server
 * @property string $username_email_server
 * @property string $password_email_server
 */
class SmptConfig extends Model
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'smpt_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('port_email_server', 'numerical', 'integerOnly'=>true),
			array('enabled', 'boolean'),
			array('host_email_server, username_email_server, password_email_server, port_email_server', 'validateRequire'),
			array('host_email_server, username_email_server, password_email_server', 'length', 'max'=>150),
			array('enabled', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, enabled, host_email_server, port_email_server, username_email_server, password_email_server', 'safe', 'on'=>'search'),
		);
	}

	public function validateRequire($attribute,$params)
	{
		if($this->enabled and $this->{$attribute}=='')
			$this->addError($attribute,'Si el smpt se habilita debe completar este dato.');
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
			'enabled' => Yii::t('app','Enabled'),
			'host_email_server' => Yii::t('app','Host Email Server'),
			'port_email_server' => Yii::t('app','Port Email Server'),
			'username_email_server' => Yii::t('app','Username Email Server'),
			'password_email_server' => Yii::t('app','Password Email Server'),
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
		$criteria->compare('enabled',$this->enabled);
		$criteria->compare('host_email_server',$this->host_email_server,true);
		$criteria->compare('port_email_server',$this->port_email_server);
		$criteria->compare('username_email_server',$this->username_email_server,true);
		$criteria->compare('password_email_server',$this->password_email_server,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SmptConfig the static model class
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
