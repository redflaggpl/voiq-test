<?php

/**
 * This is the model class for table "users_config".
 *
 * The followings are the available columns in table 'users_config':
 * @property integer $id
 * @property string $labelMenu
 * @property integer $showMenuFromAdmin
 * @property integer $loginInRegister
 * @property integer $sendPassword
 * @property integer $enableOAuth
 * @property integer $allowBasicOAuth
 * @property integer $facebookLoginRegister
 * @property string $facebookAppId
 * @property string $facebookSecret
 * @property integer $twitterLoginRegister
 * @property string $twitterAppId
 * @property string $twitterSecret
 */
class UsersConfig extends BaseUsersConfig
{

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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersConfig the static model class
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
