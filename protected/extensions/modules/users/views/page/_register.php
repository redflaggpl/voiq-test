<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	<?php $form=$ctr->beginWidget('CActiveForm', array(
		'id'=>'registration-form',
		'action'=>$ctr->createUrl('/'.$module->id.'/page/register'),
		'htmlOptions'=>array("class"=>"form-signin"),
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>false,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="registerModalLabel"><?php echo Yii::t('app','Sign Up')?></h4>
      </div>
  	<div class="modal-body">
	<?php #echo $form->errorSummary($model,"","",array("class"=>"alert alert-danger")); ?>
	
	<em><small><?php echo Yii::t('app',"You have an account?")?> <?php echo CHtml::link(Yii::t('app',"Sign In"),array('#'),array("class"=>"module-users-login"))?></small></em>
	
	<div class="form-group">
        <?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
	   	<?php echo $form->textField($model,'name',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('name'))); ?>
        <?php echo $form->error($model,'name',array('class'=>'help-block')); ?>
	</div>	
	 
	 <div class="form-group">
        <?php echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
   		<?php echo $form->textField($model,'lastname',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('lastname'))); ?>
        <?php echo $form->error($model,'lastname',array('class'=>'help-block')); ?>
	 </div>
	
	 <div class="form-group">
        <?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'email',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('email'))); ?>
        <?php echo $form->error($model,'email',array('class'=>'help-block')); ?>
	 </div>

	 <?php if(!$module->sendPassword):?>
	 <div class="form-group">
        <?php echo $form->labelEx($model,'password',array('class'=>'control-label')); ?>
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control',"placeholder"=>$model->getAttributeLabel('password'))); ?>
        <?php echo $form->error($model,'password',array('class'=>'help-block')); ?>
	 </div>
 	 <?php endif;?>

	<div class="form-group">
     <?php echo $form->checkBox($model,'conditions'); ?>
     <?php echo $form->label($model,'conditions'); ?> <br>
     <?php echo $form->error($model,'conditions',array('class'=>'help-block')); ?>
	</div>
	

  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<?php echo CHtml::submitButton(Yii::t('app','Sign up'),array("class"=>"btn btn-lg btn-primary")); ?>
      </div>
	<?php $ctr->endWidget(); ?>
    
    </div>
  </div>
</div>
	