<?php
class ESmsSender extends CApplicationComponent
{
	public $username = "info@uniagenda.com";
	public $password = "sms3165829544";
	public $apiKey = "GuDq7zQp23";
	private $url = "http://www.elibom.com/http/sendmessage";
	private $servicio = "http://www.elibom.com/services/sendmessagews?wsdl";

	public function setValues($url="", $username="", $password="")
	{
		if($url != "") $this->url = $url;
		if($username != "") $this->username = $username;
		if($password != "") $this->password = $password;
	}

	/**
	* Inserta registro de una acción
	* @param Integer $to número de celular
	* @param String $msg mensaje
	* @param String $metodo Post o SOAP
	*/
	public function send($to, $msg)
	{
		$client = new SoapClient($this->servicio, array('soap_version' => SOAP_1_1));

		if(($to = $this->prepareCell($to)) != false)
		{
			return $client->sendMessage($this->username, $this->password, $to, $msg);
		}

		return false;
		
	}

	public function prepareCell($n)
	{
		if(strlen($n) < 10) return false;

		if(strlen($n) == 10) return $n;

		return substr($n,-10);
	}
}