<?php

class HomeModule extends Module
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		defined('HOME_ID') or define('HOME_ID',$this->id);
		
		$this->setImport(array(
			$this->id.'.models.base.*',
			$this->id.'.models.*',
			$this->id.'.components.*',
		));
	}

	/*
	For more then one link
	*/
	public function menuItems()
	{
		return array(
            array('label'=>$this->labelMenu!==null?$this->labelMenu:Yii::t('app',ucfirst($this->id)), 'icon'=>'fa fa-home', 'url'=>array('/'.$this->id.'/back')),
       );
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

	///////////////////////////////////////////////
	// The follow methos are in order to         //
	// Enabled API documentation                 //
	///////////////////////////////////////////////
	
	/*
	 * Examples in order to show API
	public function builtDocApi()
	{
		return array(
			array(
				'url'=>$this->id.'/api_controller/',
				'method'=>'POST',
				'action'=>'This action is for retrive all info fro current token user',
				'params'=>array(
				    array(
				    	'name'=>'param1',
				    	'description'=>'This params is required',
				    	'defaultValue'=>12,
				    	'required'=>true,
			    	),
				),
				'example_request'=>array(
					"message"=>"Some summary message",
					"param1"=>"2"
				),
				'success_response'=>array(
					"action"=>"The action (e.g. \"barn-unlock\")",
					"success"=>true,
					"message"=>"Some summary message",
					"data"=>"A raw, related piece of data if applicable"
				),
				'error_response'=>array(
				    "error"=> "A key (e.g. access_denied) for the error",
				    "error_description"=> "A longer description of the error"
				),
			),
			// ....	
		);
	}
	*/

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
