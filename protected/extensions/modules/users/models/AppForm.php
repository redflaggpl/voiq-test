<?php
class AppForm extends CFormModel
{
	public $client_id;
	public $client_secret;
	
	public function rules()
	{
		return array(
			array("client_id, client_secret","required"),
			array("client_id","validateApp"),
		);
	}

	public function validateApp($attribute,$params)
	{
		$app=Apps::model()->find('client_id=? AND client_secret=?',
				array($this->client_id,$this->client_secret));
		if($app===null)
			$this->addError('client_id','Datos de aplicación no encontrada.');
	}
}