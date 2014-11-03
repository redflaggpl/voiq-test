<?php
class GPushNotifications extends CApplicationComponent
{
	// TODO finish this component in order to save in db 
	// token etc

	public $apiAccessKey;
	public $debug=false;
	
	private $_urlGCM='https://android.googleapis.com/gcm/send';
	private $_dest=array();

	public function add($key)
	{
		$this->_dest[]=$key;
	}
	
	public function viewAdd()
	{
		return $this->_dest;
	}

	/**
	 * enviar mensajes
	 * Envía los correos de cada componente
	*/

	public function send($id,$title,$message='',$points=array(),$hasPolygon=0)
	{
		if($this->_dest!==array())
		{
			$fields=array('registration_ids'=>$this->_dest,'data'=>array(
				'message'=> array(
					'id'=>$id,
					'title'=>$title,
					'message'=>$message,
					'points'=>$points,
					'hasPolygon'=>$hasPolygon,
				)
			));
			$headers=array(
				'Authorization: key=' . $this->apiAccessKey,
				'Content-Type: application/json'
			);
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,$this->_urlGCM);
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_POSTFIELDS,CJSON::encode($fields));
			$result=curl_exec($ch);
			curl_close($ch);
			$this->_dest=array();
			return CJSON::decode($result);
		}
		return array();
	}

	public function sendReport($title,$message='',$points=array(),$hasPolygon=0)
	{
		if($this->_dest!==array())
		{
			$fields=array('registration_ids'=>$this->_dest,'data'=>array(
				'message'=> array(
					'id'=>null,
					'title'=>$title,
					'message'=>$message,
					'points'=>$points,
					'hasPolygon'=>$hasPolygon,
				),
				'report'=>1,
			));
			$headers=array(
				'Authorization: key=' . $this->apiAccessKey,
				'Content-Type: application/json'
			);
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,$this->_urlGCM);
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
			$result=curl_exec($ch);
			curl_close($ch);
			$this->_dest=array();
			return CJSON::decode($result);
		}
		return array();
	}
}