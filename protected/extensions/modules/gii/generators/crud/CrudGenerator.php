<?php
Yii::import('ext.modules.gii.CCodeGenerator');
class CrudGenerator extends CCodeGenerator
{

	public $title='CRUD';
	public $subTitle='CRUD generator';
	
	public $codeModel='gii.generators.crud.CrudCode';

	/**
	 * Prepares the code model.
	 */
	protected function prepare()
	{
		if($this->codeModel===null)
			throw new CException(get_class($this).'.codeModel property must be specified.');
		$modelClass=Yii::import($this->codeModel,true);
		$model=new $modelClass;
	
		if(isset($_POST[$modelClass]))
		{
			$model->attributes=$_POST[$modelClass];
			$model->status=CCodeModel::STATUS_PREVIEW;
			if($model->validate())
				$model->prepare();
		}
		return $model;
	}
}