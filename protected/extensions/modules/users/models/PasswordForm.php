<?php

/**
 * PasswordForm class.
 * PasswordForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PasswordForm extends CFormModel
{

	public $password;
	public $passwordConfirm;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and password are required
			array('password, passwordConfirm', 'required'),
			array('password, passwordConfirm', 'length', 'min'=>4),
			// rememberMe needs to be a boolean
			array('passwordConfirm', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Email',
			'password'=>'Nueva contraseña',
			'passwordConfirm'=>'Escribela nuevamente por favor',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			if($this->passwordConfirm!==$this->password)
				$this->addError('passwordConfirm','Debes escribir la misma contraseña en los dos campos');
		}
	}

}
