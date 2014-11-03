<?php
/* @var $this SmtpTestController */
/* @var $model SmtpTest */
/* @var $form CActiveForm */
?>

<!-- ////////////////////////////////////////////////// -->
<!-- Modal in order to view detail of -->
<!-- ////////////////////////////////////////////////// -->
<div class="modal fade" id="smtp-test-modal" tabindex="-1" role="smtp-test-modal" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h4 class="modal-title"><?php echo Yii::t('app','SmtpTest')?></h4>
        </div>
    	<div class="modal-body">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'smtp-test-form',
	'action'=>$this->createUrl('back/test'),
	'htmlOptions'=>array('class'=>'form-horizontal','role'=>'form'),
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnChange'=>false,
		'validateOnSubmit'=>true,		
		'beforeValidate'=>"js:function(form){
	    	$('.smtp-test-submit').addClass('disabled');
	    	$('.smtp-test-loading').removeClass('hide');
	    	return true;
	    }",
		'afterValidate'=>"js:function(form,data,hasError){ 
	    	$('.smtp-test-submit').removeClass('disabled');
	    	$('.smtp-test-loading').addClass('hide');
			if(!hasError) {
				form.each (function(){
				  this.reset();
				});
				if(data.result==1) {
					bootbox.alert('Enviado con éxito: '+data.message);
		   		} else {
					bootbox.alert('No se envió: '+data.message);
				}
				$('#smtp-test-modal').modal('hide');
				return false;
			}
			return false;
		}",
	),
)); ?>

	<?php echo $form->hiddenField($model,'template'); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email_test',array('class'=>'control-label')); ?>
		<?php echo $form->textField($model,'email_test',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'email_test',array('class'=>'help-block')); ?>
    </div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'area_test',array('class'=>'control-label')); ?>
		<?php echo $form->textArea($model,'area_test',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'area_test',array('class'=>'help-block')); ?>
    </div>
   
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal"><?php echo Yii::t('app','Cancel')?></button>
	<i class="hide fa fa-cog fa-spin spiner smtp-test-loading"></i>
	<?php echo CHtml::submitButton(Yii::t('app','Send'),array('class'=>'smtp-test-submit btn btn-primary btn-large')); ?>
</div>
<?php $this->endWidget(); ?>

        </div>
        </div>
    </div>
</div>