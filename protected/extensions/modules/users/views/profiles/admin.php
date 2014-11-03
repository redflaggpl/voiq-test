<?php
/* @var $this ProfilesController */
/* @var $model UsersAuthitem */

$this->breadcrumbs=array(
	'Users Authitems'=>array('admin'),
	'Lista de Users Authitems',
);
 ?><div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
    	<?php echo CHtml::link('<i class="fa fa-plus"></i> '.Yii::t('app','Create'),array('create'),array('class'=>'btn btn-primary'))?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-authitem-grid',
	'itemsCssClass'=>'table table-inbox table-hover',
	'pager'=>array('htmlOptions'=>array('class'=>'pagination'),'header'=>false),
	'dataProvider'=>$model->search(),
	'summaryCssClass'=>'text-right',
	'filter'=>$model,
	'columns'=>array(
		'name',
		array(
			'name'=>'type',
			'value'=>'UsersAuthitem::types($data->type)',
			'type'=>'raw',
		),
		'description',
		'bizrule',
		'data',
		array(
			'class'=>'CLinkColumn',
			'label'=>Yii::t('app','View'),
			'htmlOptions'=>array('style'=>'width:60px'),
			'urlExpression'=>'Yii::app()->controller->createUrl("view",array("pk"=>$data->name))',
			'linkHtmlOptions'=>array('class'=>'btn btn-success'),
		),
		array(
			'class'=>'CLinkColumn',
			'label'=>Yii::t('app','Update'),
			'htmlOptions'=>array('style'=>'width:60px'),
			'urlExpression'=>'Yii::app()->controller->createUrl("update",array("pk"=>$data->name))',
			'linkHtmlOptions'=>array('class'=>'btn btn-primary'),
		),
		array(
			'class'=>'CLinkColumn',
			'labelExpression'=>'($data->name=="admin" or $data->name=="root")?"--":Yii::t("app","Delete")',
			'htmlOptions'=>array('style'=>'width:60px'),
			'urlExpression'=>'($data->name=="admin" or $data->name=="root")?"#":Yii::app()->controller->createUrl("delete",array("pk"=>$data->name))',
			'linkHtmlOptions'=>array('class'=>'btn btn-danger','data-action'=>'delete'),
		),
	),
)); ?>
		</div>
    </div>
</section>
</div>
<script>
$(function() {
	/**
	 * This event delete or publish an Item
	 * according to selected Item
	*/
	$(document).on('click','[data-action=delete]',function(e){
	    e.preventDefault();
	    var href = $(this).attr('href');
	    if(href=='#') {
	    	bootbox.alert("<?php echo Yii::t('app','You cannot delete this record')?>");
	    	return;
	    }

	    bootbox.confirm("<?php echo Yii::t('app','Are you sure you want to delete this record?')?>", function(result) {
	        if(result) {
	            $.ajax({
	                url: href,
	                success:function (data) {
	                    $.fn.yiiGridView.update('users-authitem-grid');
	                }
	            });
	        }
	    });
	});

});
</script>