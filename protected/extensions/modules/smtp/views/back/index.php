<?php
/* @var $this BackController */
/* @var $model SmptConfig */

$this->breadcrumbs=array(
	'Actualizando',
);
?>

<div class="col-lg-12">
<?php foreach(Yii::app()->user->getFlashes() as $type => $message):?>
  <div class="alert alert-<?php echo $type?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $message?>
  </div>
<?php endforeach;?>

<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap ">

<?php $this->renderPartial('test',array('model'=>new SmtpTest));?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'smpt-config-form',
	'htmlOptions'=>array("class"=>"","role"=>"form"),
	'enableAjaxValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
	<div class="col-lg-12">
	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-danger')); ?>

    <div class="form-group">
        <div class="pull-right">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>
		 </div>
    </div>
<div class="row">
	<div class="col-lg-6">
	<div class="form-group">
		<?php echo $form->labelEx($model,'enabled',array('class'=>'control-label')); ?>
		<?php echo $form->checkBox($model,'enabled'); ?>
		<?php echo $form->error($model,'enabled',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'host_email_server',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'host_email_server',
				'allowed' => 150,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'host_email_server',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'port_email_server',array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'port_email_server',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'port_email_server',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'username_email_server',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'username_email_server',
				'allowed' => 150,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'username_email_server',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'password_email_server',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'password_email_server',
				'allowed' => 150,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'password_email_server',array('class'=>'help-block')); ?>
    </div>
	
	</div>
	<div class="col-lg-6 text-center">
		
		
		<?php foreach($this->module->getTemplatesAvailables() as $template):?>		
			<div class="row mtl">
				<div class="col-lg-6">
					<a class="btn btn-lg btn-block btn-success send-test" data-template="<?php echo $template?>" href="#">Send to <strong><?php echo $template?></strong> Template</a>
				</div>
				<div class="col-lg-6">
					<a class="btn btn-lg btn-block btn-info" target="_blank" href="<?php echo $this->createUrl('preview',array('template'=>$template))?>">Preview <strong><?php echo $template?></strong> Template</a>
				</div>
			</div>
		<?php endforeach;?>		
			
	</div>
</div>
   
    <div class="form-group">
        <div class="pull-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>
        </div>
    </div>
	
	</div>
<?php $this->endWidget(); ?>
        </div>
    </div>
</section>

</div>
<script>
$(function(){
	$('.send-test').on('click',function(e){
		e.preventDefault();
		$('#SmtpTest_template').val($(this).attr('data-template'));
		$('#smtp-test-modal').modal('show');
	});	
})
</script>