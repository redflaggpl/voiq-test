<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Change password';
?>
<h1><?php echo Yii::t('app','Change password')?></h1>
<em><small><?php echo Yii::t('app',"Please, enter your new password")?></small></em>
<div class="row">
    <div class="col-lg-6">
    <?php $form=$this->beginWidget('CActiveForm', array(
      'id'=>'login-form',
      'htmlOptions'=>array("class"=>"form-signin"),
      'enableClientValidation'=>true,
      'clientOptions'=>array(
        'validateOnSubmit'=>true,
      ),
    )); ?>
    <?php #echo $form->errorSummary($model,"","",array("class"=>"alert alert-danger")); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
        <?php echo $form->passwordField($model,'password',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('password'))); ?>
        <?php echo $form->error($model,'password',array('class'=>'help-block')); ?>
    </div>
    
    <div class="form-group">
        <?php echo $form->labelEx($model,'passwordConfirm',array('class'=>'control-label')); ?>
        <?php echo $form->passwordField($model,'passwordConfirm',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('passwordConfirm'))); ?>
        <?php echo $form->error($model,'passwordConfirm',array('class'=>'help-block')); ?>
    </div>
    
    <?php echo CHtml::submitButton(Yii::t('app','Change'),array("class"=>"btn pull-right btn-lg btn-primary")); ?>
    <?php $this->endWidget(); ?>

  </div>
  <div class="col-lg-6">
    <!-- Espacio para poner aqui las redes sociales -->
  </div>
</div>