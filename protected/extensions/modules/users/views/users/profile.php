<?php
/* @var $this UsersController */
/* @var $user Users */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'users-form',
    'htmlOptions'=>array("class"=>"form-horizontal","role"=>"form"),
    'enableAjaxValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
    
    <div class="col-lg-4">
    </div>
    <div class="col-lg-4">

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

   
    <!--  /////////////////// -->
    <!--  Profile data -->
    <!--  /////////////////// -->
    <?php /*
    <div class="form-group">
        <?php echo $form->labelEx($model,'user_id',array('class'=>'col-lg-3 control-label')); ?>
        <div class="col-lg-6">
        <?php echo $form->textField($model,'user_id',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'user_id',array('class'=>'help-block')); ?>
         </div>
    </div>
   
    <div class="form-group">
        <?php echo $form->labelEx($model,'address',array('class'=>'col-lg-3 control-label')); ?>
        <div class="col-lg-6">
        <?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'address',array('class'=>'help-block')); ?>
         </div>
    </div>
   
    <div class="form-group">
        <?php echo $form->labelEx($model,'phone',array('class'=>'col-lg-3 control-label')); ?>
        <div class="col-lg-6">
        <?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'phone',array('class'=>'help-block')); ?>
         </div>
    </div>
   
    <div class="form-group">
        <?php echo $form->labelEx($model,'birthdate',array('class'=>'col-lg-3 control-label')); ?>
        <div class="col-lg-6">
        <?php echo $form->textField($model,'birthdate',array('class'=>'form-control')); ?>
        <?php echo $form->error($model,'birthdate',array('class'=>'help-block')); ?>
         </div>
    </div>
   
    */ ?>

    <div class="form-group">
        <div class="">
             <a href="#change-password-modal" class="pull-left" data-toggle="modal">Cambiar contraseña</a>
        <?php echo CHtml::submitButton($user->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary pull-right')); ?>
        </div>
    </div>
    </div>
    <div class="col-lg-4">
    </div>

<?php $this->endWidget(); ?>




<!-- ////////////////////////////////////////////////// -->
<!-- Modal in order to view detail of -->
<!-- ////////////////////////////////////////////////// -->
<div class="modal fade" id="change-password-modal" tabindex="-1" role="sesiones-view-modal" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Cambiar contraseña</h4>
        </div>
        <div class="modal-body">
            <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'change-password-form',
              'action'=>$this->createUrl('changePassword'),
              'htmlOptions'=>array("class"=>"form-horizontal","role"=>"form"),
              // 'enableClientValidation'=>true,
              'enableAjaxValidation'=>true,
              'clientOptions'=>array(
                'validateOnSubmit'=>true,
              ),
            )); ?>

                <div>
                  <?php echo $form->labelEx($change,'oldPassword'); ?>
                  <?php echo $form->passwordField($change,'oldPassword',array('class'=>'form-control',"placeholder"=>$change->getAttributeLabel('oldPassword'))); ?>
                  <?php echo $form->error($change,'oldPassword',array('class'=>'help-block')); ?>
                </div>

                <div class="mbl">
                  <?php echo $form->labelEx($change,'newPassword'); ?>
                  <?php echo $form->passwordField($change,'newPassword',array('class'=>'form-control',"placeholder"=>$change->getAttributeLabel('newPassword'))); ?>
                  <?php echo $form->error($change,'newPassword',array('class'=>'help-block')); ?>
                </div>


              <?php echo CHtml::submitButton(Yii::t('app','Update'),array("class"=>"btn btn-lg btn-login btn-block")); ?>
             <?php echo CHtml::link('¿Olvidé mi contraseña?',array('users/forgot'))?>
            <?php $this->endWidget(); ?>
        </div>
        </div>
    </div>
</div>
