<?php
/* @var $this BackController */
/* @var $model HomeHome */

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
	'id'=>'home-home-form',
	'htmlOptions'=>array("class"=>"","role"=>"form"),
	'enableAjaxValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>
	<div class="col-lg-12">
	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-danger')); ?>

    <div class="form-group">
        <div class="text-right">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>
        </div>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'editor_text',array('class'=>'control-label')); ?>
		<?php echo $this->widget('ext.widgets.xheditor.XHeditor',array(
			    'model'=>$model,
			    'modelAttribute'=>'editor_text',
			    'config'=>array(
			        'id'=>'xheditor_1',
			        'tools'=>'mfull', // mini, simple, mfull, full or from XHeditor::$_tools, tool names are case sensitive
			        'skin'=>'default', // default, nostyle, o2007blue, o2007silver, vista
			        'width'=>'100%',
			        'height'=>'300px',
			        'upImgUrl'=>$this->createUrl('request/uploadFile'), // NB! Access restricted by IP        'upImgExt'=>'jpg,jpeg,gif,png',
			    ),
			),true); ?>
		<?php echo $form->error($model,'editor_text',array('class'=>'help-block')); ?>
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