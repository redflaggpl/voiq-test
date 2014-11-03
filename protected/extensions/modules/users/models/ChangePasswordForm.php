<?php

/**
 * ChangePasswordForm class.
 * ChangePasswordForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ChangePasswordForm extends CFormModel
{

	public $oldPassword;
	public $newPassword;
	public $confirmNewPassword;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and password are required
			array('oldPassword, newPassword, confirmNewPassword', 'required'),
			array('oldPassword, newPassword, confirmNewPassword', 'length', 'min'=>4),
			// rememberMe needs to be a boolean
			array('oldPassword', 'verifyPassword'),
			array('confirmNewPassword', 'sameNewPassword'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'oldPassword'=>Yii::t('app','Old Password'),
			'newPassword'=>Yii::t('app','New Password'),
			'confirmNewPassword'=>Yii::t('app','Confirm your new password'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'verifyPassword' validator as declared in rules().
	 */
	public function verifyPassword($attribute,$params)
	{
		$model=Users::model()->findByPk(Yii::app()->user->id);
		if($model===null)
			$this->addError('oldPassword','La sesión expiró.');
		if($model!==null and ($model->password)!==sha1($this->oldPassword))
			$this->addError('oldPassword','El password anterior no coincide, por favor intente nuevamente.');
	}

	/**
	 * Authenticates the password.
	 * This is the 'verifyPassword' validator as declared in rules().
	 */
	public function sameNewPassword($attribute,$params)
	{
		if($this->newPassword!==$this->confirmNewPassword)
			$this->addError('confirmNewPassword','Por favor escribe la nuevamente la nueva contraseña.');
	}
}
