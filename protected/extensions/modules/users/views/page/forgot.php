<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Forgot';
?>
<h1><?php echo Yii::t('app','Forgot')?></h1>
<em><small><?php echo CHtml::link(Yii::t('app',"Sign Up"),$this->module->urlRegister)?>, <?php echo CHtml::link(Yii::t('app',"Sign In"),$this->module->urlLogin)?></small></em>
<div class="row">
    <div class="col-lg-6">
    <?php $form=$this->beginWidget('CActiveForm', array(
      'id'=>'recover-form',
      'htmlOptions'=>array("class"=>"form-signin"),
      'enableClientValidation'=>true,
      'clientOptions'=>array(
        'validateOnSubmit'=>true,
      ),
    )); ?>
    <?php #echo $form->errorSummary($model,"","",array("class"=>"alert alert-danger")); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
        <?php echo $form->textField($model,'email',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('email'))); ?>
        <?php echo $form->error($model,'email',array('class'=>'help-block')); ?>
    </div>  
        
    <?php echo CHtml::submitButton(Yii::t('app','Remenber'),array("class"=>"btn pull-right btn-lg btn-primary")); ?>
    <?php $this->endWidget(); ?>

  </div>
  <div class="col-lg-6">
    <!-- Espacio para poner aqui las redes sociales -->
  </div>
</div>
