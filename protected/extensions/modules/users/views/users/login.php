<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>
<div class="header"><?php echo Yii::t('app','Login')?></div>
<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'login-form',
  'htmlOptions'=>array("class"=>"form-signin"),
  'enableClientValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
)); ?>
<?php echo $form->errorSummary($model,"","",array("class"=>"alert alert-danger"))?>
<div class="body bg-gray">
    <div class="form-group">
        <?php echo $form->textField($model,'username',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('username'))); ?>
    </div>
    <div class="form-group">
        <?php echo $form->passwordField($model,'password',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('password'))); ?>
    </div>          
    <div class="form-group">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
         <?php echo $form->label($model,'rememberMe'); ?>
    </div>
</div>
<div class="footer">                                                               
    <button type="submit" class="btn bg-olive btn-block"><?php echo Yii::t('app','Sign me in')?></button>  
    
    <p><a data-toggle="modal" href="#myModal"> <?php echo Yii::t('app',"Forgot Password?")?></a></p>
    
    <?php echo Yii::t('app',"Don't have an account yet?")?>
    <a class="text-center" href="<?php echo $this->createUrl("/site/registration")?>">
        <?php echo Yii::t('app',"Create an account")?>
    </a>
    
</div>
<?php $this->endWidget(); ?>

<div class="margin text-center">
    <span>Sign in using social networks</span>
    <br/>
    <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
    <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
    <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

</div>