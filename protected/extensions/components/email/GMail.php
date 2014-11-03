<?php
class GMail extends CApplicationComponent
{
	public $fromEmail;
	public $fromName;
	private $_dest=array();

	public function add($mail,$name="")
	{
		$this->_dest[$mail]=$name;
	}
	
	public function viewAdd()
	{
		return $this->_dest;
	}

	public function sendBody($subject='Notificación',$context,$priority=null,$view="//site/_email")
	{
		$body=Yii::app()->controller->renderPartial($view,$context,true);
		return $this->send($subject,$body,$priority);
	}

	public function previewBody($context,$priority=null,$view="//site/_email")
	{
		return Yii::app()->controller->renderPartial($view,$context,true);
	}

	public function addFrom($email,$name)
	{
		$this->fromEmail=$email;
		$this->fromName=$name;
	}

	/**
	 * enviarCorreos
	 * Envía los correos de cada componente
	*/

	public function send($subject='Notificación',$body,$priority=null)
	{
		$from=$this->fromEmail;
		$fromName=$this->fromName!==null?$this->fromName:strip_tags(Yii::app()->name);
		foreach($this->_dest as $email=>$name){
			$name='=?UTF-8?B?'.base64_encode($name).'?=';
			$subject='=?UTF-8?B?'.base64_encode($subject).'?=';
			$headers="From: $fromName <{$from}>\r\n".
				"Reply-To: {$from}\r\n".
				"MIME-Version: 1.0\r\n".
				"Content-type: text/html; charset=UTF-8";
			mail($email,$subject,$body,$headers);
		}
		$this->_dest=array();
	}
}