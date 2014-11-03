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
class SmtpTest extends CFormModel
{
	public $template='email';
	public $result;
	public $message;
	public $email_test;
	public $area_test;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_test, area_test', 'required'),
			array('email_test', 'email'),
			array('result, message, template', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email_test' => Yii::t('app','Email for send'),
			'area_test' => Yii::t('app','Message for this test'),
		);
	}
}
