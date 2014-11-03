<?php

class DocApiController extends CmsController
{
	public $title='Api';
	public $subTitle='Admin api';

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'),
				'roles'=>array('admin','root'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
		$this->title='API '.$this->module->labelMenu!==null?$this->module->labelMenu:ucfirst($this->module->id);
		$this->subTitle='Enpoints availables';
		$this->render('ext.actions.api_doc',array(
			'documentation'=>$this->builtAPIAvailable($this->module->id)
		));
	}

	// THis is for a
	public $cssClass=array(
		'get'=>'label-success',
		'post'=>'label-warning',
		'put'=>'label-info',
		'delete'=>'label-danger',
	);

	public function getLabel($method='')
	{
		$method=strtolower($method);
		if(isset($this->cssClass[$method]))
			return $this->cssClass[$method];
		return 'label-default';
	}
}