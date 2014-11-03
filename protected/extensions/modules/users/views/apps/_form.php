<?php
/* @var $this AppsController */
/* @var $model Apps */
/* @var $form CActiveForm */
?>
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap ">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'apps-form',
	'htmlOptions'=>array("class"=>"","role"=>"form"),
	'enableAjaxValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-danger')); ?>
	<div class="col-lg-12">
    <div class="form-group">
        <div class="text-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>
		<?php echo CHtml::link(Yii::t('app','Back'),array('admin'),array('class'=>'btn btn-large btn-default'))?>        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'name',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'redirect_uri',array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'redirect_uri',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'redirect_uri',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<br>
		<?php echo $form->labelEx($model,'scopes',array('class'=>'control-label')); ?> <br>
		<?php $selected_keys = array_keys(CHtml::listData( $model->scopesapp, 'name' , 'name')); ?>
		<?php echo CHtml::checkBoxList('Apps[scopes][]',$selected_keys,UsersAuthitem::listData(),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'scopes',array('class'=>'help-block')); ?>
    </div>
   
    <div class="form-group">
        <div class="text-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>
		<?php echo CHtml::link(Yii::t('app','Back'),array('admin'),array('class'=>'btn btn-large btn-default'))?>        </div>
    </div>

	</div>
<?php $this->endWidget(); ?>
        </div>
    </div>
</section>
