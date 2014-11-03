<?php
/* @var $this ConfigController */
/* @var $model UsersConfig */

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
	
	<div class="col-lg-6">
	<legend><?php echo Yii::t('app','Menu Options')?>:</legend>
	<div class="form-group">
		<?php echo $form->labelEx($model,'labelMenu',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'labelMenu',
				'allowed' => 100,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'labelMenu',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->checkBox($model,'showMenuFromAdmin'); ?>
		<?php echo $form->labelEx($model,'showMenuFromAdmin',array('class'=>'control-label')); ?>
		<?php echo $form->error($model,'showMenuFromAdmin',array('class'=>'help-block')); ?>
    </div>
   
   <br>
   <br>
   <legend><?php echo Yii::t('app','Login/Register')?>:</legend>
	<div class="form-group">
		<?php echo $form->checkBox($model,'loginInRegister'); ?>
		<?php echo $form->labelEx($model,'loginInRegister',array('class'=>'control-label')); ?>
		<?php echo $form->error($model,'loginInRegister',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->checkBox($model,'sendPassword'); ?>
		<?php echo $form->labelEx($model,'sendPassword',array('class'=>'control-label')); ?>
		<?php echo $form->error($model,'sendPassword',array('class'=>'help-block')); ?>
    </div>
   
   <br>
   <br>
   <legend><?php echo Yii::t('app','OAuth2')?>:</legend>
	<div class="form-group">
		<?php echo $form->checkBox($model,'enableOAuth'); ?>
		<?php echo $form->labelEx($model,'enableOAuth',array('class'=>'control-label')); ?>
		<?php echo $form->error($model,'enableOAuth',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->checkBox($model,'allowBasicOAuth'); ?>
		<?php echo $form->labelEx($model,'allowBasicOAuth',array('class'=>'control-label')); ?>
		<?php echo $form->error($model,'allowBasicOAuth',array('class'=>'help-block')); ?>
    </div>
    
   	
	</div>
	<div class="col-lg-6">
		
   <legend><?php echo Yii::t('app','Connect With')?>:</legend>
	<div class="form-group">
		<?php echo $form->checkBox($model,'facebookLoginRegister'); ?>
		<?php echo $form->labelEx($model,'facebookLoginRegister',array('class'=>'control-label')); ?>
		<?php echo $form->error($model,'facebookLoginRegister',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'facebookAppId',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'facebookAppId',
				'allowed' => 30,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'facebookAppId',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'facebookSecret',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'facebookSecret',
				'allowed' => 100,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'facebookSecret',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->checkBox($model,'twitterLoginRegister'); ?>
		<?php echo $form->labelEx($model,'twitterLoginRegister',array('class'=>'control-label')); ?>
		<?php echo $form->error($model,'twitterLoginRegister',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'twitterAppId',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'twitterAppId',
				'allowed' => 30,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'twitterAppId',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'twitterSecret',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'twitterSecret',
				'allowed' => 100,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'twitterSecret',array('class'=>'help-block')); ?>
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