<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $allowBasicOAuth=true;
	public $layout='//layouts/column1';
	public $themeBack='base';
	public $themeFront;
	public $title;
	public $subTitle;


	/**
	 * @var tags in order to config the meta tags of
	 * facebook
	 */
	public $fb_title;
    public $fb_type;
    public $fb_url;
    public $fb_image;
    public $fb_site_name;
    public $fb_description;
       
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function init()
	{
		/**
		 * Client languane is updated
		*/
		Yii::app()->language=substr(Yii::app()->request->preferredLanguage,0,2);
		
		/**
		 * Theme front is the apptheme
		*/
		$this->themeFront=Yii::app()->theme;
		

		/**
		 * Importmos jquery
		*/
		Yii::app()->clientScript
		->registerCoreScript( 'jquery' )
		->registerCoreScript( 'jquery.ui' );
		if (Yii::app()->user->loginRequiredAjaxResponse){
		    Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
		    jQuery(document).ajaxComplete(function(event, request, options) {
		            // console.log(event, request, options);
		            if (request.responseText == "'.Yii::app()->user->loginRequiredAjaxResponse.'") {
		                // window.location.href = options.url;
		                window.location.reload(true);
		            }
		        });
		    ');
		}
		$this->builtApp();
	}
	
	public function builtHeader()
	{
		foreach(Yii::app()->getModules() as $name => $config)
     	{
     	 	// if($name=="gii")
     	 	// 	continue;
     	 	$module=Yii::app()->getModule($name);
     	 	if($module===null)
     	 		continue;
     	 	if(method_exists($module,'builtHeader'))
				$module->builtHeader($this);
 	 	}
 	 	// Yii::app()->bootstrap->register();
	}

	public function builtMessages()
	{
		return Yii::app()->user->getFlashes();
	}

	public function builtTitle()
	{
		return Yii::app()->name;
	}

	public function builtUrlLogin()
	{
		return Yii::app()->getModule('users')->urlLogin;
	}

	public function builtUrlProfile()
	{
		return Yii::app()->getModule('users')->urlProfile;
	}

	public function builtUrlRegister()
	{
		return Yii::app()->getModule('users')->urlRegister;
	}

	public function builtUrlLogout()
	{
		return Yii::app()->getModule('users')->urlLogout;
	}

	public function builtUrlHome()
	{
		return $this->createUrl('/');
	}

	public function themeUrl()
	{
		return Yii::app()->theme->baseUrl;
	}

	public function builtEndBody()
	{
		foreach(Yii::app()->getModules() as $name => $config)
     	{
     	 	// if($name=="gii")
     	 	// 	continue;
     	 	$module=Yii::app()->getModule($name);
     	 	if($module===null)
     	 		continue;
     	 	if(method_exists($module,'builtEndBody'))
				$module->builtEndBody($this);
 	 	}
	}

	public function builtApp()
	{
 		foreach(Yii::app()->getModules() as $name => $config)
     	{
     	 	// if($name=="gii")
     	 	// 	continue;
     	 	$module=Yii::app()->getModule($name);
     	 	if($module===null)
     	 		continue;
     	 	if(method_exists($module,'builtApp'))
				$module->builtApp($this);
     	 	if(!function_exists("__" . $name))
     	 		eval("function __" . ($name) . "() { return Yii::app()->getModule('{$name}');}");
		}
	}

	public function builtMenu()
	{
		$items=array();
		foreach(Yii::app()->getModules() as $name => $config)
     	{
     	 	// if($name=="gii")
     	 	// 	continue;
     	 	$module=Yii::app()->getModule($name);
     	 	if($module===null)
     	 		continue;
 	 	 	if($this->hasItems($module)!==false)
 	 	 	{
 	 	 		if($this->hasVisible($module))
 	 	 		{
	 	 	 		foreach($this->hasItems($module) as $itm)
	     	 			$items[]=$itm;
 	 	 		}
 	 	 	}
     	 	else
				$items[]=array('label'=>$this->hasLabel($module), 
					'url'=>$this->hasUrl($module),
					'visible'=>$this->hasVisible($module),
					'icon'=>$this->hasIcon($module)
				);

		}
		$items[]=$this->addConfigsMenu();
		return $items;
	}

	public function addConfigsMenu()
	{
     	$items=array();
		foreach(Yii::app()->getModules() as $name => $config)
     	{
     	 	if($name=="gii")
     	 		continue;
			$module=Yii::app()->getModule($name);
     	 	if($module===null)
     	 		continue;
 	 	 	if($this->hasConfigItems($module)!==false)
				$items=array_merge($this->hasConfigItems($module),$items);
		}
		return array('label'=>Yii::t('app','Settings'),
			'url'=>'#',
			'items'=>$items,
			'visible'=>true,
			'icon'=>'fa fa-cog'
		);
	}

	public function builtDashboardCounters()
	{
		$counters=array();
		foreach(Yii::app()->getModules() as $name => $config)
     	{
     	 	if($name=="gii")
     	 		continue;
     	 	$module=Yii::app()->getModule($name);
     	 	if($module===null)
     	 		continue;
    		if($this->dashboardCountersValide($module)!==false)
				foreach($this->dashboardCountersValide($module) as $count)
					$counters[]=$count;
     	}
     	return $counters;
	}

	public function builtAPIAvailable($moduleName=null)
	{
		$counters=array();
		if($moduleName!==null)
		{
		 	$module=Yii::app()->getModule($moduleName);
     	 	if($module===null)
     	 		return array();
    		if($this->builtDocApi($module)!==false)
				foreach($this->builtDocApi($module) as $count)
					$counters[]=$count;
	    }
		else
		{
			foreach(Yii::app()->getModules() as $name => $config)
	     	{
	     	 	if($name=="gii")
	     	 		continue;
	     	 	$module=Yii::app()->getModule($name);
	     	 	if($module===null)
	     	 		continue;
	    		if($this->builtDocApi($module)!==false)
					foreach($this->builtDocApi($module) as $count)
						$counters[]=$count;
	     	}
		}
     	return $counters;
	}

	public function built($moduleName)
	{
		return Yii::app()->getModule($moduleName);
	}

	public function builtDashboardReports()
	{
		$reports=array();
		foreach(Yii::app()->getModules() as $name => $config)
     	{
     	 	if($name=="gii")
     	 		continue;
     	 	$module=Yii::app()->getModule($name);
     	 	if($module===null)
     	 		continue;
 	 		if($this->dashboardReportsValide($module)!==false)
				foreach($this->dashboardReportsValide($module) as $mod)
					$reports[]=$mod;
		}
	    return $reports;
	}

	protected function hasVisible($module)
	{
 	 	if(method_exists($module,'menuVisible'))
			return $module->menuVisible();
		return true;
	}

	protected function hasItems($module)
	{
		if(method_exists($module,'menuItems') and $module->menuItems()!==false)
			return $module->menuItems();
		return false;
	}

	protected function hasConfigItems($module)
	{
		if(method_exists($module,'configItems') and $module->configItems()!==false)
			return $module->configItems();
		return false;
	}

	protected function hasUrl($module)
	{
		if(method_exists($module,'menuUrl') and $module->menuUrl()!==false)
			return $module->menuUrl();
		return array('/'.$module->id);
	}
	
	protected function hasLabel($module)
	{
		if(method_exists($module,'menuLabel') and $module->menuLabel()!==false)
			return $module->menuLabel();
		return ucfirst($module->id);
	}

	protected function hasIcon($module)
	{
		if(method_exists($module,'menuIcon') and $module->menuIcon()!==false)
			return $module->menuIcon();
		return null;
	}

	protected function dashboardCountersValide($module)
	{
		if(method_exists($module,'dashboardCounters') and $module->dashboardCounters()!==false)
			return $module->dashboardCounters();
		return false;
	}
	
	protected function builtDocApi($module)
	{
		if(method_exists($module,'builtDocApi') and $module->builtDocApi()!==false)
			return $module->builtDocApi();
		return false;
	}

	protected function dashboardReportsValide($module)
	{
		if(method_exists($module,'dashboardReports') and $module->dashboardReports()!==false)
			return $module->dashboardReports();
		return false;
	}

	protected function allowTo($role=array())
	{
		if(empty($role))
			return;
		if(is_string($role))
			$role=array($role);
		foreach($role as $row)
		{
			if(!Yii::app()->user->checkAccess($row))
				throw new CHttpException(403,Yii::t('yii','Login Required'));
		}
	}

	protected function isFrontAction()
	{
		Yii::app()->theme=$this->themeFront;
		$this->layout='//layouts/column1';
	}

	protected function isBackAction()
	{
		// Only front action can access
		// without login
		if(Yii::app()->user->isGuest)
			Yii::app()->user->loginRequired();
		Yii::app()->theme=$this->themeBack;
	}

	public function actionUpload()
    {
    	$uploader=Yii::createComponent('ext.inputs.uploader.GComponentUpload');
		$uploader->upload(array('png','jpg','jpeg','csv','xls','xlsx','doc','docx','pdf','rar','zip','txt','mp4','mp3','mov','swf'),100 * 1024 * 1024);
	}
}