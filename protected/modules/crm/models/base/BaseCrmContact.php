<?php

/**
 * This is the model class for table "crm_contact".
 *
 * The followings are the available columns in table 'crm_contact':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $sex
 * @property string $id_number
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property CrmContactPhones[] $crmContactPhones
 */
class BaseCrmContact extends Model
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
		return 'crm_contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname, email, sex, id_number, created_at', 'required'),
			array('email', 'email'),
			array('firstname, lastname, email, id_number', 'length', 'max'=>45),
			array('sex', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firstname, lastname, email, sex, id_number, created_at', 'safe', 'on'=>'search'),
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
			'crmContactPhones' => array(self::HAS_MANY, 'CrmContactPhones', 'crm_contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'firstname' => Yii::t('app','Firstname'),
			'lastname' => Yii::t('app','Lastname'),
			'email' => Yii::t('app','Email'),
			'sex' => Yii::t('app','Sex'),
			'id_number' => Yii::t('app','Id Number'),
			'created_at' => Yii::t('app','Created At'),
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
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('id_number',$this->id_number,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getPhones()
	{
		// return implode(",", $this->crmContactPhones);
		$phoneString = "";
		foreach ($this->crmContactPhones as $value) {
			$phoneString .= $value->number . ",";
		}
		return rtrim($phoneString, ',');
	}

}
