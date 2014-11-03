<?php if(Yii::app()->user->checkAccess("root")):?>
<div class="row">
	<div class="col-lg-12">
		<h4>Nuevo rol</h4>
		<?php $form=$this->beginWidget("CActiveForm",array(
			'id'=>"role-form",
			'enableAjaxValidation'=>true,
    		'clientOptions'=>array('validateOnSubmit'=>true),
    	));?>

		<?php echo $form->labelEx($role,"name");?>
		<?php echo $form->textField($role,"name",array("class"=>"form-control"));?>
		<?php echo $form->error($role,"name");?>

		<?php echo $form->labelEx($role,"description");?>
		<?php echo $form->textArea($role,"description",array("class"=>"form-control"));?>
		<?php echo $form->error($role,"description");?>

		<br>
		<?php echo CHtml::submitButton("Create",array("class"=>"btn btn-primary"));?>
		<?php $this->endWidget();?>
	</div>
</div>
<?php endif;?>
<div class="row">
	<div class="col-lg-12">
		<br>
		<table class="table">
		<?php foreach(Yii::app()->authManager->getAuthItems() as $data):?>
		<?php if($data->name==="root") continue;;?>
		<?php $enabled=Yii::app()->authManager->checkAccess($data->name,$model->id)?>
			<tr><td>
				<h4 style="margin: 0;"><?php echo $data->name?>
					<?php if(Yii::app()->user->checkAccess("admin") or Yii::app()->user->checkAccess("root")):?>
						<?php echo CHtml::link($enabled?"Quitar":"Asignar",array("users/assign","id"=>$model->id,"item"=>$data->name),
							array("class"=>$enabled?"assign btn default pull-right btn-primary":"assign btn btn-info pull-right"));?>
						<?php endif;?>
				</h4>
				<em style="font-size: 13px;line-height: 15px;"><?php echo $data->description?></em>
			</tr></td>
		<?php endforeach;?>
		</table>
	</div>
</div>
</div>