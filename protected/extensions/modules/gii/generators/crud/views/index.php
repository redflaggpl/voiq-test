<?php
$class=get_class($model);
Yii::app()->clientScript->registerScript('gii.crud',"
$('#{$class}_controller').change(function(){
	$(this).data('changed',$(this).val()!='');
});
$('#{$class}_template').change(function(){
	if($(this).val()=='cms-manny-modal') {
		$('.foraneKey-container').show();		
	} else {
		$('.foraneKey-container').hide();	
	}
});
$('#{$class}_model').bind('keyup change', function(){
	var controller=$('#{$class}_controller');
	if(!controller.data('changed')) {
		var id=new String($(this).val().match(/\\w*$/));
		if(id.length>0)
			id=id.toLowerCase();
			//id=id.substring(0,1).toLowerCase()+id.substring(1);
		controller.val(id);
	}
});

");
?>
<style>
	label {
		display: inline!important;
	}
</style>
<div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
        	
<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>
<div class="row">
	<div class="col-lg-4">
	
	<?php echo $form->hiddenField($model,'baseControllerClass',array('size'=>65,'class'=>'form-control')); ?>
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
		$htmlOptions=array( 
			'ajax' => array(
				'type'=>'POST', //request type
				'url'=>$this->createUrl('modelsDynamic'), //url to call.
				'update'=>'#'.get_class($model).'_model', //selector to update
			),
			'empty'=>'',
			'class'=>'form-control'
		);?>
		<?php echo $form->labelEx($model,'moduleName', array('class' => 'control-label')); ?>
		<?php echo $form->dropDownList($model,'moduleName',$modules,$htmlOptions); ?>
		<?php echo $form->error($model,'moduleName'); ?>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->dropDownList($model,'model',$this->module->getListDataModels($model->moduleName,$this->codeModel),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'model'); ?>
	</div>

	
	<div class="form-group">
		<?php echo $form->labelEx($model,'controller'); ?>  <small class="text-muted">This is the name for controller, this will show on the url eg.: services/nameAction </small>
		<?php echo $form->textField($model,'controller',array('size'=>65,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'controller'); ?>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'labelName'); ?> <small class="text-muted">Whrite here name of section to generate</small>
		<?php echo $form->textField($model,'labelName',array('size'=>65,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'labelName'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'fontIcon'); ?> <small class="text-muted">Select one from <a href="http://fontawesome.io/icons/" target="_blank">here http://fontawesome.io/icons/</a> just put somethng like this on the case that you can a nice rocket <code>fa-rocket</code></small>
		<?php echo $form->textField($model,'fontIcon',array('size'=>65,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'fontIcon'); ?>
	</div>

	<div class="form-group foraneKey-container"<?php echo $model->template=='cms-manny-modal'?"":" style=\"display:none\""?>>
		<?php echo $form->labelEx($model,'foraneKey'); ?>
		<?php echo $form->textField($model,'foraneKey',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'foraneKey'); ?>
	</div>
	
<?php $this->endWidget(); ?>

        </div>
    </div>
</section>
</div>
