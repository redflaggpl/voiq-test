<?php

class Api_usersController extends JsonController
{

	public function routes($app,$url,$req,$res)
	{

		$app->get("$url/", function () use ($req, $res) {

    		$res->filterAuth();

	    	$model=new Users('search');
			$model->unsetAttributes();  // clear any default values
			$model->attributes=$req->params();
    		$res->success(Users::model()->findAll($model->search()->getCriteria()));
		});

		$app->get("$url/view/:id", function ($id) use ($req, $res) {

    		$res->filterAuth();

			$model=$res->loadUsersModel($id);
    		if($model===null)
    			$res->notFound();
			$res->success($model);
	    });

		$app->get("$url/me", function () use ($req, $res) {

    		$res->filterAuth();

			$model=$res->loadUsersModel($res->user->id);
    		if($model===null)
    			$res->notFound();
			$res->success($model);
	    });

		$app->post("$url/delete/:id", function ($id) use ($req, $res) {
    		$res->filterAuth();
	
	    	$model=$res->loadUsersModel($id);
			if($model->delete())
				$res->success($model,"Users has been deleted successful");
			else
				$res->error("no_delete","",$model);
		});

		$app->post("$url/register", function () use ($req, $res) {

    		$appForm=new AppForm;
			$appForm->attributes=$req->params();
			if(!$appForm->validate())
				$res->validateError($appForm->getErrors());
			else
				$app=Apps::model()->find('client_id=? AND client_secret=?',
					array($req->params('client_id'),$req->params('client_secret')));


			$model=new Users("signup");
			$model->attributes=$req->params();
			$model->registered=date('Y-m-d H:i:s');
			$model->state_email=0;
			$model->state=1;
			$model->papelera=0;
			$model->username=Yii::app()->format->trimAndLower($model->name).'.'.Yii::app()->format->trimAndLower($model->lastname);
	
			if($res->module->sendPassword)
				$model->password=sha1($model->username);
				
			if($model->validate())
			{
				$model->password=sha1($model->password);
				$model->save();
				
				if($res->module->sendRegisterMail($model))
				{
					$modelArray=$model->attributes;
					if(($token=$model->getAccessToken($app))!==null)
					{
						if($res->module->loginInRegister)
						{
							$modelArray['token']=$token;
							$res->success($modelArray,'Registro exitoso.');
						}
						else
						{
							if($res->module->sendPassword)
								$res->success($modelArray,'Hemos enviado a tu correo tus datos de ingreso.');
							else
								$res->success($modelArray,'Por favor revisa tu correo electrónico para terminar el proceso de registro.');
						}
					}
					else
					{
						$model->papelera=1;
						$model->save(true,array('papelera'));
						$res->error("error_token","No se pudo iniciar sesión, por favor intente más tarde.");
					}
				}
				else
				{
					$model->papelera=1;
					$model->save(true,array('papelera'));
					$res->error("error_send_email","Error al enviar el correo de confirmación.");
				}
			}
			else
				$res->validateError($model->getErrors());
		});

		$app->post("$url/update/:id",function ($id) use ($req, $res) {

    		$res->filterAuth();

			$model=$res->loadUsersModel($id);
			$model->attributes=$req->params();
			if($model->save())
				$res->validateSuccess($model);
			else
				$res->validateError($model->getErrors());
		});

		$app->post("$url/login",function () use ($req, $res) {

    		$appForm=new AppForm;
			$appForm->attributes=$req->params();
			if(!$appForm->validate())
				$res->validateError($appForm->getErrors());
			else
				$app=Apps::model()->find('client_id=? AND client_secret=?',
					array($req->params('client_id'),$req->params('client_secret')));

			$model=new LoginForm;
			$model->attributes=$req->params();
			
			$identity=new UserIdentity($model->username,$model->password);
			if($model->validate() and ($userObject=$identity->authenticateToken())!==false)
			{
			
				/**
				 * Si la atenticacion es de tipo enviar contraseña
				 * entonces cuando se loguea es la unica forma en que
				 * asumismos que su correo existe, porque siempre
				 * se envian las contraseñas al correo
				*/
				if($res->module->sendPassword)
				{
					$userObject->state_email=1;
					$userObject->save(true,array('state_email'));
				}
				$modelArray=$userObject->attributes;
				$modelArray['token']=$userObject->getAccessToken($app);
				$res->success($modelArray);
			}
			else
				$res->validateError($model->getErrors());
		});

		$app->post("$url/update_profile",function () use ($req, $res) {

    		$res->filterAuth();

			$model=$res->loadUsersModel($res->user->id);
			$model->attributes=$req->params();
			
			if($req->params('newPassword'))
            	$model->newPassword=$req->params('newPassword');
            
			if($model->save())
			{
				if(!empty($model->newPassword))
            	{
            		$model->password=sha1($model->newPassword);
            		$model->save(true,array('password'));
            	}
            	$res->validateSuccess($model);
			}
			else
				$res->validateError($model->getErrors());
		});

		$app->post("$url/forgot",function () use ($req, $res) {

    		// $res->filterAuth();

    		$model=new ForgotForm;
			$model->attributes=$req->params();
			if ($model->validate()) 
			{
				$user=Users::model()->find("email=? AND papelera=0",array($model->email));
				
				if($res->module->sendForgotMail($user))
				{
					if($res->module->sendPassword)
						$res->success($model,'Hemos enviado a tu correo tus datos de ingreso.');
					else
						$res->success($model,'Por favor revisa tu correo electrónico para recuperar tu contraseña.');
				}
				else
					$res->error("error_send_email","Error al enviar el correo de confirmación, por favor intenta nuevamente.");
			}
			else 
				$res->validateError($model->getErrors());
		});

		$app->run();
	}

	//////////////////////////
	// Reutilizable methods //
	//////////////////////////
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Task the loaded model
	 * @throws CHttpException
	 */
	public function loadUsersModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			$this->notFound();	
		return $model;
	}
}