<div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">

<?php $form=$this->beginWidget('CCodeForm', array('model'=>$model)); ?>
<div class="row">
	<div class="col-lg-4">
	
	
	<div class="form-group">
        <?php echo $form->labelEx($model,'moduleID'); ?>
		<?php echo $form->textField($model,'moduleID',array('size'=>65 ,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'moduleID'); ?>
	</div>

<?php $this->endWidget(); ?>

        </div>
    </div>
</section>
</div>