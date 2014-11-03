<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="forgotModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
  <?php $form=$ctr->beginWidget('CActiveForm', array(
      'id'=>'recover-form',
      'action'=>$ctr->createUrl('/'.$module->id.'/page/forgot'),
      'htmlOptions'=>array("class"=>"form-signin"),
      'enableAjaxValidation'=>true,
      'enableClientValidation'=>false,
      'clientOptions'=>array(
        'validateOnSubmit'=>true,
      ),
  )); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="forgotModalLabel"><?php echo Yii::t('app','Forgot')?></h4>
      </div>
    <div class="modal-body">
  <?php #echo $form->errorSummary($model,"","",array("class"=>"alert alert-danger")); ?>
    
    <em><small><?php echo CHtml::link(Yii::t('app',"Sign Up"),array('#'),array('class'=>'module-users-register'))?>, <?php echo CHtml::link(Yii::t('app',"Sign In"),array('#'),array('class'=>'module-users-login'))?></small></em>

    
    <div class="form-group">
        <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
        <?php echo $form->textField($model,'email',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('email'))); ?>
        <?php echo $form->error($model,'email',array('class'=>'help-block')); ?>
    </div>  
        
   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php echo CHtml::submitButton(Yii::t('app','Remenber'),array("class"=>"btn btn-lg btn-primary")); ?>
     </div>
  <?php $ctr->endWidget(); ?>
    
    </div>
  </div>
</div>
