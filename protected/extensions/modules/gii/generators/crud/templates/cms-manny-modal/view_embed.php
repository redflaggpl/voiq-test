<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
?>

/* 
////////////////////////////////////////////////
// REPLACE THIS ON VIEW OR UPDATE CONTROLLER  //
////////////////////////////////////////////////

$model=$this->loadModel($id);

$<?php echo $this->getControllerID(); ?>=new <?php echo $this->modelClass; ?>;
$criteria=new CDbCriteria;
$criteria->compare('<?php echo $this->foraneKey?>',$id);
$<?php echo $this->getControllerID(); ?>DataProvider=new CActiveDataProvider('<?php echo $this->modelClass; ?>',array(
	"criteria"=>$criteria,
));


$typeRender=Yii::app()->request->isAjaxRequest?"renderPartial":"render";
$this->{$typeRender}('view',array(
	'model'=>$model,
	'<?php echo $this->getControllerID(); ?>'=>$<?php echo $this->getControllerID(); ?>,
	'<?php echo $this->getControllerID(); ?>DataProvider'=>$<?php echo $this->getControllerID(); ?>DataProvider,
));

////////////////////////////////////////////////////////////
// PASTE THIS CONTENT ON THE VIE OF SAME CONTROLLER ABOVE //
////////////////////////////////////////////////////////////

<?php echo "<?php \$this->renderPartial('../{$this->getControllerID()}/view_embed',array(\n";?>
	'model'=>$model,
	'<?php echo $this->getControllerID(); ?>DataProvider'=>$<?php echo $this->getControllerID(); ?>DataProvider,
	'<?php echo $this->getControllerID(); ?>'=>$<?php echo $this->getControllerID(); ?>,
))?>

 */
<?php echo "?>\n"; ?>

<div class="col-lg-12 text-right">
<?php echo "<?php echo CHtml::link('<i class=\"fa fa-plus-circle\"></i>', array('{$this->getControllerID()}/create','".$this->foraneKey."'=>\$model->id), \narray('class'=>'btn btn-primary','data-action'=>'crud-{$this->getControllerID()}','data-type'=>'create')); ?>\n";?>
</div>

<h4><i class="fa <?php echo $this->fontIcon?>"></i> <?php echo "<?php echo Yii::t('app','{$this->labelName}')?>"?> <span class="loading"></span></h4>
<?php echo "<?php"; ?> $this->widget('zii.widgets.CListView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass)?>-list',
	'dataProvider'=>$<?php echo $this->getControllerID(); ?>DataProvider,
	'itemView'=>'../<?php echo $this->getControllerID(); ?>/_detail_each',
	'pager'=>array('htmlOptions'=>array('class'=>'pagination'),'header'=>false),
	'itemsTagName'=>'ul',
	'cssFile'=>false,
	'itemsCssClass'=>'list-group',
	'summaryCssClass'=>'text-right',
)); ?>


<!-- ////////////////////////////////////////////////// -->
<!-- Modal in order to update or create a detail record -->
<!-- ////////////////////////////////////////////////// -->
<div class="modal fade" id="<?php echo $this->class2id($this->modelClass)?>-modal" tabindex="-1" role="<?php echo $this->class2id($this->modelClass)?>-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa <?php echo $this->fontIcon?>"></i> <?php echo "<?php echo Yii::t('app','{$this->labelName}')?>"?></h4>
        </div>
    	<div class="modal-body">
        	<?php echo "<?php echo \$this->renderPartial('../{$this->getControllerID()}/_detail_form',array('model'=>\${$this->getControllerID()}))?>\n"?>
        </div>
        </div>
    </div>
</div>


<!-- ////////////////////////////////////////////////// -->
<!-- Modal in order to view detail of -->
<!-- ////////////////////////////////////////////////// -->
<div class="modal fade" id="<?php echo $this->class2id($this->modelClass)?>-view-modal" tabindex="-1" role="<?php echo $this->class2id($this->modelClass)?>-view-modal" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h4 class="modal-title"><i class="fa <?php echo $this->fontIcon?>"></i> <?php echo "<?php echo Yii::t('app','{$this->labelName}')?>"?></h4>
        </div>
    	<div class="modal-body">
        	<?php echo "<?php echo \$this->renderPartial('../{$this->getControllerID()}/_detail_view',array('model'=>\${$this->getControllerID()}))?>\n"?>
        </div>
        </div>
    </div>
</div>
<script>
$(function () {
	$(document).on('click', '[data-action=crud-<?php echo $this->getControllerID(); ?>]', function (e) {
   		e.preventDefault();
			var action = $(this).attr('href');
			var type = $(this).attr('data-type');
   		
   		if(type==='update') {
	   		$.ajax({
	   			url: action,
	   			dataType: 'json',
	   			success: function (data) {
	   				// fill data to update
	   				console.log(data);
	   				$('#<?php echo $this->class2id($this->modelClass)."-form"?>').attr('action',action);
<?php foreach($this->tableSchema->columns as $column):?>
<?php if(strpos($column->name, 'img_')!==false):?>
					$('.stick-image').empty();
					$('#<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>').val('');
					$('#<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>').val(data.<?php echo $column->name ?>);
					$('.stick-image.<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>_img').html('<img class="img-responsive img-rounded" src="'+$('.<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>_img').attr('data-url')+'/'+data.<?php echo $column->name ?>+'" alt="">');
<?php elseif(strpos($column->dbType,'tinyint(1)')!==false or $column->type==='boolean'):?>
					$('#<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>').attr('checked',data.<?php echo $column->name ?>);
<?php else:?>
					$('#<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>').val(data.<?php echo $column->name ?>);
<?php endif;?>
<?php endforeach;?>
					$('.<?php echo $this->class2id($this->modelClass)."-submit";?>').val('<?php echo Yii::t('app','Save')?>');
					$('#<?php echo $this->class2id($this->modelClass)."-modal"?>').modal('show');
	   			}
	   		});
   		} 

   		if(type==='view') {
				$.ajax({
	   			url: action,
	   			dataType: 'json',
	   			success: function (data) {
	   				// fill data to update
	   				console.log(data);
<?php foreach($this->tableSchema->columns as $column):?>
					$('#<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>_label').html(data.<?php echo $column->name ?>);
<?php endforeach;?>
					$('#<?php echo $this->class2id($this->modelClass)."-view-modal"?>').modal('show');
	   			}
	   		});
   		} 
   		
   		if(type==='create') {
				$('#<?php echo $this->class2id($this->modelClass)."-form"?>').attr('action',action).each(function(i,v){
	              this.reset();
	            });
<?php foreach($this->tableSchema->columns as $column):?>
<?php if(strpos($column->name, 'img_')!==false):?>
					$('.stick-image').empty();
					$('#<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>').val('');
<?php endif;?>
<?php endforeach;?>
					$('.<?php echo $this->class2id($this->modelClass)."-submit";?>').val('<?php echo Yii::t('app','Create')?>');
	   				$('#<?php echo $this->class2id($this->modelClass)."-modal"?>').modal('show');
   		}

   		if(type==='delete') {
			var name = $(this).attr('data-name');
		    bootbox.confirm("¿Está seguro que desea <strong>BORRAR</strong> el registro "+name+"?", function(result) {
		        if(result) {
		            $.ajax({
		                type: 'post',
		                url: action,
		                success:function (data) {
		                    $.fn.yiiListView.update('<?php echo $this->class2id($this->modelClass)?>-list');
		                }
		            });
		        }
		    });
   		}
    });

<?php foreach($this->tableSchema->columns as $column):?>
<?php if($column->name=='orden_id'):?>
	$("#<?php echo $this->class2id($this->modelClass)?>-list ul").sortable({
    	update: function() {
    		var that = $(this);
			$('.loading').html('<i class="fa fa-refresh fa-spin"></i>');
    		setTimeout(function () {
	        	var order = that.sortable("toArray");
		        $.post('<?php echo "<?php echo \$this->createUrl(\"{$this->getControllerID()}/order\") ?>"?>', {order: order}, function(datos){
	    			$('.loading').empty();
		        });
    		},500);
        }
    });
<?php endif;?>
<?php endforeach;?>
});
</script>