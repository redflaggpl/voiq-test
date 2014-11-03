<?php
/* @var $this Email_welcomeController */
/* @var $model UsersConfig */

$this->breadcrumbs=array(
	Yii::t('app','Update'),
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
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-config-form',
	'htmlOptions'=>array("class"=>"","role"=>"form"),
	'enableAjaxValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
	<div class="col-lg-12">
	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-danger')); ?>

    <div class="form-group">
        <div class="text-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>
        </div>
    </div>

<div class="row">
    <div class="col-lg-12">

<?php if(!$this->module->sendPassword):?>
<div class="form-group">
    <?php echo $form->labelEx($model,'copyWelcomeEmail',array('class'=>'control-label')); ?>
    <?php echo $this->widget('yiiwheels.widgets.redactor.WhRedactor', array(
                'model'=>$model,
                'attribute'=>'copyWelcomeEmail',
                'height'=>'250px',
                'htmlOptions' => array(
                    'class' => 'form-control',
                )
            ),true)?>
    <?php echo $form->error($model,'copyWelcomeEmail',array('class'=>'help-block')); ?>
</div>
<?php else:?>
<div class="form-group">
    <?php echo $form->labelEx($model,'copySendPassword',array('class'=>'control-label')); ?>
    <?php echo $this->widget('yiiwheels.widgets.redactor.WhRedactor', array(
                'model'=>$model,
                'attribute'=>'copySendPassword',
                'height'=>'250px',
                'htmlOptions' => array(
                    'class' => 'form-control',
                )
            ),true)?>
    <?php echo $form->error($model,'copySendPassword',array('class'=>'help-block')); ?>
</div>
<?php endif;?>

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