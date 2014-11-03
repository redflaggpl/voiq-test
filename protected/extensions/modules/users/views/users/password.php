<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Recuperar contraseña';
?>

<div class="col-lg-4"></div>
<div class="col-lg-4">
  <h4 class="text-center">Recuperar contraseña</h4>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'login-form',
  'htmlOptions'=>array("class"=>"form-signin"),
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
)); ?>
   <div>
      <?php echo $form->labelEx($model,'password'); ?>
      <?php echo $form->passwordField($model,'password',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('password'))); ?>
      <?php echo $form->error($model,'password',array('class'=>'help-block')); ?>
    </div>

    <div class="mbl">
      <?php echo $form->labelEx($model,'passwordConfirm'); ?>
      <?php echo $form->passwordField($model,'passwordConfirm',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('password'))); ?>
      <?php echo $form->error($model,'passwordConfirm',array('class'=>'help-block')); ?>
    </div>
  <?php echo CHtml::submitButton(Yii::t('app','Send'),array("class"=>"btn btn-lg btn-login btn-block")); ?>

<?php $this->endWidget(); ?>
</div>
<div class="col-lg-4"></div>
