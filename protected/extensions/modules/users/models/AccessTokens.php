<?php

/**
 * This is the model class for table "users_access_tokens".
 *
 * The followings are the available columns in table 'users_access_tokens':
 * @property integer $id
 * @property string $acces_token
 * @property integer $apps_id
 * @property integer $users_id
 * @property string $acces_token_refresh
 * @property string $code
 */
class AccessTokens extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_access_tokens';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acces_token, apps_id, users_id, acces_token_refresh', 'required'),
			array('apps_id, users_id', 'numerical', 'integerOnly'=>true),
			array('acces_token, acces_token_refresh, code', 'length', 'max'=>255),
			array('code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, acces_token, apps_id, users_id, acces_token_refresh, code', 'safe', 'on'=>'search'),
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
			'acces_token' => Yii::t('app','Acces Token'),
			'apps_id' => Yii::t('app','Apps'),
			'users_id' => Yii::t('app','Users'),
			'acces_token_refresh' => Yii::t('app','Acces Token Refresh'),
			'code' => Yii::t('app','Code'),
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
		$criteria->compare('acces_token',$this->acces_token,true);
		$criteria->compare('apps_id',$this->apps_id);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('acces_token_refresh',$this->acces_token_refresh,true);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccessTokens the static model class
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
