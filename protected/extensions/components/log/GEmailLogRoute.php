<?php
/**
 * CEmailLogRoute class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CEmailLogRoute sends selected log messages to email addresses.
 *
 * The target email addresses may be specified via {@link setEmails emails} property.
 * Optionally, you may set the email {@link setSubject subject}, the
 * {@link setSentFrom sentFrom} address and any additional {@link setHeaders headers}.
 *
 * @property array $emails List of destination email addresses.
 * @property string $subject Email subject. Defaults to CEmailLogRoute::DEFAULT_SUBJECT.
 * @property string $sentFrom Send from address of the email.
 * @property array $headers Additional headers to use when sending an email.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.logging
 * @since 1.0
 */
class GEmailLogRoute extends CEmailLogRoute
{
	public $noUrls=array(
		"robots.txt",
		"/RK=0/RS=",
		"reloadDesafio",
	);
	// public $utf8=true;
	/**
	 * Sends log messages to specified email addresses.
	 * @param array $logs list of log messages
	 */
	protected function processLogs($logs)
	{
		$message="";
		if(!Yii::app()->user->isGuest)
		{
			$user=Users::model()->findByPk(Yii::app()->user->id);
			$message.="[ID USER]".Yii::app()->user->id."\n";
			#$message.="[PROFILE]"."http://www.uniagenda.com/".$user->username."\n";
			// $message.="[IMAGE]".CHtml::image($user->imageUrl,"",array("style"=>"width:20px"))."\n";
			$message.="[NAME]".@Yii::app()->user->name."\n";
			$message.="[EMAIL]".@Yii::app()->user->email."\n";
		}
		$nav1=Yii::app()->getComponent("browser")!==null?Yii::app()->browser->getBrowser():"No component";
		$nav2=Yii::app()->getComponent("browser")!==null?Yii::app()->browser->getVersion():"No component";
		$nav3=Yii::app()->getComponent("browser")!==null?Yii::app()->browser->getPlatform():"No component";
		$country=Yii::app()->getComponent("country")!==null?Yii::app()->country->get():"No component";

		$message.="[GET]".CJSON::encode($_GET)."\n";
		$message.="[POST]".CJSON::encode($_POST)."\n";
		$message.="[BROWSER]".$nav1." Version(".$nav2.") OS(".$nav3.")\n";
		$message.="[AJAX]".Yii::app()->format->boolean(Yii::app()->request->isAjaxRequest)."\n";
		$message.="[URL REQUEST]".Yii::app()->request->getBaseUrl(true).Yii::app()->request->getRequestUri()."\n";
		$message.="[URL REFERER]".Yii::app()->request->getUrlReferrer()."\n";
		$message.="[IP]".Yii::app()->request->getUserHostAddress()."\n";
		$message.="[COUNTRY]{$country}\n";
		$message.="\n\n";
		foreach($logs as $log)
			$message.=$this->formatLogMessage($log[0],$log[1],$log[2],$log[3]);
		$message=wordwrap($message,70);
		$subject=$this->getSubject();
		if($subject===null)
			$subject=Yii::t('yii','Application Log');
		if($this->hasSend(Yii::app()->request->getRequestUri()))
		{
			foreach($this->getEmails() as $email)
				$this->sendEmail($email,$subject,$message);
		}
	}

	protected function hasSend($url)
	{
		// return true;
		foreach($this->noUrls as $data)
		{
			if(strpos($url,$data)!==false)
				return false;
		}
		return true;
	}

	/**
	 * Sends an email.
	 * @param string $email single email address
	 * @param string $subject email subject
	 * @param string $message email content
	 */
	protected function sendEmail($email,$subject,$message)
	{
		Yii::app()->email->add($email);
		Yii::app()->email->send($subject,$message);
	}
}