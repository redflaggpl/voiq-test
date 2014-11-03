<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-form',
	'htmlOptions'=>array("class"=>"form-signin"),
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<h2 class="form-signin-heading"><?php echo Yii::t('app','sign up now')?></h2>
<div class="login-wrap">
	<?php echo $form->errorSummary($model,"","",array("class"=>"alert alert-danger","style"=>"margin-top: -20px;
margin-left: -20px;
margin-right: -20px;
border-radius: 0;")); ?>
    <div class="user-login-info">
		<?php echo $form->textField($model,'name',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('name'))); ?>
		<?php echo $form->textField($model,'lastname',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('lastname'))); ?>
		<?php echo $form->textField($model,'email',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('email'))); ?>
		<?php if(!$this->module->sendPassword):?>
			<?php echo $form->passwordField($model,'password',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('password'))); ?>
		<?php endif;?>
	</div>
	<?php echo CHtml::submitButton(Yii::t('app','Sign up'),array("class"=>"btn btn-lg btn-login btn-block")); ?>
    <div class="registration">
        <?php echo Yii::t('app',"You have an account?")?>
        <?php echo CHtml::lunk(Yii::t('app',"Sign in"),$this->module->urlLogin)?>
        
    </div>
</div>
<?php $this->endWidget(); ?>
