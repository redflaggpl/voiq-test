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
 * @property string $copyWelcomeEmail
 * @property string $copyForgotEmail
 * @property string $copySendPassword
 * @property string $copySendPasswordForgot
 */
class BaseUsersConfig extends Model
{

	public function afterFind()
	{
		parent::afterFind();
	}

	protected function beforeValidate()
	{
		return parent::beforeValidate();
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('copyWelcomeEmail, copyForgotEmail, copySendPassword, copySendPasswordForgot', 'required'),
			array('showMenuFromAdmin, loginInRegister, sendPassword, enableOAuth, allowBasicOAuth, facebookLoginRegister, twitterLoginRegister', 'boolean'),
			array('labelMenu, facebookSecret, twitterSecret', 'length', 'max'=>100),
			array('facebookAppId, twitterAppId', 'length', 'max'=>30),
			array('showMenuFromAdmin, loginInRegister, sendPassword, enableOAuth, allowBasicOAuth, facebookLoginRegister, twitterLoginRegister', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, labelMenu, showMenuFromAdmin, loginInRegister, sendPassword, enableOAuth, allowBasicOAuth, facebookLoginRegister, facebookAppId, facebookSecret, twitterLoginRegister, twitterAppId, twitterSecret, copyWelcomeEmail, copyForgotEmail, copySendPassword, copySendPasswordForgot', 'safe', 'on'=>'search'),
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
			'labelMenu' => Yii::t('app','Label Menu'),
			'showMenuFromAdmin' => Yii::t('app','Show Menu From Admin'),
			'loginInRegister' => Yii::t('app','Login In Register'),
			'sendPassword' => Yii::t('app','Send Password'),
			'enableOAuth' => Yii::t('app','Enable Oauth'),
			'allowBasicOAuth' => Yii::t('app','Allow Basic Oauth'),
			'facebookLoginRegister' => Yii::t('app','Facebook Login Register'),
			'facebookAppId' => Yii::t('app','Facebook App'),
			'facebookSecret' => Yii::t('app','Facebook Secret'),
			'twitterLoginRegister' => Yii::t('app','Twitter Login Register'),
			'twitterAppId' => Yii::t('app','Twitter App'),
			'twitterSecret' => Yii::t('app','Twitter Secret'),
			'copyWelcomeEmail' => Yii::t('app','Copy Welcome Email'),
			'copyForgotEmail' => Yii::t('app','Copy Forgot Email'),
			'copySendPassword' => Yii::t('app','Copy Send Password'),
			'copySendPasswordForgot' => Yii::t('app','Copy Send Password Forgot'),
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
		$criteria->compare('labelMenu',$this->labelMenu,true);
		$criteria->compare('showMenuFromAdmin',$this->showMenuFromAdmin);
		$criteria->compare('loginInRegister',$this->loginInRegister);
		$criteria->compare('sendPassword',$this->sendPassword);
		$criteria->compare('enableOAuth',$this->enableOAuth);
		$criteria->compare('allowBasicOAuth',$this->allowBasicOAuth);
		$criteria->compare('facebookLoginRegister',$this->facebookLoginRegister);
		$criteria->compare('facebookAppId',$this->facebookAppId,true);
		$criteria->compare('facebookSecret',$this->facebookSecret,true);
		$criteria->compare('twitterLoginRegister',$this->twitterLoginRegister);
		$criteria->compare('twitterAppId',$this->twitterAppId,true);
		$criteria->compare('twitterSecret',$this->twitterSecret,true);
		$criteria->compare('copyWelcomeEmail',$this->copyWelcomeEmail,true);
		$criteria->compare('copyForgotEmail',$this->copyForgotEmail,true);
		$criteria->compare('copySendPassword',$this->copySendPassword,true);
		$criteria->compare('copySendPasswordForgot',$this->copySendPasswordForgot,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
