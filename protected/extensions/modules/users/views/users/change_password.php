<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Cambiar contraseña';
?>

<div class="col-lg-12 mbl">&nbsp;</div>
<div class="col-lg-4"></div>
<div class="col-lg-4">
  <h4 class="text-center">Cambiar contraseña</h4>
<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'login-form',
  'htmlOptions'=>array("class"=>"change-password-form"),
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
)); ?>

    <div>
      <?php echo $form->labelEx($model,'oldPassword'); ?>
      <?php echo $form->passwordField($model,'oldPassword',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('oldPassword'))); ?>
      <?php echo $form->error($model,'oldPassword',array('class'=>'help-block')); ?>
    </div>

    <div class="mbl">
      <?php echo $form->labelEx($model,'newPassword'); ?>
      <?php echo $form->passwordField($model,'newPassword',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('newPassword'))); ?>
      <?php echo $form->error($model,'newPassword',array('class'=>'help-block')); ?>
    </div>


  <?php echo CHtml::submitButton(Yii::t('app','Update'),array("class"=>"btn btn-lg btn-login btn-block")); ?>
 <?php echo CHtml::link('¿Olvidé mi contraseña?',array('admin/users/forgot'))?>
<?php $this->endWidget(); ?>
</div>
<div class="col-lg-4"></div>
