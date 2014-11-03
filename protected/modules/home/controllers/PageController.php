<?php

class PageController extends FrontController
{
	public $title='Home';
	public $subTitle='Administrar home';
	
	public function actionIndex()
	{
		$this->render('index',array(
			'model'=>HomeHome::model()->find(),
		));
	}
}