<?php
/* @var $this CrmcontactController */
/* @var $model CrmContact */

$this->breadcrumbs=array(
	'contact'=>array('admin'),
	Yii::t('app','Create'),
);
 ?><div class="col-lg-12">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?></div>
