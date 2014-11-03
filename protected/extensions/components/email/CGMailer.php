<?php
require(dirname(__FILE__).'/phpmailer/PHPMailer.php');
class CGMailer extends CApplicationComponent
{



	public $SMTPAuth=true;

	public $Host       = "starbox.co";      			// sets GMAIL as the SMTP server

	public $Port       = 587;                   		// set the SMTP port for the GMAIL server

	public $Username   = "info@starshop.com.co";  					// GMAIL username

	public $Password   = "LOTM.2013";            			// GMAIL password

	public $SMTPSecure = 'tls';            			// SMTP

	public $SMTPDebug = YII_DEBUG;            			// SMTP



	public $template = "_layout_blue";            			// SMTP

	public $templateColor = "#279ed5";# "#8c2c61";            			// SMTP

	public $templateTitle = "Starbox";            			// SMTP

	public $templateLink = "http://starbox.co";            			// SMTP



	public $remit_name="Starbox";

	public $remit_email="info@starshop.com.co";

	public $reply_name="Starbox";

	public $reply_email="info@starbox.com.co";

	public $_dest=array();

	public $_destCC=array();

	public $_destBCC=array();



	private $_c=array();

	private $_transaction=false;

	private $_cant=0;

	private $_mail=null;



	public function beginTransaction()

	{

		$this->_transaction=true;

		return $this;

	}



	public function commit()

	{

		if($this->_transaction)

		{

			$result=array();

			$this->_transaction=false;

			if($this->_c===array())

			{

				Yii::log("COMMIT:gemail vacio:\n ".print_r($this->_c,1),"info","email");

				return $this;

			}



			foreach($this->_c as $i => $data)

			{

				foreach($data['dest'] as $email => $name)

					$this->add($email,$name);

				foreach($data['destCC'] as $email => $name)

					$this->addCC($email,$name);

				foreach($data['destBCC'] as $email => $name)

					$this->addBCC($email,$name);



				$data['result']=$this->send($data['body'],$data['subject'],$data['priority']);

				$data['body']=substr(strip_tags($data['body']),0,40);

				$result[]=$data;

			}

			$this->_c=array();

			$this->_cant=0;

			Yii::log("COMMIT:gemail Resultado de la transaccion de gemail:\n ".print_r($result,1),"info","email");

		}

		return $this;

	}



	public function rollBack()

	{

		$this->_transaction=false;

		$this->clearAllRecipients();

		$result=array();

		foreach($this->_c as $i => $data)

		{

			$data['body']=substr(strip_tags($data['body']),0,40);

			$result[]=$data;

		}

		Yii::log("ROLLBACK:gemail Resultado de la transaccion de gemail:\n ".print_r($result,1),"warning","email");

		$this->_c=array();

		$this->_cant=0;

		return $this;

	}



	public function addFrom($mail,$name="")

	{

		$this->remit_email = $mail;

		$this->remit_name = $name;

	}



	public function add($mail,$name="")

	{

		$this->_dest[$mail]=$name;

	}



	public function addCC($mail,$name="")

	{

		$this->_destCC[$mail]=$name;

	}



	public function addBCC($mail,$name="")

	{

		$this->_destBCC[$mail]=$name;

	}



	public function sendBody($body,$subject='Notificacion Starbox',$priority=1)

	{

		$body=$this->render($this->template,array(

			"content"=>$body,

			"templateLink"=>$this->templateLink,

			"templateTitle"=>$this->templateTitle,

			"templateColor"=>$this->templateColor

		));

		return $this->send($body,$subject,$priority);

	}

	/**

	 * enviarCorreos

	 * Envía los correos de cada componente

	*/

	public function send($body,$subject='Notificacion Starbox',$priority=1)

	{

		if($this->_transaction)

		{

			$this->_c[$this->_cant]['dest']=$this->_dest;

			$this->_c[$this->_cant]['destCC']=$this->_destCC;

			$this->_c[$this->_cant]['destBCC']=$this->_destBCC;

			$this->_c[$this->_cant]['body']=$body;

			$this->_c[$this->_cant]['subject']=$subject;

			$this->_c[$this->_cant]['priority']=$priority;

			$this->_c[$this->_cant]['result']=false;

			$this->_cant++;

			$this->clearAllRecipients();

			return true;

		}



		$mail=$this->getMail();

		$mail->set('X-Priority', $priority);

		$mail->Subject = $subject;

		$mail->MsgHTML($body);



		if($this->_dest===array())

		{

			$this->_dest["sistemas3@starbox.com.co"]="Sistemas3";

			$subject.=" [Se envió sin destinatario]";

			Yii::log("gemail: un correo se intentó envio sin destinatarios principales","warning","email");

		}

		if($this->_dest!==array())

		{

			foreach($this->_dest as $email => $name)

				$mail->AddAddress($email, $name);

		}

		if($this->_destCC!==array())

		{

			foreach($this->_destCC as $email => $name)

				$mail->AddCC($email, $name);



		}

		if($this->_destBCC!==array())

		{

			foreach($this->_destBCC as $email => $name)

				$mail->AddBCC($email, $name);

		}

		$return=false;



		ob_start();

		ob_implicit_flush(false);



		if($mail->Send())

		{

			ob_get_clean();

			$return=true;

		}

		else

		{

			$contenido=ob_get_contents();

			ob_get_clean();

			Yii::log("gemail:[ASUNTO:{$subject}] NO se envio a\n\n destinatarios:".$this->getCorreos($this->_dest)."\n\n copias:".$this->getCorreos($this->_destCC)."\n\n ocultas:".$this->getCorreos($this->_destBCC).get_class($this)." : ".$contenido,"error","email");

			$return=false;

		}

		$this->clearAllRecipients();

		return $return;

	}



	protected function getMail()

	{

		// if($this->_mail===null)

		// {

			$this->_mail = new PHPMailer();

			$this->_mail->PluginDir=dirname(__FILE__).'/phpmailer/';

			if($this->SMTPAuth){

				$this->_mail->IsSMTP(); 								// telling the class to use SMTP

				$this->_mail->SMTPAuth   = $this->SMTPAuth;                  	// enable SMTP authentication

				$this->_mail->Host       = $this->Host;      			// sets GMAIL as the SMTP server

				$this->_mail->Port       = $this->Port;                   		// set the SMTP port for the GMAIL server

				$this->_mail->Username   = $this->Username;  					// GMAIL username

				$this->_mail->Password   = $this->Password;            			// GMAIL password

				$this->_mail->SMTPSecure   = $this->SMTPSecure;            			// SMTP

			}

			/*echo "<pre>";

			print_r($this->_mail);

			echo "</pre>";exit;*/

			$this->_mail->SetFrom($this->remit_email, $this->remit_name);

			$this->_mail->AddReplyTo($this->reply_email, $this->reply_name);

			$this->_mail->CharSet = 'utf8';

		// }

		return $this->_mail;

	}



	protected function getCorreos($correos=array())

	{

		$texto="";

		if($correos===array())

			return "";

		foreach($correos as $i => $v)

			$texto.="[correo:$i=>nombre:$v]\n";



		return $texto;

	}



	protected function clearAllRecipients()

	{

		$this->_dest=array();

		$this->_destCC=array();

		$this->_destBCC=array();

	}





	/**

	 * render

	 * Renderiza la vista correspondiente a cada correo

	 * la cual se ubica en la carpeta components/flujos/views

	*/

	protected function render($view,$data)

	{

		$class=new ReflectionClass(get_class($this));

		$viewFile = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view .'.php';

		extract($data);

		ob_start();

		ob_implicit_flush(false);

		include($viewFile);

		return ob_get_clean();

	}

}