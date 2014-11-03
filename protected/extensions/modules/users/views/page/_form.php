
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	'action'=>$this->createUrl("create"),
	'htmlOptions'=>array("class"=>"form-horizontal","role"=>"form"),
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnChange'=>false,
		'validateOnSubmit'=>true,		
		'beforeValidate'=>"js:function(form){
			$('.button-submit').addClass('disabled');
			$('.fa.fa-cog.fa-spin.spiner').removeClass('hide');
			return true;
		}",
		'afterValidate'=>"js:function(form,data,hasError){ 
			if(!hasError) {
				form.each (function(){
				  this.reset();
				});
				$('.fa.fa-cog.fa-spin.spiner').addClass('hide');
				$('.button-submit').removeClass('disabled');
				$.fn.yiiGridView.update('users-grid', {
					// data: { '".get_class($model)."':  }
				});
				$('#add').modal('hide');
				return false;
			}
			return false;
		}",
	),
)); ?>


	<div class="col-lg-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'name',array('class'=>'control-label')); ?>
			<?php echo $form->textField($model,'name',array('rows'=>3, 'cols'=>50,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'name',array('class'=>'help-block')); ?>
	    </div>
	</div>

	<div class="col-lg-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
			<?php echo $form->textField($model,'lastname',array('rows'=>3, 'cols'=>50,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'lastname',array('class'=>'help-block')); ?>
	    </div>
	</div>

	<div class="col-lg-12">
		<div class="form-group">
			<?php echo $form->labelEx($model,'email',array('class'=>'control-label')); ?>
			<?php echo $form->textField($model,'email',array('rows'=>3, 'cols'=>50,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'email',array('class'=>'help-block')); ?>
	    </div>
	</div>


<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Cancelar</button>
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large button-submit')); ?>
</div>
<?php $this->endWidget(); ?>
