<?php
class UsersController extends Controller
{

	public $title='Usuarios';
	public $subTitle='Administrar usuarios';
	public $defaultAction='admin';

	public function init()
	{
		parent::init();
		$this->isBackAction();
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','view','update','create','assign','editable'),
				'roles'=>$this->module->getAllowPermissoms(),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('view','update','profile','changePassword','editable'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('resendVerify','confirm','password','forgot','logout','login','registration'),
				// 'roles'=>array('admin'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	///////////////////
	// AJAX actions  //
	///////////////////
	
	public function actionEditable()
	{
		Yii::app()->editable->action("Users");
	}

	///////////////////
	// Front actions //
	///////////////////
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$role=new RoleForm;
		
		if(isset($_POST["ajax"]) and $_POST["ajax"]==="role-form")
		{
			echo CActiveForm::validate($role);
			Yii::app()->end();
		}

		if(isset($_POST["RoleForm"]))
		{
			$role->attributes=$_POST["RoleForm"];
			if($role->validate())
			{
				Yii::app()->authManager->createRole($role->name,$role->description);
				Yii::app()->authManager->assign($role->name,$id);

				$this->redirect(array("view","id"=>$id));
			}
		}

		$typeRender=Yii::app()->request->isAjaxRequest?"renderPartial":"render";
		
		$this->{$typeRender}('view',array(
			'model'=>$this->loadModel($id),
			'role'=>$role,
		));
	}


	public function actionAssign($id)
	{
		$result=0;
		if($_POST['action']==="Asignar" and !Yii::app()->authManager->checkAccess($_GET["item"],$id))
			$result=Yii::app()->authManager->assign($_GET["item"],$id);
		else
			$result=Yii::app()->authManager->revoke($_GET["item"],$id);
		
		if(Yii::app()->request->isAjaxRequest)
		{
			echo CJSON::encode(array(
				"message"=>$_POST['action']==="Asignar"?"Quitar":"Asignar",
				"btn"=>$_POST['action']==="Asignar"?"btn-primary":"btn-info",
				"result"=>$result,
			));
		}
		else
			$this->redirect(array("view","id"=>$id));
	}

	///////////////////
	// Back actions  //
	///////////////////
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$model->state=1;
			$model->state_email=0;
			$model->registered=date("Y-m-d H:i:s");
			$model->password=sha1(Yii::app()->format->trimAndLower($model->name).".".Yii::app()->format->trimAndLower($model->lastname));
			$model->username=(Yii::app()->format->trimAndLower($model->name).".".Yii::app()->format->trimAndLower($model->lastname));
			if($model->save())
			{
				$this->module->sendRegisterMail($model);
				if(Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array());
					Yii::app()->end();
				}
				else
					$this->redirect(array('admin'));
			}

			if($model->getErrors()!==array() and isset($_POST['ajax']) && $_POST['ajax']==='users-form')
			{
				foreach($model->getErrors() as $attribute=>$errors)
					$result[CHtml::activeId($model,$attribute)]=$errors;	
				echo CJSON::encode($result);
				Yii::app()->end();
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionResendVerify()
	{
		$model=Users::model()->find("email=?",array($_GET['email']));
		// $this->module->sendEmailVerification($model);
		$this->render('resendVerify',array(
			'model'=>$model,
		));
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
			Yii::app()->user->setFlash("success","Sr(a) ".$model->name." Bienvenido a ".Yii::app()->name);
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
				$user=Users::model()->find("email=?",array($email));
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
				$this->redirect(array("/"));
			}
		}

		$this->render('change_password',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		$model->papelera=1;
		if(Yii::app()->request->isAjaxRequest and $model->save(true,array('papelera')))
		{
			echo CJSON::encode(array("result"=>1));
			Yii::app()->end();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRoles($id)
	{
		$role=new RoleForm;

		if(isset($_POST["ajax"]) and $_POST["ajax"]==="role-form")
		{
			echo CActiveForm::validate($role);
			Yii::app()->end();
		}

		if(isset($_POST["RoleForm"]))
		{
			$role->attributes=$_POST["RoleForm"];
			if($role->validate())
			{
				Yii::app()->authManager->createRole($role->name,$role->description);
				Yii::app()->authManager->assign($role->name,$id);

				$this->redirect(array("view","id"=>$id));
			}
		}
		$this->render('roles',array(
			'model'=>$this->loadModel($id),
			'role'=>$role,
		));
	}

	 /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionProfile()
    {
        $user=Users::model()->findByPk(Yii::app()->user->id);
        $change=new ChangePasswordForm;
        // $model=Profile::model()->find("user_id=?",array(Yii::app()->user->id));

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($user);

        if(isset($_POST['Users']))
        // if(isset($_POST['Profile']) and isset($_POST['Users']))
        {
            $user->attributes=$_POST['Users'];
            // $user->attributes=$_POST['Users'];
            if($user->save())
            {
            	Yii::app()->user->setFlash("success",'Perfil actualizado correctamente');
                $this->refresh();
            }
        }

        $this->render('profile',array(
            // 'model'=>$model,
            'user'=>$user,
            'change'=>$change,
        ));
    }

	public function actionForgot()
	{
		$model=new ForgotForm;

		if (isset($_POST['ForgotForm'])) {
			$model->attributes=$_POST['ForgotForm'];
			if ($model->validate()) 
			{
				$user=Users::model()->find("email=?",array($model->email));
				
				$contex=array(
					"body"=>"Hola {$user->name}! <br><br> Ya casi recuperas tu contraseña, por favor sigue este enlace:<br>",
					"label"=>'Cambiar contraseña',
					"url"=>Yii::app()->createAbsoluteUrl("users/password",array("key"=>Yii::app()->security->encrypt($model->email))),
				);
				$subject='Recuperar contraseña '.strip_tags(Yii::app()->name);
				
				Yii::app()->email->add($user->email,$user->name);
				Yii::app()->email->sendBody($subject,$contex);
				
				Yii::app()->user->setFlash("success",'Por favor revise su correo electrónico para recuperar su contraseña.<br>'.$model->email);
				$this->refresh();
			}
		}

		$this->render('forgot',array(
			"model"=>$model,
		));
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
}
