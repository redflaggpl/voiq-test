<?php

class BackController extends CmsController
{
	public $title='Crm';
	public $subTitle='Administrar crm';
	
	public function actionIndex()
	{
		$this->render('index');
	}
}