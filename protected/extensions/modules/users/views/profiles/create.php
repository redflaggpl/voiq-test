<?php
/* @var $this ProfilesController */
/* @var $model UsersAuthitem */

$this->breadcrumbs=array(
	'Users Authitems'=>array('admin'),
	Yii::t('app','Create'),
);
 ?><div class="col-lg-12">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?></div>
