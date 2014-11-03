<?php

class BackController extends Controller
{
	public $title='Back';
	public $subTitle='Administrar back';
	
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
				'actions'=>array('index','upload','test','Preview'),
				'roles'=>$this->module->getAllowPermissoms(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionIndex()
	{
		$model=SmptConfig::model()->find();
		if($model===null)
			$model=new SmptConfig;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['SmptConfig']))
		{
			$model->attributes=$_POST['SmptConfig'];
			if($model->save())
	        {
            	Yii::app()->user->setFlash('success',Yii::t('app','The record was saved successfully'));
                $this->refresh();
            }
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

    public function actionUpload()
    {
    	$uploader=Yii::createComponent('ext.inputs.uploader.GComponentUpload');
		// TODO validate here the widt and height
		$uploader->upload(array("jpeg", "png", "jpg"));
	}

	//////////////////////////
	// Reutilizable methods //
	//////////////////////////
	/**
	 * Performs the AJAX validation.
	 * @param SmptConfig $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='smpt-config-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionTest()
    {
        if(!Yii::app()->request->isAjaxRequest)
            throw new CHttpException(403,"Petición inválida, probablemente ha fallado el JavaScript de su navegador.");
        
        $model=new SmtpTest;

        if(isset($_POST['SmtpTest']))
        {
            $model->attributes=$_POST['SmtpTest'];
            if($model->validate())
            {
                Yii::app()->email->add($model->email_test,$model->email_test);
				$result=Yii::app()->email->sendBody('Testing send email from '.strip_tags(Yii::app()->name),array(
					"body"=>"<h1>Hola ".substr($model->email_test, 0,7)."..!</h1><p>{$model->area_test}</p>",
					"label"=>"Label of test",
					"url"=>$this->createAbsoluteUrl('/')
				));

				$model->result=(int)$result;
				$model->message=Yii::app()->email->ErrorInfo;
	            echo CJSON::encode($model);
                Yii::app()->end();
            }
            if($model->getErrors()!==array() and isset($_POST['ajax']) and $_POST['ajax']==='smtp-test-form')
            {
                $result=array();
                foreach($model->getErrors() as $attribute=>$errors)
                    $result[CHtml::activeId($model,$attribute)]=$errors;    
                echo CJSON::encode($result);
                Yii::app()->end();
            }
        }
        
        echo CJSON::encode($model);
        Yii::app()->end();
    }

    public function actionPreview()
    {
    	$lorem="
    	<h1>Lorem Ipsum h1</h1>
    	<h2>Lorem Ipsum h2</h2>
    	<h3>Lorem Ipsum h3</h3>
    	<h4>Lorem Ipsum h4</h4>
    	<h5>Lorem Ipsum h5</h5>
    	<p>
    	Lorem Ipsum is simply dummy text of the printing and 
    	typesetting industry. Lorem Ipsum has been the industry's 
    	standard dummy text ever since the 1500s, when an unknown 
    	printer took a galley of type and scrambled it to make a 
    	type specimen book. It has survived not only five centuries, 
    	but also the leap into electronic typesetting, 
    	remaining essentially unchanged. <br>
    	It was popularised in the 1960s with the release of Letraset 
    	sheets containing Lorem Ipsum passages, and more recently 
    	with desktop publishing software 
    	like Aldus PageMaker including 
    	versions of Lorem Ipsum.
    	</p>
    	";
		Yii::app()->email->previewBody('Testing send email from '.strip_tags(Yii::app()->name),array('body'=>$lorem,'label'=>'Label of test','url'=>$this->createAbsoluteUrl('/')));
    }
}
