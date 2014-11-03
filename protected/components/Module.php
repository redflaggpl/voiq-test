<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Module extends CWebModule
{
	public $menuConfig=array();
	public $defaultController='page';
    public $showMenuFromAdmin=true;
	
	public $allowAdminTo=array('admin','root');
    public $allowFrontTo=array('admin','root','subscriber');
    
	public function getAllowPermissoms($admin=true)
	{
		if($admin)
			return $this->allowAdminTo;
		return $this->allowFrontTo;
	}

    /*
	 * @labelMenu
	 * Label que aparecera en la parte 
	 * lateral izquierda del menu
	 *
	 */
	public $labelMenu;
	
	public function init()
	{
		$this->controllerMap=array(
			'api'=>array(
				'class'=>'ext.actions.DocApiController'
			),
		);
	}

	/*
	For more then one link
	*/
	public function menuItems()
	{
		if($this->menuConfig!==array())
			return $this->menuConfig;
		return array(
            array('label'=>$this->labelMenu!==null?$this->labelMenu:Yii::t('app',ucfirst($this->id)), 'icon'=>'fa fa-puzzle-piece', 'url'=>array('/'.$this->id.'/back'),'visible'=>__users()->check('root')),
       );
	}

	// this method is called before show left bar menu from de admin
	public function menuIcon()
	{
		return 'fa fa-cog';
	}

	public function menuLabel()
	{
		return Yii::t('app','General Settings');
		// return ucfirst($this->id);
	}
	
	public function menuVisible()
	{
		if(__users()->check($this->getAllowPermissoms()))
			return $this->showMenuFromAdmin;
		return false;
	}


	public function getUrl($absolute=false)
	{
		if($absolute)
			return Yii::app()->createAbsoluteUrl("/".$this->id);
		return Yii::app()->createUrl("/".$this->id);
	}

	public function getUrlBack($absolute=false)
	{
		if($absolute)
			return Yii::app()->controller->createUrl("/".$this->id."/back");
		return Yii::app()->createUrl("/".$this->id."/back");
	}

	public function builtDocApi()
	{
		$result=array();
		$pathDir=Yii::getPathOfAlias($this->id.'.controllers');

		if(is_dir($pathDir) and ($handle = opendir($pathDir))) 
		{
		    $blacklist = array('.', '..', '.gitignore', '.DS_Store');
		    while (false !== ($file = readdir($handle))) 
		    {
		        if (!in_array($file, $blacklist) and strpos($file, ".doc.php")) 
		        {
		            $doc=require(Yii::getPathOfAlias($this->id.'.controllers')."/".$file);
		            foreach($doc as $data) $result[]=$data;
		        }
		    }
		    closedir($handle);
		}
		return $result;
	}
}