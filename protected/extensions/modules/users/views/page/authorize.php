<?php
/* @var $this AppsController */
/* @var $model Apps */

$this->breadcrumbs=array(
	'Apps'=>array('admin'),
	'API',
);

?>
<div class="row">
	<div class="col-lg-12">

<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
				
        <?php if(Yii::app()->user->isGuest):?>
            <div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        
        <h2 class="header"><?php echo Yii::t('app','Sign In')?></h2>
<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'login-form',
  'htmlOptions'=>array("class"=>"form-signin"),
  'enableAjaxValidation'=>true,
  'clientOptions'=>array('validateOnSubmit'=>true),
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
    <a class="text-center" href="<?php echo $this->createUrl("/users/page/registration")?>">
        <?php echo Yii::t('app',"Create an account")?>
    </a>
    
</div>
<?php $this->endWidget(); ?>


    </div>
    <div class="col-lg-4"></div>
</div>
        <?php else:?>

        <div class="bs-docs-section" role="main">
            <div class="row">
            <h3>Welcome, api owner!</h3>

            
            <p>Click the button below to complete the authorize request and grant an <code>Authorization Code</code> to <?php echo $app->name?> we.</p>
        </div>
        <div class="row">
            <a href="<?php echo $this->createUrl('authorizeSubmit').'?'.http_build_query(array_merge($params,array('authorize'=>1)))?>" class="btn btn-default">
                Yes, I Authorize This Request
            </a>
            <a href="<?php echo $this->createUrl('authorizeSubmit').'?'.http_build_query(array_merge($params,array('authorize'=>0)))?>" class="btn btn-primary btn-sm">
                get me out of here!
            </a>
        </div>
    <div>
    </div>


</div>
        <?php endif;?>
        
        </div>
    </div>
</section>


		
	</div>
</div>