<?php
/* @var $this CrmfilesController */
/* @var $model CrmFiles */

$this->breadcrumbs=array(
	'files'=>array('admin'),
	Yii::t('app','Create'),
);
 ?>
 <div class="col-lg-12">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?></div>
