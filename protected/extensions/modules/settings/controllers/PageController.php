<?php

class PageController extends FrontController
{
	/////////////////////////////
	// This controller is for  //
	// Front actions            //
	/////////////////////////////
	
	public $defaultAction='index';


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
		$this->layout='//layouts/login';
		$this->render('index',array(
			'model'=>Settings::model()->find(),
		));
	}
}