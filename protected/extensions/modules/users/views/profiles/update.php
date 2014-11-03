<?php
/* @var $this ProfilesController */
/* @var $model UsersAuthitem */

$this->breadcrumbs=array(
	'Users Authitems'=>array('admin'),
	$model->name=>array('view','id'=>$model->name),
	Yii::t('app','Update'),
);
?>
<div class="col-lg-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?></div>