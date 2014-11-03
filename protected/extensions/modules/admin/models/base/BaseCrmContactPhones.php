<?php

/**
 * This is the model class for table "crm_contact_phones".
 *
 * The followings are the available columns in table 'crm_contact_phones':
 * @property integer $id
 * @property string $number
 * @property integer $crm_contact_id
 *
 * The followings are the available model relations:
 * @property CrmContact $crmContact
 */
class BaseCrmContactPhones extends Model
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
		return 'crm_contact_phones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, crm_contact_id', 'required'),
			array('crm_contact_id', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>45),
			array('crm_contact_id', 'length', 'max'=>11),
			// array('crm_contact_id', 'exist', 'attributeName'=>'id', 'className'=>'CrmContact'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, crm_contact_id', 'safe', 'on'=>'search'),
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
			'crmContact' => array(self::BELONGS_TO, 'CrmContact', 'crm_contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'number' => Yii::t('app','Number'),
			'crm_contact_id' => Yii::t('app','Crm Contact'),
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
		$criteria->compare('number',$this->number,true);
		$criteria->compare('crm_contact_id',$this->crm_contact_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
