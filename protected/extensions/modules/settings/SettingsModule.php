<?php

class SettingsModule extends Module
{
	public $defaultController='back';
	public $showMenuFromAdmin=false;

	private $_model;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'settings.models.*',
			'settings.components.*',
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

	
	// methods for to use witout MVC
	public function getModel()
	{
		if($this->_model===null)
			$this->_model=Settings::model()->find(); 
		return $this->_model;
	}

	public function builtHeader($ctr)
	{
		if($this->getModel()!==null)
			Yii::app()->controller->renderPartial('settings.views.back._settings',array('settings'=>$this));
	}

	public function configItems()
	{
		return array(
	    	array('label'=>Yii::t('app','Generals'), 'icon'=>'fa fa-cogs', 'url'=>array('/'.$this->id.'/back')),
		);
	}

	public function builtApp($ctr)
	{

		if(($model=$this->getModel())!==null)
		{
			$freeAccess=array('settings','users','gii','admin','smtp');
			Yii::app()->name=$model->title;
			if($model->offline and is_subclass_of($ctr, 'FrontController') and !in_array($ctr->module->id, $freeAccess))
				Yii::app()->controller->redirect(array('/'.$this->id.'/page/index'));
		}
	}

	public function getTitle()
	{
		if($this->getModel()!==null)
			return $this->getModel()->title;
		return Yii::app()->name;
	}

	public function getEmail()
	{
		if($this->getModel()!==null)
			return $this->getModel()->admin_email;
		return Yii::app()->params['adminEmail'];
	}
}
