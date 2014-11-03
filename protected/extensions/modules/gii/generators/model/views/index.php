<?php
$class=get_class($model);
Yii::app()->clientScript->registerScript('gii.model',"
$('#{$class}_connectionId').change(function(){
	var tableName=$('#{$class}_tableName');
	tableName.autocomplete('option', 'source', []);
	$.ajax({
		url: '".Yii::app()->getUrlManager()->createUrl('gii/model/getTableNames')."',
		data: {db: this.value},
		dataType: 'json'
	}).done(function(data){
		tableName.autocomplete('option', 'source', data);
	});
});
$('#{$class}_modelClass').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#{$class}_tableName').bind('keyup change', function(){
	var model=$('#{$class}_modelClass');
	var tableName=$(this).val();
	if(tableName.substring(tableName.length-1)!='*') {
		$('.form .row.model-class').show();
	}
	else {
		$('#{$class}_modelClass').val('');
		$('.form .row.model-class').hide();
	}
	if(!model.data('changed')) {
		var i=tableName.lastIndexOf('.');
		if(i>=0)
			tableName=tableName.substring(i+1);
		var tablePrefix=$('#{$class}_tablePrefix').val();
		if(tablePrefix!='' && tableName.indexOf(tablePrefix)==0)
			tableName=tableName.substring(tablePrefix.length);
		var modelClass='';
		$.each(tableName.split('_'), function() {
			if(this.length>0)
				modelClass+=this.substring(0,1).toUpperCase()+this.substring(1);
		});
		model.val(modelClass);
	}
});
$('.form .row.model-class').toggle($('#{$class}_tableName').val().substring($('#{$class}_tableName').val().length-1)!='*');
");
?>

<div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
     
<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>

	<?php echo $form->hiddenField($model, 'connectionId', array('size'=>65,'class'=>'form-control'))?>
	<?php echo $form->hiddenField($model,'tablePrefix', array('size'=>65,'class'=>'form-control')); ?>
	<?php echo $form->hiddenField($model,'baseClass',array('size'=>65,'class'=>'form-control')); ?>
	<?php $model->buildRelations=1; ?>
	<?php echo $form->hiddenField($model,'buildRelations',array('class'=>'form-control')); ?>
	<?php echo $form->hiddenField($model,'modelPath', array('size'=>65,'class'=>'form-control')); ?>
<div class="row">
	<div class="col-lg-4">
	<div class="form-group">

		<?php echo $form->labelEx($model,'tableName', array('class' => 'control-label')); ?>
		<?php #echo $form->textField($model,'tableName',array('size'=>65,'class'=>'form-control')); ?>
		<?php $this->widget('ext.inputs.select2.ESelect2',array(
			  'model'=>$model,
			  'attribute'=>'tableName',
			  'data'=>$model->listDataTables(),
			  'htmlOptions'=>array('class'=>'form-control'),
			  'options'=>array(
			    'placeholder'=>'Search table...',
			  ),
			)); ?>
		<?php echo $form->error($model,'tableName'); ?>
	</div>
		
    <div class="form-group">
		<?php echo $form->label($model,'modelClass',array('required'=>true)); ?>
		<?php echo $form->textField($model,'modelClass', array('size'=>65,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'modelClass'); ?>
	</div>
		
    <div class="form-group">
		<?php 
		$modules=array();
		foreach(Yii::app()->getModules() as $id=>$params)
		{
			$core='';
			if(in_array($id, $this->module->noModules))
				$core='[CORE] ';
			if($params and strpos($params['class'], 'ext.')!==false)
				$modules[$id]=$core.$id;
			else
				$modules[$id]=$core.$id;
		}
		 ?>
		<?php echo $form->labelEx($model,'moduleName', array('class' => 'control-label')); ?>
		<?php echo $form->dropDownList($model,'moduleName',$modules,array('class'=>'form-control','empty'=>'Select module...')); ?>
		<?php echo $form->error($model,'moduleName'); ?>
	</div>
	
<?php $this->endWidget(); ?>
  </div>
    </div>
</section>
</div>