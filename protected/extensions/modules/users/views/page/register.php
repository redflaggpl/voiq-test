<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
?>
<h1><?php echo Yii::t('app','Sign Up')?></h1>
<em><small><?php echo Yii::t('app',"You have an account?")?> <?php echo CHtml::link(Yii::t('app',"Sign In"),$this->module->urlLogin)?></small></em>
<div class="row">
    <div class="col-lg-6">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'registration-form',
		'htmlOptions'=>array("class"=>"form-signin"),
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>false,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
	<?php #echo $form->errorSummary($model,"","",array("class"=>"alert alert-danger")); ?>

	<div class="form-group">
        <?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
	   	<?php echo $form->textField($model,'name',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('name'))); ?>
        <?php echo $form->error($model,'name',array('class'=>'help-block')); ?>
	</div>	
	 
	 <div class="form-group">
        <?php echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
   		<?php echo $form->textField($model,'lastname',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('lastname'))); ?>
        <?php echo $form->error($model,'lastname',array('class'=>'help-block')); ?>
	 </div>
	
	 <div class="form-group">
        <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'email',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('email'))); ?>
        <?php echo $form->error($model,'email',array('class'=>'help-block')); ?>
	 </div>

	 <?php if(!$this->module->sendPassword):?>
	 <div class="form-group">
        <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('password'))); ?>
        <?php echo $form->error($model,'password',array('class'=>'help-block')); ?>
	 </div>
 	 <?php endif;?>

	<div class="form-group">
     <?php echo $form->checkBox($model,'conditions'); ?>
     <?php echo $form->label($model,'conditions'); ?> <br>
     <?php echo $form->error($model,'conditions',array('class'=>'help-block')); ?>
	</div>
	
	<?php echo CHtml::submitButton(Yii::t('app','Sign up'),array("class"=>"pull-right btn btn-lg btn-primary")); ?>
	<?php $this->endWidget(); ?>

  </div>
  <div class="col-lg-6">
  	<!-- Espacio para poner aqui las redes sociales -->
  </div>
</div>