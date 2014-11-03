<?php
/* @var $this SiteController */
/* @var $user LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Profile';
?>
<div class="row">
    <div class="col-lg-6">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'users-form',
        'htmlOptions'=>array("class"=>"form-horizontal","role"=>"form"),
        'enableAjaxValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>true),
    )); ?>
    <?php #echo $form->errorSummary($user,"","",array("class"=>"alert alert-danger")); ?>


    <?php echo CHtml::image($user->getImageUrl(),"",array("style"=>"width: 70px;margin: 20px auto;","class"=>"img-responsive img-circle")) ?>

   
    <div class="form-group">
        <?php echo $form->labelEx($user,'email',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'email',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'email',array('class'=>'help-block')); ?>
    </div>
   
    <div class="form-group">
        <?php echo $form->labelEx($user,'name',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'name',array('class'=>'help-block')); ?>
    </div>
   
    <div class="form-group">
        <?php echo $form->labelEx($user,'lastname',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'lastname',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'lastname',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($user,'address',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'address',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'address',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($user,'phone',array('class'=>'control-label')); ?>
        <?php echo $form->textField($user,'phone',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($user,'phone',array('class'=>'help-block')); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($user,'birthdate',array('class'=>'control-label')); ?>
        <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $user,
                'attribute' => 'birthdate',
                'language' =>  Yii::app()->language,
                'htmlOptions' => array('class'=>'form-control'),
                'options' => array(
                    'showButtonPanel' => true,
                    'changeYear' => true,
                    'dateFormat' => 'yy-mm-dd',
                ),
            ));
        ?>
        <?php echo $form->error($user,'birthdate',array('class'=>'help-block')); ?>
    </div>
    
    <div class="form-group">
        <?php echo $form->labelEx($user,'newPassword',array('class'=>'control-label')); ?>
        <?php echo $form->passwordField($user,'newPassword',array('class'=>'form-control',"placeholder"=>$user->getAttributeLabel('newPassword'))); ?>
        <?php echo $form->error($user,'newPassword',array('class'=>'help-block')); ?>
    </div>
    
    <?php echo CHtml::submitButton(Yii::t('app','Change'),array("class"=>"btn pull-right btn-lg btn-primary")); ?>
    <?php $this->endWidget(); ?>

  </div>
  <div class="col-lg-6">
    <!-- Espacio para poner aqui las redes sociales -->
  </div>
</div>