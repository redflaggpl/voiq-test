<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);

?>

<div class="col-sm-4 col-md-3">
<?php echo $this->renderPartial('_menu') ?></div>
<div class="col-sm-8 col-md-9">
<?php $this->widget('zii.widgets.CListView',array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'itemsTagName'=>'ul',
    'itemsCssClass'=>'list-group',
  )); ?>
</div>