<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
require Yii::getPathOfAlias('ext.components.api').'/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
class <?php echo $this->controllerClass; ?> extends JsonController
{

	public function missingAction($actionID)
	{
		$app=new \Slim\Slim();
		$module=$this->module;

		$app->notFound(function () use ($app) {

	    	$req=$app->request;
			$res=$app->response;

		    $res
			->status(404)
            ->json($req, Yii::t('app','The resourse requested does not exist'));
			$app->stop();

		});

		$cb = function () use ($module, $app) {
		    return function() use ($module, $app) {
	        	if(!Yii::app()->user->checkToken($module->getAllowPermissoms()))
				{
					$app->response
					->status(403)
		            ->json($app->request, Yii::t('app','You do not have access to take this action'));
					$app->stop();
				}
		    };
		};

		$app->get("/{$this->module->id}/<?php echo strtr($this->controller,array($this->moduleName.'/'=>'')); ?>/", function () use ($app){

	    	$req=$app->request;
			$res=$app->response;
	    	
	    	try {

	    		$model=new <?php echo $this->modelClass; ?>('search');
				$model->unsetAttributes();  // clear any default values
				$model->attributes=$app->request->params();
				$criteria=$model->search()->getCriteria();
				
				$data=<?php echo $this->modelClass; ?>::model()->arrayAll($criteria,null,array(
<?php 
foreach($this->tableSchema->columns as $column)
{
	if(strpos($column->name, 'password')!==false)
		continue;

	if(strrpos($column->name, 'img_')!==false or strrpos($column->name, 'file_')!==false)
	{
		echo "\t\t\t\t\t'{$column->name}',\n";
		echo "\t\t\t\t\t'{$column->name}_path',\n";
	}
	elseif(strrpos($column->name, 'cms_')!==false)
	{
		echo "\t\t\t\t\t'{$column->name}',\n";
		echo "\t\t\t\t\t'{$column->name}_html',\n";
	}
	else
		echo "\t\t\t\t\t'{$column->name}',\n";

}
?>
				));
	            $res->status(200)
	            ->json($data);

	    	} catch (Exception $e) {
	    		$res->jsonException($e);
	    	}
	    });

		$app->get("/{$this->module->id}/<?php echo strtr($this->controller,array($this->moduleName.'/'=>'')); ?>/view/:id", function ($id) use ($app){

			$req=$app->request;
			$res=$app->response;

			try {

				$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
				if($model===null) {
					$res
					->status(404)
		            ->json($id, Yii::t('app','The resourse requested {id} does not exist or was deleted',
		            	array('{id}'=>$id)),
		            	"resource_not_found");
				} else {
					$res
		            ->status(200)
		            ->json($model->toArray(array(
<?php 
foreach($this->tableSchema->columns as $column)
{
	if(strpos($column->name, 'password')!==false)
		continue;

	if(strrpos($column->name, 'img_')!==false or strrpos($column->name, 'file_')!==false)
	{
		echo "\t\t\t\t\t'{$column->name}',\n";
		echo "\t\t\t\t\t'{$column->name}_path',\n";
	}
	elseif(strrpos($column->name, 'cms_')!==false)
	{
		echo "\t\t\t\t\t'{$column->name}',\n";
		echo "\t\t\t\t\t'{$column->name}_html',\n";
	}
	else
		echo "\t\t\t\t\t'{$column->name}',\n";

}
?>
		            )));
				}
			
			} catch (Exception $e) {
	    		$res->jsonException($e);
	    	}
		});
		
		$app->post("/{$this->module->id}/<?php echo strtr($this->controller,array($this->moduleName.'/'=>'')); ?>/delete/:id", $cb(), function ($id) use ($app) {

	    	$req=$app->request;
			$res=$app->response;
			
			$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
			if($model===null) {
				$res
				->status(404)
	            ->json($id, Yii::t('app','The resourse requested {id} does not exist or was deleted',
	            	array('{id}'=>$id)),
	            	"resource_not_found");
				$app->stop();
			}

			try {
				if($model->delete()) {
					$res
					->status(200)
		            ->json($model, "<?php echo $this->labelName; ?> ".Yii::t('app','has been deleted successfully').".");
				} else {
					$res
					->status(500)
		            ->json($model, Yii::t('app','Error to database connection. Please try later').".");
				}

			} catch (Exception $e) {
	    		$res->jsonException($e);
	    	}
		});

		$app->post("/{$this->module->id}/<?php echo strtr($this->controller,array($this->moduleName.'/'=>'')); ?>/create", $cb(), function () use ($app) {

	    	$req=$app->request;
			$res=$app->response;

			try {

				$model=new <?php echo $this->modelClass; ?>;
				$model->attributes=$req->params();
<?php 
foreach($this->tableSchema->columns as $column)
{
	if($column->name=='orden_id')
	{
		echo "\t\t\t\t\$last=".$this->modelClass."::model()->findAll();\n";
		echo "\t\t\t\t\$model->orden_id=count(\$last)+1;\n";
	}
		if($column->name=='updated_at')
			echo "\t\t\t\t\$model->updated_at=date('Y-m-d H:i:s');\n";
		if($column->name=='created_at')
			echo "\t\t\t\t\$model->created_at=date('Y-m-d H:i:s');\n";
}
?>
		
				if($model->save()) {
					$res
					->status(200)
					->json($model,"<?php echo $this->labelName; ?> ".Yii::t('app','has been created successfully')."");
				} else {
					$res
					->status(422)
					->json($model->getErrors(),Yii::t('app','Form validation errors'),"unprocessable_entity");
				}

			} catch (Exception $e) {
	    		$res->jsonException($e);
	    	}
		});

		$app->post("/{$this->module->id}/<?php echo strtr($this->controller,array($this->moduleName.'/'=>'')); ?>/update/:id", $cb(), function ($id) use ($app) {
	
	    	$req=$app->request;
			$res=$app->response;
			$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
			if($model===null) {
				$res
				->status(404)
	            ->json($id, Yii::t('app','The resourse requested {id} does not exist or was deleted',
	            	array('{id}'=>$id)),
	            	"resource_not_found");
				$app->stop();
			}

			try {

				$model->attributes=$req->params();
<?php 
foreach($this->tableSchema->columns as $column)
{
		if($column->name=='created_at')
			echo "\t\t\t\t\$model->created_at=date('Y-m-d H:i:s');\n";
}
?>
				if($model->save()) {
					$res
					->status(200)
					->json($model,"<?php echo $this->labelName; ?> ".Yii::t('app','has been updated successfully')."");
				} else {
					$res
					->status(422)
					->json($model->getErrors(),Yii::t('app','Form validation errors'),"unprocessable_entity");
				}

			} catch (Exception $e) {
	    		$res->jsonException($e);
	    	}
		});

		$app->run();
	}
}