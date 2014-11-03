<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Recuperar contraseña';
$this->breadcrumbs=array(
  'Recuperar contraseña',
);
?>
<div class="col-lg-4"></div>
<div class="col-lg-4">
  <h4 class="text-center">Recuperar contraseña</h4>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'recover-form',
  'htmlOptions'=>array("class"=>"form-signin"),
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
)); ?>
   <div>
      <?php echo $form->labelEx($model,'email'); ?>
      <?php echo $form->textField($model,'email',array('class'=>'form-control',"placeholder"=>'Escriba aquí su correo')); ?>
      <?php echo $form->error($model,'email',array('class'=>'help-block')); ?>
    </div>

  <?php echo CHtml::submitButton(Yii::t('app','Send'),array("class"=>"btn btn-lg btn-login btn-block")); ?>

<?php $this->endWidget(); ?>
</div>
<div class="col-lg-4"></div>
