<?php

/**
 * This is the model class for table "crm_files".
 *
 * The followings are the available columns in table 'crm_files':
 * @property integer $id
 * @property string $file
 * @property string $date
 */
class CrmFiles extends BaseCrmFiles
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array_merge(parent::rules(),array(
		));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array_merge(parent::relations(),array(
		));
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(),array(
		));
	}

	public function processSpreadsheet()
	{
		$path = 'uploads/';
		$spreadSheet = Yii::app()->excel->load(@$path.$this->file)->getActiveSheet();
		if(!$this->validateHeaders($spreadSheet)){
			return "Missing headers params";
		}

		for($row = 2; $row <= $spreadSheet->getHighestRow(); ++$row)
		{
			// print_r(@$spreadSheet->getCellByColumnAndRow(0, $row)->getValue());
			$crmContactModel = new CrmContact;
			$crmContactModel->firstname=trim($spreadSheet->getCellByColumnAndRow(0, $row)->getValue());
			$crmContactModel->lastname=trim($spreadSheet->getCellByColumnAndRow(1, $row)->getValue());
			$crmContactModel->email=trim($spreadSheet->getCellByColumnAndRow(2, $row)->getValue());
			$crmContactModel->sex=trim($spreadSheet->getCellByColumnAndRow(3, $row)->getValue());
			$crmContactModel->id_number=trim($spreadSheet->getCellByColumnAndRow(4, $row)->getValue());
			$crmContactModel->created_at = date('Y-m-d H:i:s');
			if(!$crmContactModel->save()){
				print_r($crmContactModel->errors);
				return "Fail, an error occurred creating contact";
			} else{
				if(!$this->createContactPhones(trim($spreadSheet->getCellByColumnAndRow(5, $row)->getValue()),$crmContactModel->id))
					return "Fail, an error occurred creating contact phones";
			}
		}
		return true;
	}

	public function validateHeaders($spreadSheet)
	{
		if(!(trim($spreadSheet->getCellByColumnAndRow(0, 1)->getValue()) == "firstname"))
			return false;
		if(!(trim($spreadSheet->getCellByColumnAndRow(1, 1)->getValue()) == "lastname"))
			return false;
		if(!(trim($spreadSheet->getCellByColumnAndRow(2, 1)->getValue()) == "email"))
			return false;
		if(!(trim($spreadSheet->getCellByColumnAndRow(3, 1)->getValue()) == "sex"))
			return false;
		if(!(trim($spreadSheet->getCellByColumnAndRow(4, 1)->getValue()) == "id_number"))
			return false;
		if(!(trim($spreadSheet->getCellByColumnAndRow(5, 1)->getValue()) == "phones"))
			return false;

		return true;
	}

	public function createContactPhones($phonesString, $crm_contact_id)
	{
		$phonesArray = array();
		$phonesArray = explode(',', $phonesString);
		foreach ($phonesArray as $phone) {
			$model = new CrmContactPhones;
			$model->number = $phone;
			$model->crm_contact_id = $crm_contact_id;
			if(!$model->save()){
				print_r($model->errors);
				Yii::app()->end();
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TestTest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
