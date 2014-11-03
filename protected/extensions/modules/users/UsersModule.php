<?php

class UsersModule extends Module
{

    /**
	 * Para saber si se muestran y habilitan
     * la creacion de aplicaciones en el menu
     * de usurios
    */
	public $copyWelcomeEmail="<p>Hola {{name}}! <br><br> Ya casi terminamos 
			el proceso de registro solo falta confirmar tu correo.</p>";
	
	public $copySendPasswordForgot="<p>Hola {{name}}! <br><br> Esta es tu nueva contraseña:<br>
			 <b>Usuario:</b><em>{{email}}</em><br>
			 <b>Password:</b><em>{{password}}</em><br></p>";
	
	public $copyForgotEmail="<p>Hola {{name}}! <br><br> Ya casi recuperas tu contraseña, 
				por favor sigue este enlace:<br></p>";

	public $copySendPassword="<p>Hola {{name}}! <br><br> Bienvenido a {{appname}} tus datos de ingreso son:<br>
			<b>Usuario:</b><em>{{email}}</em><br>
			<b>Password:</b><em>{{password}}</em><br></p>";
	

	public $enableOAuth=false;
	

	public $allowBasicOAuth=false;
	
	/**
	 * Para loguear al usuario un a vez este
     * se registra y no tener que esperar si
     * confirmo correo o no
    */
	public $loginInRegister=false;
	
	/**
	 * @sendPassword
	 * Es para usar la modalidad de resgistro 
	 * de usuarios con envío de password
	 * si este campo es falso es necesario que en el 
	 * formulario de registro el usuario ingrese su contraseña
	*/
	public $sendPassword=false;
	
	/**
	 * Particularmente es para saber donde se hace el redirect
	 * despues del login por ejemplo aunque podria tener mas
	 * utilidades mas adelante
	*/
	public $adminRoles=array('admin','root');

	// Urls for put on home or other modules if you need 
	public $urlProfile=array("/users/page/profile");
	
	public $urlLogin=array("/users/page/login");
	
	public $urlRegister=array("/users/page/register");
	
	public $urlLogout=array("/users/page/logout");
	
	public $urlForgot=array("/users/page/forgot");
	
	public $urlAdminProfile=array("/users/users/profile");
	
	public function getToLogin()
	{
		return CHtml::normalizeUrl($this->urlLogin);
	}
	
	public function getToRegister()
	{
		return CHtml::normalizeUrl($this->urlRegister);
	}

	public function getToForgot()
	{
		return CHtml::normalizeUrl($this->urlForgot);
	}
	
	public function getToProfile()
	{
		return CHtml::normalizeUrl($this->urlProfile);
	}
	
	public function getToLogout()
	{
		return CHtml::normalizeUrl($this->urlLogout);
	}
	
	// Redirects
	public $redirectLogin=array("/");
	
	public $redirectLoginAdmin=array("/admin");
	
	public $redirectLogout=array("/");
	
	public $redirectLogoutAdmin=array("/users/users/login");
	
	// Enabled create news roles
	public $canCreateRoles=false;

	// deprecated
	public $subMenu=false;
	
	private $_config;
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'users.models.base.*',
			'users.models.*',
			'users.components.*',
		));

		if($this->_config===null)
			$this->_config=UsersConfig::model()->find();
	
		if($this->_config!==null)
		{
			$this->enableOAuth=($this->_config->enableOAuth!==null)?$this->_config->enableOAuth:$this->enableOAuth;
			$this->loginInRegister=($this->_config->loginInRegister!==null)?$this->_config->loginInRegister:$this->loginInRegister;
			$this->labelMenu=($this->_config->labelMenu!==null)?$this->_config->labelMenu:$this->labelMenu;
			$this->sendPassword=($this->_config->sendPassword!==null)?$this->_config->sendPassword:$this->sendPassword;
			$this->showMenuFromAdmin=($this->_config->showMenuFromAdmin!==null)?$this->_config->showMenuFromAdmin:$this->showMenuFromAdmin;
			$this->allowBasicOAuth=($this->_config->allowBasicOAuth!==null)?$this->_config->allowBasicOAuth:$this->allowBasicOAuth;
			$this->copyWelcomeEmail=($this->_config->copyWelcomeEmail!==null)?$this->_config->copyWelcomeEmail:$this->copyWelcomeEmail;
			$this->copySendPasswordForgot=($this->_config->copySendPasswordForgot!==null)?$this->_config->copySendPasswordForgot:$this->copySendPasswordForgot;
			$this->copyForgotEmail=($this->_config->copyForgotEmail!==null)?$this->_config->copyForgotEmail:$this->copyForgotEmail;
			$this->copySendPassword=($this->_config->copySendPassword!==null)?$this->_config->copySendPassword:$this->copySendPassword;
		}
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

	public function builtEndBody($ctr)
	{
		Yii::app()->clientScript->registerScript('',"
			$(document).on('click','.module-users-login',function(e){
				e.preventDefault();
				$('#profileModal').modal('hide');
				$('#registerModal').modal('hide');
				$('#forgotModal').modal('hide');
				$('#loginModal').modal('show');
			});	

			$(document).on('click','.module-users-register',function(e){
				e.preventDefault();
				$('#profileModal').modal('hide');
				$('#loginModal').modal('hide');
				$('#forgotModal').modal('hide');
				$('#registerModal').modal('show');
			});	

			$(document).on('click','.module-users-forgot',function(e){
				e.preventDefault();
				$('#profileModal').modal('hide');
				$('#registerModal').modal('hide');
				$('#loginModal').modal('hide');
				$('#forgotModal').modal('show');
			});	

			$(document).on('click','.module-users-profile',function(e){
				e.preventDefault();
				$('#registerModal').modal('hide');
				$('#loginModal').modal('hide');
				$('#forgotModal').modal('hide');
				$('#profileModal').modal('show');
			});	
		");
		Yii::app()->controller->renderPartial($this->id.'.views.page._register',array('model'=>new Users("signup"),'ctr'=>$ctr,'module'=>$this));
		Yii::app()->controller->renderPartial($this->id.'.views.page._login',array('model'=>new LoginForm,'ctr'=>$ctr,'module'=>$this));
		Yii::app()->controller->renderPartial($this->id.'.views.page._forgot',array('model'=>new ForgotForm,'ctr'=>$ctr,'module'=>$this));
		
		$currentUser=new Users;
		if(!Yii::app()->user->isGuest)
			$currentUser=Users::model()->findByPk(Yii::app()->user->id);
		Yii::app()->controller->renderPartial($this->id.'.views.page._profile',array('user'=>$currentUser,'ctr'=>$ctr,'module'=>$this));
	}

	public function listRoles($currentUser=false)
	{
		$result=array();
		foreach(Yii::app()->authManager->getAuthItems() as $data)
		{
 			if($currentUser)
 			{
 				if(Yii::app()->user->checkAccess($data->name))
 					$result[$data->name]=$data->name;
 			}
 			else
 				$result[$data->name]=$data->name;
 		}
		return $result;
	}


	public function sendRegisterMail($model,$resend=false)
	{
		if($model===null)
			return false;
		if($this->sendPassword)
		{
			$model->password=sha1($pass=Yii::app()->security->randomWord(4));
			$model->save(true,array('password'));

			$body=$this->copySendPassword;
			$body=strtr($body,array(
				'{{name}}'=>$model->name,
				'{{lastname}}'=>$model->lastname,
				'{{appname}}'=>strip_tags(Yii::app()->name),
				'{{fullname}}'=>$model->name." ".$model->lastname,
				'{{email}}'=>$model->email,
				'{{password}}'=>$pass,
			));
			$contex=array(
				"body"=>$body,
			);
			Yii::app()->email->add($model->email,$model->name);
			return Yii::app()->email->sendBody(Yii::t('app','Your credentials').' '.strip_tags(Yii::app()->name),$contex);
		}
		else
		{
			$resendMessage='';
			if($resend)
				$resendMessage=Yii::t('app','RESENDED').' ';
			$body=$this->copyWelcomeEmail;
			$body=strtr($body,array(
				'{{name}}'=>$model->name,
				'{{lastname}}'=>$model->lastname,
				'{{appname}}'=>strip_tags(Yii::app()->name),
				'{{fullname}}'=>$model->name." ".$model->lastname,
				'{{email}}'=>$model->email,
			));
			$contex=array(
				"body"=>$body,
				"label"=>Yii::t('app','Confirm email'),
				"url"=>Yii::app()->createAbsoluteUrl("/users/page/confirm",array(
					"key"=>Yii::app()->security->encrypt($model->email
				))),
			);
			Yii::app()->email->add($model->email,$model->name);
			return Yii::app()->email->sendBody($resendMessage.Yii::t('app','Confirm register on').' '.strip_tags(Yii::app()->name),$contex);
		}	
	}

	public function sendForgotMail($model)
	{
		if($this->sendPassword)
		{
			$model->password=sha1($pass=Yii::app()->security->randomWord(4));
			$model->save(true,array('password'));
			
			$body=$this->copySendPasswordForgot;
			$body=strtr($body,array(
				'{{name}}'=>$model->name,
				'{{lastname}}'=>$model->lastname,
				'{{appname}}'=>strip_tags(Yii::app()->name),
				'{{fullname}}'=>$model->name." ".$model->lastname,
				'{{email}}'=>$model->email,
				'{{password}}'=>$pass,
			));

			$contex=array(
				"body"=>$body,
			);
			Yii::app()->email->add($model->email,$model->name);
			return Yii::app()->email->sendBody(Yii::t('app','New password').' '.strip_tags(Yii::app()->name),$contex);
		}
		else
		{
			$body=$this->copyForgotEmail;
			$body=strtr($body,array(
				'{{name}}'=>$model->name,
				'{{lastname}}'=>$model->lastname,
				'{{appname}}'=>strip_tags(Yii::app()->name),
				'{{fullname}}'=>$model->name." ".$model->lastname,
				'{{email}}'=>$model->email,
			));

			$contex=array(
				"body"=>$body,
				"label"=>Yii::t('app','Go to change password'),
				"url"=>Yii::app()->createAbsoluteUrl("/users/page/password",array("key"=>Yii::app()->security->encrypt($model->email))),
			);
			Yii::app()->email->add($model->email,$model->name);
			return Yii::app()->email->sendBody(Yii::t('app','Recover password').' '.strip_tags(Yii::app()->name),$contex);
		}
		return false;	
	}

	public function encryptEmail($decriptEmail)
	{
		return Yii::app()->security->encrypt($decriptEmail);
	}

	public function decryptEmail($encriptEmail)
	{
		return Yii::app()->security->decrypt($encriptEmail);
	}

	/*
	For more then one link
	You can also to use 'items'=>array('label'=>'My other link'...)
	until two levels
	*/
	public function menuItems()
	{
		if($this->enableOAuth)
		{
			return array(
	            array('label'=>$this->labelMenu!==null?$this->labelMenu:Yii::t('app','Users'), 'icon'=>'fa fa-user', 'url'=>'#','items'=>array(
	        		array('label'=>Yii::t('app','Users system'), 'icon'=>'fa fa-users', 'url'=>array('/'.$this->id.'/users')),
    		        array('label'=>Yii::t('app','Welcome email copies'), 'icon'=>'fa fa-envelope', 'url'=>array('/'.$this->id.'/email_welcome')),
    		        array('label'=>Yii::t('app','Password email copies'), 'icon'=>'fa fa-envelope', 'url'=>array('/'.$this->id.'/email_password')),
    		        array('label'=>Yii::t('app','Profiles system'), 'icon'=>'fa fa-sitemap', 'url'=>array('/'.$this->id.'/profiles/admin'),'visible'=>Yii::app()->user->check('root')),
	        		array('label'=>Yii::t('app','Applications'), 'icon'=>'fa fa-mobile', 'url'=>array('/'.$this->id.'/apps'),'visible'=>Yii::app()->user->check('root')),
    		        array('label'=>Yii::t('app','API'), 'icon'=>'fa fa-code', 'url'=>array('/'.$this->id.'/api'),'visible'=>Yii::app()->user->check('root')),
      
	        	)),
	        );
		}
		return array(
            array('label'=>$this->labelMenu!==null?$this->labelMenu:Yii::t('app','Users system'), 'icon'=>'fa fa-users', 'url'=>array('/'.$this->id.'/users')),
        );
	}
	
	public function validateAjaxLogin($model,$formID='login-form-other')
	{
		// if it is ajax validation request
		if((isset($_POST['ajax']) && $_POST['ajax']==='login-form') or
			(isset($_POST['ajax']) && $_POST['ajax']===$formID))
		{
			if($model->getErrors()!==array())
			{
				foreach($model->getErrors() as $attribute=>$errors)
					$result[CHtml::activeId($model,$attribute)]=$errors;	
				echo CJSON::encode($result);
				Yii::app()->end();
			}
		}
	}

	public function validateAjaxSignUp($model,$formID='registration-form')
	{
		// if it is ajax validation request
		if((isset($_POST['ajax']) && $_POST['ajax']==='signup-form') or
			(isset($_POST['ajax']) && $_POST['ajax']===$formID))
		{
			if($model->getErrors()!==array())
			{
				foreach($model->getErrors() as $attribute=>$errors)
					$result[CHtml::activeId($model,$attribute)]=$errors;	
				echo CJSON::encode($result);
				Yii::app()->end();
			}
		}
	}

	public function actionLogin()
	{
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			return $model->validate() && $model->login();
		}
		return false;
	}

	public function loadModel()
	{
		if(!Yii::app()->user->isGuest)
			return Users::model()->findByPk(Yii::app()->user->id);
		return null;
	}

	public function getListUsers()
	{
		return CHtml::listData(Users::model()->findAll('state=1'),'id','fullname');
	}

	public function check($roles=null)
	{
		$args=func_get_args();
		if($args!==array() and count($args)>1)
			$roles=$args;
		return Yii::app()->user->check($roles);
	}
	
	public function getName()
	{
		return Yii::app()->user->name;
	}

	public function getEmail()
	{
		return Yii::app()->user->email;
	}

	public function configItems()
	{
		return array(
	    	array('label'=>Yii::t('app','Users'), 'icon'=>'fa fa-cogs', 'url'=>array('/'.$this->id.'/config'),'visible'=>$this->check('root')),
		);
	}

	public function builtApp($ctr)
	{
		// if($this->_config===null)
		// 	$this->_config=UsersConfig::model()->find();
	
		// if($this->_config!==null)
		// {
		// 	$this->enableOAuth=($this->_config->enableOAuth!==null)?$this->_config->enableOAuth:$this->enableOAuth;
		// 	$this->loginInRegister=($this->_config->loginInRegister!==null)?$this->_config->loginInRegister:$this->loginInRegister;
		// 	$this->labelMenu=($this->_config->labelMenu!==null)?$this->_config->labelMenu:$this->labelMenu;
		// 	$this->sendPassword=($this->_config->sendPassword!==null)?$this->_config->sendPassword:$this->sendPassword;
		// 	$this->showMenuFromAdmin=($this->_config->showMenuFromAdmin!==null)?$this->_config->showMenuFromAdmin:$this->showMenuFromAdmin;
		// 	$this->allowBasicOAuth=($this->_config->allowBasicOAuth!==null)?$this->_config->allowBasicOAuth:$this->allowBasicOAuth;
		// 	$this->copyWelcomeEmail=($this->_config->copyWelcomeEmail!==null)?$this->_config->copyWelcomeEmail:$this->copyWelcomeEmail;
		// 	$this->copySendPasswordForgot=($this->_config->copySendPasswordForgot!==null)?$this->_config->copySendPasswordForgot:$this->copySendPasswordForgot;
		// 	$this->copyForgotEmail=($this->_config->copyForgotEmail!==null)?$this->_config->copyForgotEmail:$this->copyForgotEmail;
		// 	$this->copySendPassword=($this->_config->copySendPassword!==null)?$this->_config->copySendPassword:$this->copySendPassword;
		// }
	}
}