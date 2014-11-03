<?php

class ModelGenerator extends CCodeGenerator
{
	public $title='Model Generator';
	public $subTitle='Model Generator code';

	public $codeModel='gii.generators.model.ModelCode';

	/**
	 * Provides autocomplete table names
	 * @param string $db the database connection component id
	 * @return string the json array of tablenames that contains the entered term $q
	 */
	public function actionGetTableNames($db)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest())
		{
			$all = array();
			if(!empty($db) && Yii::app()->hasComponent($db)!==false && (Yii::app()->getComponent($db) instanceof CDbConnection))
				$all=array_keys(Yii::app()->{$db}->schema->getTables());

			echo json_encode($all);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * The code generation action.
	 * This is the action that displays the code generation interface.
	 * Child classes mainly need to provide the 'index' view for collecting user parameters
	 * for code generation.
	 */
	public function actionIndex()
	{
		$model=$this->prepare();
		if($model->files!=array() && isset($_POST['generate'], $_POST['answers']))
		{
			$model->answers=$_POST['answers'];
			$model->status=$model->save() ? CCodeModel::STATUS_SUCCESS : CCodeModel::STATUS_ERROR;
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Prepares the code model.
	 */
	protected function prepare()
	{
		if($this->codeModel===null)
			throw new CException(get_class($this).'.codeModel property must be specified.');
		$modelClass=Yii::import($this->codeModel,true);
		$model=new $modelClass;
		// $model->loadStickyAttributes();
		if(isset($_POST[$modelClass]))
		{
			$model->attributes=$_POST[$modelClass];
			if(isset($_POST[$modelClass]['moduleName']) and Yii::app()->getModule($_POST[$modelClass]['moduleName'])!==null)
			{
				$moduleClassPath=Yii::app()->modules[$_POST[$modelClass]['moduleName']]['class'];
				$moduleClassPath=explode('.', $moduleClassPath);
			    unset($moduleClassPath[count($moduleClassPath)-1]);
				
				$model->modelPath=implode('.', $moduleClassPath).'.models';
			}
			$model->status=CCodeModel::STATUS_PREVIEW;
			if($model->validate())
			{
				// $model->saveStickyAttributes();
				$model->prepare();
			}
		}
		return $model;
	}
}