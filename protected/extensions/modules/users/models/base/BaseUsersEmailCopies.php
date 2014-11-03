<?php

/**
 * This is the model class for table "users_email_copies".
 *
 * The followings are the available columns in table 'users_email_copies':
 * @property integer $id
 * @property string $redactorWelcomeEmail
 * @property string $redactorForgotEmail
 * @property string $redactorSendPassword
 * @property string $redactorSendPasswordForgot
 */
class BaseUsersEmailCopies extends Model
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
		return 'users_email_copies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('redactorWelcomeEmail, redactorForgotEmail, redactorSendPassword, redactorSendPasswordForgot', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, redactorWelcomeEmail, redactorForgotEmail, redactorSendPassword, redactorSendPasswordForgot', 'safe', 'on'=>'search'),
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
			'redactorWelcomeEmail' => Yii::t('app','Redactor Welcome Email'),
			'redactorForgotEmail' => Yii::t('app','Redactor Forgot Email'),
			'redactorSendPassword' => Yii::t('app','Redactor Send Password'),
			'redactorSendPasswordForgot' => Yii::t('app','Redactor Send Password Forgot'),
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
		$criteria->compare('redactorWelcomeEmail',$this->redactorWelcomeEmail,true);
		$criteria->compare('redactorForgotEmail',$this->redactorForgotEmail,true);
		$criteria->compare('redactorSendPassword',$this->redactorSendPassword,true);
		$criteria->compare('redactorSendPasswordForgot',$this->redactorSendPasswordForgot,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
