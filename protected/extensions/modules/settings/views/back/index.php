<?php
/* @var $this BackController */
/* @var $model Settings */

$this->breadcrumbs=array(
	'Actualizando',
);
?>

<div class="col-lg-12">
<?php foreach(Yii::app()->user->getFlashes() as $type => $message):?>
  <div class="alert alert-<?php echo $type?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $message?>
  </div>
<?php endforeach;?>

<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap ">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'settings-form',
	'htmlOptions'=>array("class"=>"","role"=>"form"),
	'enableAjaxValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
	<div class="col-lg-12">
	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-danger')); ?>

    <div class="form-group">
        <div class="pull-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>
        </div>
    </div>
	
	<div class="col-lg-6">
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'admin_email',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'admin_email',
				'allowed' => 255,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'admin_email',array('class'=>'help-block')); ?>
    </div>


	<div class="form-group">
		<?php echo $form->labelEx($model,'title',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextfield',array(
				'model'=>$model,
				'attribute'=>'title',
				'allowed' => 100,
				'htmlOptions' => array('class'=>'form-control'),
			),true); ?>
		<?php echo $form->error($model,'title',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'keywords',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextarea',array(
				'model'=>$model,
				'attribute'=>'keywords',
				'allowed' => 1000,
				'htmlOptions' => array('class'=>'form-control','rows'=>5, 'cols'=>50),
			),true); ?>
		<?php echo $form->error($model,'keywords',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group">
		<?php echo $form->labelEx($model,'description',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.inputs.counter.GTextarea',array(
				'model'=>$model,
				'attribute'=>'description',
				'allowed' => 1000,
				'htmlOptions' => array('class'=>'form-control','rows'=>5, 'cols'=>50),
			),true); ?>
		<?php echo $form->error($model,'description',array('class'=>'help-block')); ?>
    </div>
		
	</div>
	<div class="col-lg-6">
			<div class="form-group">
		<?php echo $form->checkBox($model,'offline'); ?>
		<?php echo $form->labelEx($model,'offline',array('class'=>'control-label')); ?>
		<?php echo $form->error($model,'offline',array('class'=>'help-block')); ?>
    </div>
   
	<div class="form-group well" style="background-color: transparent;">
	<?php echo $form->labelEx($model,'editor_offline_message',array('class'=>'control-label')); ?>
	<?php echo $form->error($model,'editor_offline_message',array('class'=>'help-block')); ?>
	<?php echo $this->widget('ext.inputs.sir-trevor.GSirTrevor',array(
		    'model'=>$model,
		    'attribute'=>'editor_offline_message',
			'uploadUrl'=>$this->createUrl('upload'),
			// list of avalilables blocks
			'blockTypes'=>array(
				"Heading",
				"Text",
				"List",
				"Quote",
				"Image",
				"Video",
				"Tweet"
			),
			'blockLimit'=>0, // 0 is infinite bloks
			'required'=>array('Text'),
			'onEditorRender'=>'js:function(){
				console.log("Do something")
			}',
			// 'blockTypeLimits'=>array(
			// 	'Text'=>'2',
			// 	'Image'=>'1',
			// ),
		),true);?>
	</div>
   
		
	</div>
   
    <div class="form-group">
        <div class="pull-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>
        </div>
    </div>

	</div>
<?php $this->endWidget(); ?>
        </div>
    </div>
</section>

</div>