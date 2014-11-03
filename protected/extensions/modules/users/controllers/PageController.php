<?php
class PageController extends FrontController
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('profile','changePassword'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('resendVerify','confirm','password','forgot','logout','login','register'),
				// 'roles'=>array('admin'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionResendVerify()
	{
		$model=Users::model()->find("email=? AND papelera=0 AND state=1",array($_GET['email']));
		if($this->module->sendRegisterMail($model,true))
		{
			$message="<h4>{$model->name}!</h4>
			<p>".Yii::t('app','We have forwarded your mail <strong>{email}</strong> a link to confirm, if it is not in your inbox please check your spam folder',array('{email}'=>$model->email))."</p>";
			Yii::app()->user->setFlash('success',$message);
		}
		else
		{
			$message="<h4>".Yii::t('app','Email not found')."</h4>
			<p>".Yii::t('app','Your email <strong>{email}</strong> not found on owr database',array("{email}"=>isset($_GET['email'])?$_GET['email']:''))."</p>";
			Yii::app()->user->setFlash('danger',$message);
		}
	
		$this->redirect($this->module->redirectLogout);
		// old implement
		// $this->render('resendVerify',array(
		// 	'model'=>$model,
		// 	'sended'=>$this->module->sendRegisterMail($model,true),
		// ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionConfirm()
	{
		if(!isset($_GET['key']))
			throw new CHttpException(403,Yii::t('app',"Petición inválida"));
		
		$email=$this->module->decryptEmail($_GET['key']);
		$model=Users::model()->find("email=?",array($email));
		if($model===null)
			throw new CHttpException(404,Yii::t('app',"Petición inválida"));
		$model->state_email=1;
		if($model->save(true,array("state_email")))
		{
			$model->login();
			Yii::app()->user->setFlash("success","Hola ".$model->name."!! Bienvenido a ".strip_tags(Yii::app()->name));
			$this->redirect($this->module->redirectLogin);
		}
		else
			throw new CHttpException(500,Yii::t('app',"Se ha presentado un inconveniente y no se pudo verificar su correo."));
	}

	/**
	 * Displays the login page
	 */
	public function actionPassword()
	{
		if(!Yii::app()->user->isGuest)
			Yii::app()->user->logout();

		if(!isset($_GET['key']))
			throw new CHttpException(404,"Petición inválida");
			
		$email=Yii::app()->security->decrypt($_GET['key']);
		$model=new PasswordForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['PasswordForm']))
		{
			$model->attributes=$_POST['PasswordForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate())
			{
				$user=Users::model()->find("email=? AND papelera=0",array($email));
				$user->password=sha1($model->password);
				$user->save(true,array("password"));
				Yii::app()->user->setFlash("success","Contraseña actualizada correctamente.<br>".$user->email);
				$this->redirect(array("login","key"=>$_GET['key']));
			}
		}

		$this->render('password',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Displays the login page
	 */
	public function actionChangePassword()
	{
		$model=new ChangePasswordForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='change-password-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['ChangePasswordForm']))
		{
			$model->attributes=$_POST['ChangePasswordForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate())
			{
				$user=Users::model()->findByPk(Yii::app()->user->id);
				$user->password=sha1($model->newPassword);
				$user->save(true,array("password"));
				Yii::app()->user->setFlash("success","Contraseña actualizada correctamente.");
				$this->redirect(Yii::app()->request->urlReferrer);
			}
		}

		$this->render('change_password',array(
			'model'=>$model,
		));
	}

	 /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionProfile()
    {
    	if(Yii::app()->user->isGuest and Yii::app()->request->isAjaxRequest)
    	{
    		echo Yii::app()->user->loginRequiredAjaxResponse;
			Yii::app()->end();
    	}
    	if(Yii::app()->user->isGuest)
    		throw new CHttpException(403,"Inicio de sesón es necesario.");
    		
        $user=Users::model()->findByPk(Yii::app()->user->id);
        
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($user);

        if(isset($_POST['Users']))
        {
            $user->attributes=$_POST['Users'];
            if(isset($_POST['Users']['newPassword']))
            	$user->newPassword=$_POST['Users']['newPassword'];
            
            if($user->birthdate=="")
        		$user->birthdate=null;

            if($user->save())
            {
            	if(!empty($user->newPassword))
            	{
            		$user->password=sha1($user->newPassword);
            		$user->save(true,array('password'));
            	}
            
            	Yii::app()->user->setFlash("success",'Perfil actualizado correctamente');
                $this->refresh(Yii::app()->request->urlReferrer);
            }
        }

        $this->render('profile',array(
            'user'=>$user,
        ));
    }

	public function actionForgot()
	{
		$model=new ForgotForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='recover-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['ForgotForm'])) {
			$model->attributes=$_POST['ForgotForm'];
			if ($model->validate()) 
			{
				$user=Users::model()->find("email=? AND papelera=0",array($model->email));
				if($this->module->sendForgotMail($user))
				{
					if($this->module->sendPassword)
						$mensaje='<p><strong>Datos enviados!!</strong> Hemos enviado a tu correo tu nueva contraseña.';
					else
						$mensaje='<p><strong>Datos enviados!!</strong> Hemos enviado a tu correo las instrucciones para recuperar tu contraseña.';
					$mensaje.='<br>'.$model->email.'.</p>';
        			Yii::app()->user->setFlash("success",$mensaje);
				}
				else
				{
					$mensaje='<p><strong>Error al enviar el correo!!</strong> Por favor intente más tarde.';
					$mensaje.='<br>'.$model->email.'.</p>';
        			Yii::app()->user->setFlash("danger",$mensaje);
				}
				$this->redirect($this->module->redirectLogin);
			}
		}

		$this->render('forgot',array(
			"model"=>$model,
		));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		// if(Yii::app()->user->isGuest)
		// $this->layout='//layouts/login';
		$model=new LoginForm;

		// if it is ajax validation request
		if((isset($_POST['ajax']) && $_POST['ajax']==='login-form') or
			(isset($_POST['ajax']) && $_POST['ajax']==='login-form-shopping'))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				/**
				 * Si la atenticacion es de tipo enviar contraseña
				 * entonces cuando se loguea es la unica forma en que
				 * asumismos que su correo existe, porque siempre
				 * se envian las contraseñas al correo
				*/
				if($this->module->sendPassword)
				{
					$user=Users::model()->findByPk(Yii::app()->id);
					$user->state_email=1;
					$user->save(true,array('state_email'));
				}
					
				if(!Yii::app()->user->isGuest and Yii::app()->user->checkAccessArray($this->module->adminRoles))
					$this->redirect($this->module->redirectLoginAdmin);
				else
					$this->redirect($this->module->redirectLogin);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	// @todo this actions can be in user module
	/**
	 * Displays the login page
	 */
	public function actionRegister()
	{
		// $this->layout='//layouts/login';
		$model=new Users("signup");

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$model->registered=date('Y-m-d H:i:s');
			$model->state_email=0;
			$model->state=1;
			$model->papelera=0;
			$model->conditions=$_POST['Users']['conditions'];
			$model->username=Yii::app()->format->trimAndLower($model->name).'.'.Yii::app()->format->trimAndLower($model->lastname);
			// print_r($model);
			// exit;
			if($this->module->sendPassword)
				$model->password=sha1($model->username);
			
			if ($model->validate()) 
			{
				$model->password=sha1($model->password);
				$model->save();
				
				if($this->module->sendRegisterMail($model))
				{
					if($this->module->loginInRegister)
					{
						$model->login();
						Yii::app()->user->setFlash("success","Hola {$model->name}! Registro exitoso, Bienvenido a ".strip_tags(Yii::app()->name).".");
					}
					else
					{
						if($this->module->sendPassword)
							Yii::app()->user->setFlash("success","Hola {$model->name}! Registro exitoso, Hemos enviado a tu correo tus datos de ingreso. {$model->email}");
						else
							Yii::app()->user->setFlash("success","Hola {$model->name}! Por favor revisa tu correo electrónico para terminar el proceso de registro. {$model->email}");
					}
				}
				else
				{
					$model->papelera=1;
					$model->save(true,array('papelera'));
					Yii::app()->user->setFlash("danger","Error al enviar el correo de confirmación, por favor intenta mas tarde.");
				}
				$this->redirect($this->module->redirectLogin);
			}
		}
		// display the login form
		$this->render('register',array(
			'model'=>$model
		));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect($this->module->redirectLogout);
	}

	//////////////////////////
	// Methods reutilizable //
	//////////////////////////
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	//////////////////////////////////
	// OAUTH2 Implementation method //
	//////////////////////////////////

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionToken()
	{
		$grant_type=isset($_REQUEST['grant_type'])?$_REQUEST['grant_type']:'authorization_code';
		$client_id=isset($_REQUEST['client_id'])?$_REQUEST['client_id']:null;
		$client_secret=isset($_REQUEST['client_secret'])?$_REQUEST['client_secret']:null;
		$code=isset($_REQUEST['code'])?$_REQUEST['code']:null;
		$web_generate=isset($_GET['web_generate']);
		$param=array();
	
		if($client_id===null or $client_secret===null)
		{
			$param=array(
				'error'=>'access_denied',
				'error_description'=>"client_secret and client_id is required",
			);
			$this->endRequest($param,false);
		}

		$model=Apps::model()->find('client_id=? AND client_secret=?',array($client_id,$client_secret));
		if($model===null)
		{
			$param=array(
				'error'=>'access_denied',
				'error_description'=>"Application with this client id has been deleted",
			);
			$this->endRequest($param,false);
		}
		
		if($grant_type!=='code' and $grant_type!=='client_credentials' and $grant_type!=='authorization_code')
		{
			$param=array(
				'error'=>'access_denied',
				'error_description'=>"Invalid grant_type: '{$grant_type}'. Supported types: authorization_code, client_credentials",
			);
			$this->endRequest($param,$model);
		}
			
		$token=new AccessTokens;
		$token->acces_token=Yii::app()->security->randomWord(40);
		$token->acces_token_refresh=Yii::app()->security->randomWord(60);
		$token->apps_id=$model->id;
		
		if($grant_type==='client_credentials')
			$token->users_id=$model->users_id;
		else if(($grant_type==='authorization_code' and $code===null) or ($grant_type==='code' and $code===null))
		{
			$param=array(
				'error'=>'access_denied',
				'error_description'=>"In code grant type autorization code is required",
			);
			$this->endRequest($param,$model);
		}
		else
		{
			$codeAuth=CodeAuth::model()->find('code=?',array($code));
			if($codeAuth===null)
			{
				$param=array(
					'error'=>'access_denied',
					'error_description'=>"Authorization code is not valid",
				);
				$this->endRequest($param,$model);
			}
			$token->users_id=$codeAuth->users_id;
			$token->code=$codeAuth->code;
		}
		if($token->save() and !$web_generate)
		{
			$param=array(
				'access_token'=>$token->acces_token,
				'token_refresh'=>$token->acces_token_refresh,
				'token_type'=>'Bearer',
				'expires_in'=>86400,
				'scope'=>'grant',
			);	
			$this->endRequest($param,$model);
		}
    
		$this->render('token',array(
			'token'=>$token,
		));
	}

	
	public function endRequest($param,$model=false)
	{
		$web_generate=isset($_GET['web_generate']);
		if($model===false)
		{
			if(Yii::app()->request->isPostRequest)
			{
				header('Access-Control-Allow-Origin: *');
				header('Content-Type: application/json');
				echo CJSON::encode($param);
				Yii::app()->end();
			}

			$message='';
			foreach($param as $key => $value)
				$message.=$key.': '.$value;
			throw new CHttpException(403,$message);
		}

		if(Yii::app()->request->isPostRequest)
		{
			header('Access-Control-Allow-Origin: *');
			header('Content-Type: application/json');
			echo CJSON::encode($param);
			Yii::app()->end();
		}
		
		if(!$web_generate)
		{
			$param_redirect_uri=isset($_REQUEST['redirect_uri'])?$_REQUEST['redirect_uri']:null;
			$redirect_uri='';
			if($param_redirect_uri!==null)
				$redirect_uri=urldecode($param_redirect_uri);
			else
			{
				if(!empty($model->redirect_uri))
					$redirect_uri=$model->redirect_uri;
				else
					throw new CHttpException(403,"No redirect URI was supplied or stored");
			}
			if(strpos($redirect_uri, '?')!==false)
				$this->redirect($redirect_uri.'&'.http_build_query($param));
			else
				$this->redirect($redirect_uri.'?'.http_build_query($param));
		}

		$message='';
		foreach($param as $key => $value)
			$message.=$key.': '.$value;
		throw new CHttpException(403,$message);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionAuthorize()
	{

		$app=Apps::model()->find('client_id=?',array($_REQUEST['client_id']));
		if($app===null)
			throw new CHttpException(404,"Application with this client id has been deleted");
		
		$model=new LoginForm;

		// if it is ajax validation request
		if((isset($_POST['ajax']) && $_POST['ajax']==='login-form') or
			(isset($_POST['ajax']) && $_POST['ajax']==='login-form-shopping'))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->refresh();
		}

		$this->render('authorize',array(
			'model'=>$model,
			'app'=>$app,
			'params'=>$_REQUEST,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionAuthorizeSubmit()
	{

		$model=Apps::model()->find('client_id=?',array($_REQUEST['client_id']));
		if($model===null)
			throw new CHttpException(404,"Application with this client id has been deleted");
		
		if(Yii::app()->user->isGuest)
		{
			Yii::app()->user->setFlash('error','You need login before this action.');
			$this->redirect(array('authorize'));
		}

		if(isset($_REQUEST['authorize']) and $_REQUEST['authorize']==1) // save and validate login
		{
			$code=new CodeAuth;
			$code->users_id=Yii::app()->user->id;
			$code->code=Yii::app()->security->randomWord(40);
			$code->created_at=date('Y-m-d H:i:s');
			$code->save();
			// var_dump($code);
			
			if(isset($_REQUEST['response_type']) and $_REQUEST['response_type']==='token')
			{
				$token=new AccessTokens;
				$token->acces_token=Yii::app()->security->randomWord(40);
				$token->acces_token_refresh=Yii::app()->security->randomWord(60);
				$token->apps_id=$model->id;
				
				$token->users_id=$code->users_id;
				$token->code=$code->code;
				
				$token->save();
			}

			
			$param=array();
			if(isset($_REQUEST['response_type']) and $_REQUEST['response_type']==='token')
				$param=array('acces_token'=>$token->acces_token);
			if(isset($_REQUEST['response_type']) and $_REQUEST['response_type']==='code')
				$param=array('code'=>$code->code);
		}
		else
		{
			$param=array(
				'error'=>'access_denied',
				'error_description'=>'The+user+denied+access+to+your+application'
			);
			// error: "insufficient_scope"
			// error_description: "The request requires higher privileges than provided by the access token"
		}

		$redirect_uri='';
		if(isset($_REQUEST['redirect_uri']))
			$redirect_uri=urldecode($_REQUEST['redirect_uri']);
		else
		{
			if(!empty($model->redirect_uri))
				$redirect_uri=$model->redirect_uri;
			else
				throw new CHttpException(403,"No redirect URI was supplied or stored");
		}
		if(strpos($redirect_uri, '?')!==false)
			$this->redirect($redirect_uri.'&'.http_build_query($param));
		else
			$this->redirect($redirect_uri.'?'.http_build_query($param));
	}
}
