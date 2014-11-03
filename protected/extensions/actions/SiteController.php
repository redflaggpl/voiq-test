<?php

class SiteController extends Controller
{
	public function missingAction($actionID)
	{
		if($actionID=='')
			$actionID='index';
		if(isset($_GET['theme']))
			Yii::app()->theme=$_GET['theme'];
		$this->render($actionID);
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		throw new CHttpException(404,"You need to have and module for default, please configure this on protected/config/main/ 'defaulController' parameter");
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		Yii::app()->theme=$this->themeFront;
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}