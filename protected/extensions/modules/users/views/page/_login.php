<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
  <?php $form=$ctr->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'action'=>$ctr->createUrl('/'.$module->id.'/page/login'),
    'htmlOptions'=>array("class"=>"form-signin"),
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>false,
    'clientOptions'=>array(
      'validateOnSubmit'=>true
    ),
  )); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="loginModalLabel"><?php echo Yii::t('app','Sign In')?></h4>
      </div>
    <div class="modal-body">
  <?php #echo $form->errorSummary($model,"","",array("class"=>"alert alert-danger")); ?>
    
  <em><small><?php echo Yii::t('app',"You do not have an account yet?")?> <?php echo CHtml::link(Yii::t('app',"Sign Up"),array('#'),array("class"=>"module-users-register"))?></small></em>
  <em><small>, If fotgot your password please <?php echo CHtml::link(Yii::t('app',"click here"),array('#'),array("class"=>"module-users-forgot"))?></small></em>

    <div class="form-group">
        <?php echo $form->labelEx($model,'username',array('class'=>'control-label')); ?>
        <?php echo $form->textField($model,'username',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('username'))); ?>
        <?php echo $form->error($model,'username',array('class'=>'help-block')); ?>
    </div>  
    
     <div class="form-group">
        <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
        <?php echo $form->passwordField($model,'password',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('password'))); ?>
        <?php echo $form->error($model,'password',array('class'=>'help-block')); ?>
     </div>
    
    <div class="form-group">
     <?php echo $form->checkBox($model,'rememberMe'); ?>
     <?php echo $form->label($model,'rememberMe'); ?> <br>
    </div>
    
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       <?php echo CHtml::submitButton(Yii::t('app','Sign in'),array("class"=>"btn btn-lg btn-primary")); ?>
     </div>
  <?php $ctr->endWidget(); ?>
    
    </div>
  </div>
</div>
