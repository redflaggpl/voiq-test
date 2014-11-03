<?php
/* @var $this ProfilesController */
/* @var $model UsersAuthitem */
/* @var $form CActiveForm */
?>
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap ">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-authitem-form',
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
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'name',
				'allowed' => 64,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'name',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'type',array('class'=>'control-label')); ?>
		<?php echo $form->dropDownList($model,'type',UsersAuthitem::types(),array('class'=>'form-control')) ?>
		<?php echo $form->error($model,'type',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'description',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextarea',array(
				'model'=>$model,
				'attribute'=>'description',
				'allowed' => 1000,
				'htmlOptions' => array('class'=>'form-control','rows'=>5, 'cols'=>50),
			),true); ?>
		<?php echo $form->error($model,'description',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'bizrule',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextarea',array(
				'model'=>$model,
				'attribute'=>'bizrule',
				'allowed' => 1000,
				'htmlOptions' => array('class'=>'form-control','rows'=>5, 'cols'=>50),
			),true); ?>
		<?php echo $form->error($model,'bizrule',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'data',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextarea',array(
				'model'=>$model,
				'attribute'=>'data',
				'allowed' => 1000,
				'htmlOptions' => array('class'=>'form-control','rows'=>5, 'cols'=>50),
			),true); ?>
		<?php echo $form->error($model,'data',array('class'=>'help-block')); ?>
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
