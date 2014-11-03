<?php

class PageController extends FrontController
{
	public $title='Crm';
	public $subTitle='Administrar crm';
	
	public function actionIndex()
	{
		$this->render('index');
	}
}