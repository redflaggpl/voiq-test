<?php

class AppsController extends Controller
{
	/////////////////////////////
	// This controller is for  //
	// Back actions            //
	/////////////////////////////
	
	public $defaultAction='admin';
	public $title='Apps';
	public $subTitle='Administrar Apps';
	
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
				'actions'=>array('admin','delete','update','view','create','order','api','token'),
				'roles'=>$this->module->getAllowPermissoms(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	///////////////////
	// REST actions  //
	///////////////////
	// Put here your rest actions and just response a json

	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Apps;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Apps']))
		{
			$model->attributes=$_POST['Apps'];
			$model->client_secret=Yii::app()->security->randomWord(32);
			$model->client_id=Yii::app()->format->trimAndLower($model->name);
			$model->users_id=Yii::app()->user->id;

			if($model->save())
			{
				if(isset($_POST['Apps']['scopes']))
				{
					foreach($_POST['Apps']['scopes'] as $scope)
					{
						$sc=new AppsScopes;
						$sc->apps_id=$model->id;
						$sc->scopes_id=$scope;
						$sc->save();
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Apps']))
		{
			$model->attributes=$_POST['Apps'];

			if($model->save())
			{
				AppsScopes::model()->deleteAll('apps_id=?',array($model->id));
				if(isset($_POST['Apps']['scopes']))
				{
					foreach($_POST['Apps']['scopes'] as $scope)
					{
						$sc=new AppsScopes;
						$sc->apps_id=$model->id;
						$sc->scopes_id=$scope;
						$sc->save();
					}
				}

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Apps('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Apps']))
			$model->attributes=$_GET['Apps'];
		
		$model->users_id=Yii::app()->user->id;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionOrder()
	{
		if(!isset($_POST['order']))
			throw new CHttpException(403,"Petición inválida");
			
		$orden = $_POST['order'];
        $cant = count($orden);
        $id = array();
        $pos = array();
        for($i = 0 ; $i < $cant ; $i++){
            $data = explode('-', $orden[$i]);
            $pos[$i] = $data[0];
            $id[$i] = $data[1];
        }        
        $ini = min($pos);         
        for($i = 0 ; $i < $cant ; $i++){
            $datos = array(
                'orden_id' => $ini,
                'id' => $id[$i]
            );
	        $ini = $ini + 1 ;
	        $model=Apps::model()->findByPk($datos['id']);
	        $model->orden_id=$ini; // la tabla debe tener orden_id
	        $model->save(true,array('orden_id'));
	    }
	}

	//////////////////////////
	// Reutilizable methods //
	//////////////////////////
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Apps the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Apps::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Apps $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='apps-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}