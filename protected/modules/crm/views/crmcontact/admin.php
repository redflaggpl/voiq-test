<?php
/* @var $this CrmcontactController */
/* @var $model CrmContact */

$this->breadcrumbs=array(
	'contact'=>array('admin'),
	'Lista de contact',
);
 ?><div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
    	<?php echo CHtml::link('<i class="fa fa-plus"></i> '.Yii::t('app','Create'),array('create'),array('class'=>'btn btn-primary'))?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'crm-contact-grid',
	'itemsCssClass'=>'table table-inbox table-hover',
	'pager'=>array('htmlOptions'=>array('class'=>'pagination'),'header'=>false),
	'dataProvider'=>$model->search(),
	'summaryCssClass'=>'text-right',
	'filter'=>$model,	'columns'=>array(
		array(
			'name'=>'id',
			'type'=>'raw',
			'value'=>'$data->id',
		),
		array(
			'name'=>'firstname',
			'type'=>'raw',
			'value'=>'$data->firstname',
		),
		array(
			'name'=>'lastname',
			'type'=>'raw',
			'value'=>'$data->lastname',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'$data->email',
		),
		array(
			'name'=>'sex',
			'type'=>'raw',
			'value'=>'$data->sex',
		),
		array(
			'name'=>'id_number',
			'type'=>'raw',
			'value'=>'$data->id_number',
		),
		/*
		array(
			'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model' => $model,
				'attribute' => 'created_at',
				'language' =>  Yii::app()->language,
				'htmlOptions' => array('class'=>'form-control'),
				'options' => array(
					'showButtonPanel' => true,
					'changeYear' => true,
					'dateFormat' => 'yy-mm-dd',
				),
			),true),
			'name'=>'created_at',
			'type'=>'raw',
			'value'=>'Yii::app()->format->formatShort($data->created_at)." <br><small class=\"text-muted\">".Yii::app()->format->formatAgoComment($data->created_at)."</small>"',
		),
		*/
		/*array(
			'class'=>'CButtonColumn',
		),*/
		array(
			'class'=>'CLinkColumn',
			'label'=>Yii::t('app','View'),
			'htmlOptions'=>array('style'=>'width:60px'),
			'urlExpression'=>'Yii::app()->controller->createUrl("view",array("id"=>$data->primaryKey))',
			'linkHtmlOptions'=>array('class'=>'btn btn-success'),
		),
		array(
			'class'=>'CLinkColumn',
			'label'=>Yii::t('app','Update'),
			'htmlOptions'=>array('style'=>'width:60px'),
			'urlExpression'=>'Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey))',
			'linkHtmlOptions'=>array('class'=>'btn btn-primary'),
		),
		array(
			'class'=>'CLinkColumn',
			'label'=>Yii::t('app','Delete'),
			'htmlOptions'=>array('style'=>'width:60px'),
			'urlExpression'=>'Yii::app()->controller->createUrl("delete",array("id"=>$data->primaryKey))',
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
	    bootbox.confirm("¿Está seguro que desea <strong>BORRAR</strong> el registro seleccionado?", function(result) {
	        if(result) {
	            $.ajax({
	                url: href,
	                success:function (data) {
	                    $.fn.yiiGridView.update('crm-contact-grid');
	                }
	            });
	        }
	    });
	});

});
</script>