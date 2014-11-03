<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Usuarios del sistema'=>array('admin'),
	'Administrar',
);
 ?>
<div class="col-lg-12">
<a href="#add" data-toggle="modal" class="btn btn-primary pull-left">
    <?php echo Yii::t('app','Create Users')?> <i class="fa fa-plus"></i>
</a>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'itemsCssClass'=>'table table-inbox table-hover',
	'pager'=>array('htmlOptions'=>array('class'=>'pagination')),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		// 'id',
		array(
			'type'=>'raw',
			'header'=>Yii::t('app','Picture'),
			'value'=>'$data->getImageObject()',
		),
		array(
			'type'=>'raw',
			'name'=>'name',
			'value'=>'$data->name." ".$data->lastname." <br> ".$data->email',
		),
		// array(
		// 	'type'=>'raw',
		// 	'filter'=>array("1"=>Yii::t("app","Enabled"),"2"=>Yii::t("app","Disabled")),
		// 	'name'=>'state',
		// 	'value'=>'$data->state==1?Yii::t("app","Enabled"):Yii::t("app","Disabled");',
		// ),
		array(
			'type'=>'raw',
			'filter'=>array("1"=>Yii::t("app","Enabled"),"2"=>Yii::t("app","Disabled")),
			'name'=>'state',
			'value'=>'$data->statusEditable("'.$this->createUrl("editable").'")',
		),
		array(
			'class'=>'ext.widgets.button.DEModalColumn',
		),
	),
)); ?>
		
</div>


<!-- ////////////////////////////////////////////////// -->
<!-- Modal para ver mas y actualizar datos con editable -->
<!-- ////////////////////////////////////////////////// -->
<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
	<i class="fa fa-cog fa-spin"></i>
</div>


<!-- /////////////////////////////////   -->
<!-- Modal in order to create new albums -->
<!-- /////////////////////////////////   -->
<div class="modal fade" id="add" tabindex="-1" role="add" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="hide fa fa-cog fa-spin spiner"></i> <?php echo Yii::t('app','Create Users')?></h4>
        </div>
        <div class="modal-body">
            <?php $this->renderPartial('_form',array('model'=>$model));?>            
        </div>
    </div>
</div>


<!-- //////////////////////////////////// -->
<!-- Publicacion del javascript asociado  -->
<!-- a la opción de eliminar registros    -->
<!-- //////////////////////////////////// -->
<?php Yii::app()->clientScript->registerScript("deleteRecords","
  $(document).on('click', '[data-action=delete]', function(e) {
    e.preventDefault();
    var that=$(this);
    var content=that.html();
    if(confirm('¿Seguro desea eliminar este registro?')) {
    	that.html('...');
    	$.ajax({
	        url: that.attr('href'),
	        type: 'post',
	        dataType: 'json',
	        success: function(data){
	            if(data.result==0)
	                alert(data.message);
	            else {
				    setTimeout(function(){
				    	$.fn.yiiGridView.update('users-grid', {
							// data: { '".get_class($model)."':  }
						});
						$('#basic').modal('hide');
					},200);
	            }
	        },
	    });
    }
});
");?>


<!-- ////////////////////////////////////////// -->
<!-- Capturamos el evento de save del editable  -->
<!-- ////////////////////////////////////////// -->
<?php Yii::app()->clientScript->registerScript("de-editable-event","
	$('.de-editable').on('save', function(e, params) {
		$.fn.yiiGridView.update('users-grid', {
			// data: { '".get_class($model)."':  }
		});
	});	
");?>

<?php Yii::app()->clientScript->registerScript("assignRoles","
  $(document).on('click', '.assign', function(e) {
    e.preventDefault();
    var that=$(this);
    var content=that.html();
    that.html('...');
    that.removeClass('btn-primary btn-info');
    $.ajax({
        url: that.attr('href'),
        type: 'post',
        data: { action: content},
        dataType: 'json',
        success: function(data){
            if(data.result==0)
                alert(data.message);
            else {
			    setTimeout(function(){
	                that.addClass(data.btn);
	                that.html(data.message);
				},200);
            }
        },
    });
});
");?>
