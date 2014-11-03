<?php

/**
 * RecoverForm class.
 * RecoverForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ForgotForm extends CFormModel
{
	public $email;
	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and password are required
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'validateEnabled'),
			// password needs to be authenticated
			array('email', 'exist',
				'allowEmpty'=>false,
				'attributeName'=>'email',
				'className'=>'Users',
				'message'=>Yii::t('app','Your email <strong>{value}</ strong> is not registered in our database'),
				'criteria'=>array("condition"=>"papelera=0")
			),
		);
	}

	public function validateEnabled($attribute,$params)
	{
		if(!$this->hasErrors()) 
		{
			$model=Users::model()->find('email=? AND papelera=0',array($this->email));
			if($model!==null and $model->state_email==0)
				$this->addError('email',Yii::t('app',"Your email dosen't has been verified yet, please click {here} for resend email.",
					array('{here}'=>CHtml::link(Yii::t('app','Here'),array('/users/page/resendVerify','email'=>$model->email)))));
			if($model!==null and $model->state!=1)
				$this->addError('email',Yii::t('app',"Your email <strong>{attribute}</strong> has been desabled",array('{attribute}'=>$this->email)));

		}
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Email',
		);
	}
}
