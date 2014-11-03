<div class="">
<div class=" template">
	<?php echo $this->labelEx($model,'template'); ?>
	<?php echo $this->dropDownList($model,'template',$templates ,array('class'=>'form-control')); ?>
	<?php echo $this->error($model,'template'); ?>
</div>
</div>

<div class="">
<div class="buttons text-right">
	<?php echo CHtml::submitButton('Preview',array('name'=>'preview','class'=>'btn btn-primary mtl mbl mrs')); ?>

	<?php if($model->status===CCodeModel::STATUS_PREVIEW && !$model->hasErrors() and !(isset($justPreview) and $justPreview===true)): ?>
		<?php echo CHtml::submitButton('Generate',array('name'=>'generate','class'=>'btn btn-primary mtl mbl mrs')); ?>
	<?php endif; ?>
</div>
</div>

</div>
<div class="col-lg-8">

<?php if(isset($justPreview) and $justPreview===true):?>
	<div class="row">
		<div class="col-lg-12">
			<?php $model->contentPreview="".$model->render($model->templatePath.'/input.php');
			$this->widget('yiiwheels.widgets.ace.WhAceEditor', array(
				    'theme'=>'monokai',
				    'mode'=>'php',
				    'model'=>$model,
				    'attribute'=>'contentPreview',
				    'htmlOptions'=> array('style' => 'width:100%;height:600px')
				));?>
		</div>
	</div>
<?php endif;?>

<!-- <hr> -->
<?php if(!$model->hasErrors() and !(isset($justPreview) and $justPreview===true)): ?>
<div class="col-lg-12">
	<div class="feedback">
	<?php if($model->status===CCodeModel::STATUS_SUCCESS): ?>
		<div class="alert-success">
			<?php echo $model->successMessage(); ?>
		</div>
	<?php elseif($model->status===CCodeModel::STATUS_ERROR): ?>
		<div class="alert-error">
			<?php echo $model->errorMessage(); ?>
		</div>
	<?php endif; ?>

	<?php if(isset($_POST['generate'])): ?>
		<pre class="results"><?php echo $model->renderResults(); ?></pre>
	<?php elseif(isset($_POST['preview'])): ?>
		<?php echo CHtml::hiddenField("answers"); ?>
		<table class="table table-bordered mtl preview">
			<tr>
				<th class="file">Code File</th>
				<th class="confirm">
					<label for="check-all">Generate</label>
					<?php
						$count=0;
						foreach($model->files as $file)
						{
							if($file->operation!==CCodeFile::OP_SKIP)
								$count++;
						}
						if($count>1)
							echo '<input type="checkbox" name="checkAll" id="check-all" />';
					?>
				</th>
			</tr>
			<?php foreach($model->files as $i=>$file): ?>
			<tr class="<?php echo $file->operation; ?>">
				<td class="file">
					<?php echo CHtml::link(CHtml::encode($file->relativePath), array('code','id'=>$i), array('class'=>'view-code','rel'=>$file->path)); ?>
					<?php if($file->operation===CCodeFile::OP_OVERWRITE): ?>
						(<?php echo CHtml::link('diff', array('diff','id'=>$i), array('class'=>'view-code','rel'=>$file->path)); ?>)
					<?php endif; ?>
				</td>
				<td class="confirm">
					<?php
					if($file->operation===CCodeFile::OP_SKIP)
						echo 'unchanged';
					else
					{
						$key=md5($file->path);
						echo CHtml::label($file->operation, "answers_{$key}")
							. ' ' . CHtml::checkBox("answers[$key]", $model->confirmed($file));
					}
					?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
</div>
<?php endif; ?>
