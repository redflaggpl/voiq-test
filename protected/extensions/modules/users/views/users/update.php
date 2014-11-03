<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
?>

<div class="col-sm-4 col-md-3">
<?php echo $this->renderPartial('_menu',array('model'=>$model)); ?></div>
<div class="col-sm-8 col-md-9">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?></div>