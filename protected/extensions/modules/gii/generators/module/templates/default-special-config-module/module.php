<?php echo "<?php\n"; ?>

class <?php echo $this->moduleClass; ?> extends Module
{
    public $showMenuFromAdmin=false;
	private $_model;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		defined('<?php echo strtoupper($this->moduleID); ?>_ID') or define('<?php echo strtoupper($this->moduleID); ?>_ID',$this->id);
		
		$this->setImport(array(
			$this->id.'.models.base.*',
			$this->id.'.models.*',
			$this->id.'.components.*',
		));
		parent::init();
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
	    	array('label'=>ucfirst($this->id), 'icon'=>'fa fa-cogs', 'url'=>array('/'.$this->id.'/back')),
		);
	}

	/**
	 * Methods for retrive a record of a model that you are and
	 * everybody wants to use on anywhere of application
	public function getModel()
	{
		if($this->_model===null)
			$this->_model=YourModelName::model()->find(); 
		return $this->_model;
	}

	public function builtHeader($ctr)
	{
		if($this->isEnabled())
			Yii::app()->controller->renderPartial($this->id.'.views.back._someview',array('module'=>$this));
	}

	public function builtApp($ctr)
	{
		if(($model=$this->getModel())!==null)
		{
			// set app's variables for example
			//Yii::app()->name=$model->myownfield;
		}
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
