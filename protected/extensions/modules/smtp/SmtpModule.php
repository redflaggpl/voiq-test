<?php

class SmtpModule extends Module
{
    public $showMenuFromAdmin=false;
	private $_model;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		defined('SMTP_ID') or define('SMTP_ID',$this->id);
		
		$this->setImport(array(
			$this->id.'.models.*',
			$this->id.'.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	public function configItems()
	{
		return array(
	    	array('label'=>ucfirst($this->id), 'icon'=>'fa fa-cogs', 'url'=>array('/'.$this->id.'/back'),'visible'=>__users()->check('root')),
		);
	}

	/**
	 *
	 * Metodos de uso para modulos de confuguracion
	*/
	// methods for to use witout MVC
	public function getModel()
	{
		if($this->_model===null)
			$this->_model=SmptConfig::model()->find(); 
		return $this->_model;
	}

	public function builtApp($ctr)
	{
		if(($model=$this->getModel())!==null)
		{
			if(Yii::app()->email!==null and $model->enabled)
			{
				Yii::app()->email->SMTPAuth=true;
				Yii::app()->email->Host=$model->host_email_server;
				Yii::app()->email->Port=$model->port_email_server;
				Yii::app()->email->fromEmail=$model->username_email_server;
				Yii::app()->email->fromName=Yii::app()->name;
				Yii::app()->email->Username=$model->username_email_server;
				Yii::app()->email->Password=$model->password_email_server;
			}
			if(!$model->enabled)
				Yii::app()->email->SMTPAuth=false;
		}
	}

	public function getTemplatesAvailables()
	{
		$templates=array();
		$pathDir=Yii::getPathOfAlias('application.templates');

		if(is_dir($pathDir) and ($handle = opendir($pathDir))) 
		{
		    $blacklist = array('.', '..', '.gitignore');
		    while (false !== ($file = readdir($handle))) 
		    {
		        if (!in_array($file, $blacklist)) {
		            $templateName=strtr($file,array('.php'=>''));
		            $templates[]=$templateName;
		        }
		    }
		    closedir($handle);
		}
		return $templates;
	}

	///////////////////////////////////////////////
	// The follow methos are in order to         //
	// Enabled menues on the left side bar admin //
	///////////////////////////////////////////////

	/*
	 * Examples in order to show reports in dashboard
	public function dashboardCounters()
	{
		return array(
            array('label'=>'New Orders', 'type'=>'info', 'icon'=>'fa fa-cog', 'count'=>'150', 'url'=>array('/'.$this->id.'/back')),
            array('label'=>'Bounce Rate', 'type'=>'success', 'icon'=>'fa fa-shopping-cart', 'count'=>'40', 'url'=>array('/'.$this->id.'/back')),
            array('label'=>'User Registrations', 'type'=>'warning', 'icon'=>'fa fa-user', 'count'=>'44', 'url'=>array('/'.$this->id.'/back')),
            array('label'=>' Unique Visitors ', 'type'=>'danger', 'icon'=>'fa fa-eye', 'count'=>'60', 'url'=>array('/'.$this->id.'/back')),
		);
	}

	public function dashboardReports()
	{
		return array(
            array('label'=>'New Orders', 'type'=>'danger', 'icon'=>'fa fa-cog', 'content'=>$this->loadOrders(), 'url'=>array('/'.$this->id)),
        );
	}

	public function loadOrders()
	{
		// Load here your html 
		// You can call all the models of this module
		// and create your own html for report
		return '<em>Hola orders</em>';
	}
	*/
	
}
