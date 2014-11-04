<?php
/* @var $this CrmfilesController */
/* @var $model CrmFiles */

$this->breadcrumbs=array(
	'files'=>array('admin'),
	Yii::t('app','Create'),
);
 ?>
 <?php
 	if(Yii::app()->getSession()->get('message')!== null){
 		echo '<div class="bg-primary">'.Yii::app()->getSession()->get('message').'</div>';
 		Yii::app()->getSession()->remove('message');
 	}
 ?>
 <div class="col-lg-12">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?></div>
