<?php
/* @var $this CrmcontactController */
/* @var $model CrmContact */
/* @var $form CActiveForm */
?>
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap ">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'crm-contact-form',
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
<div class="row">
	<div class="col-lg-6">

<div class="form-group">
	<?php echo $form->labelEx($model,'firstname',array('class'=>'control-label')); ?>
	<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'firstname',
				'allowed' => 45,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
	<?php echo $form->error($model,'firstname',array('class'=>'help-block')); ?>
</div>
<div class="form-group">
	<?php echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
	<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'lastname',
				'allowed' => 45,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
	<?php echo $form->error($model,'lastname',array('class'=>'help-block')); ?>
</div>
<div class="form-group">
	<?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
	<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'email',
				'allowed' => 45,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
	<?php echo $form->error($model,'email',array('class'=>'help-block')); ?>
</div>
	</div>
	<div class="col-lg-6">
<div class="form-group">
	<?php echo $form->labelEx($model,'sex',array('class'=>'control-label')); ?>
	<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'sex',
				'allowed' => 1,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
	<?php echo $form->error($model,'sex',array('class'=>'help-block')); ?>
</div>
<div class="form-group">
	<?php echo $form->labelEx($model,'id_number',array('class'=>'control-label')); ?>
	<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'id_number',
				'allowed' => 45,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
	<?php echo $form->error($model,'id_number',array('class'=>'help-block')); ?>
</div>
	</div>
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
