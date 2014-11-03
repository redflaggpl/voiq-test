<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends CmsController
{
	public $defaultAction='index';
	public $title='<i class="fa <?php echo $this->fontIcon?>"></i> <?php echo $this->labelName; ?>';
	public $subTitle='Admin <?php echo $this->labelName; ?>';

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
				'actions'=>array('index','upload'),
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
		$this->title='<i class="fa <?php echo $this->fontIcon?>"></i> '.Yii::t('app','<?php echo $this->labelName; ?>');
		$this->subTitle='Admin '.Yii::t('app','<?php echo $this->labelName; ?>');
		
		$model=<?php echo $this->modelClass; ?>::model()->find();
		if($model===null)
			$model=new <?php echo $this->modelClass; ?>;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
<?php 
foreach($this->tableSchema->columns as $column)
{
	if($column->name=='updated_at')
		echo "\t\t\t\$model->updated_at=date('Y-m-d H:i:s');\n";
	if($column->name=='created_at')
		echo "\t\t\t\$model->created_at=date('Y-m-d H:i:s');\n";
	if($column->name=='users_id')
		echo "\t\t\t\$model->users_id=Yii::app()->user->id;\n";
	if($column->name=='user_id')
		echo "\t\t\t\$model->user_id=Yii::app()->user->id;\n";
}
?>
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

	//////////////////////////
	// Reutilizable methods //
	//////////////////////////
	/**
	 * Performs the AJAX validation.
	 * @param <?php echo $this->modelClass; ?> $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
