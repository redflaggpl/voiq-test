<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$arratClean=Yii::app()->getModule('gii')->arrayClean;
$optionsLayouts=array(
        array('4','8'),
        array('8','4'),
        array('3','9'),
        array('9','3'),
        array('6','6'),
        array('7','5'),
        array('5','7'),
    );
shuffle($optionsLayouts);
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<?php 
$orden='';
?>
<?php foreach($this->tableSchema->columns as $column):?>
<?php if($column->name=='orden_id'):?>
<?php $orden="
complete: function () {
\$(\\\"#".$this->class2id($this->modelClass)."-list ul\\\").sortable({
	update: function() {
		var that = \$(this);
		\$(\\\".loading\\\").html('<i class=\\\"fa fa-refresh fa-spin\\\"></i>');
		setTimeout(function () {
        	var order = that.sortable(\\\"toArray\\\");
	        \$.post('\".\$this->createUrl('".$this->getControllerID()."/order').\"', {order: order}, function(datos){
    			$('.loading').empty();
	        });
		},500);
    }
});
},
";?>
<?php endif;?>
<?php endforeach;?>
<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'htmlOptions'=>array('class'=>'','role'=>'form'),
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnChange'=>false,
		'validateOnSubmit'=>true,		
		'beforeValidate'=>\"js:function(form){
	    	var newSessing = form.data('settings');
            newSessing.validationUrl = $(form).attr('action');
            form.data('settings', newSessing);
            return true;
		}\",
		'afterValidate'=>\"js:function(form,data,hasError){ 
			if(!hasError) {
				form.each (function(){
				  this.reset();
				});
				$.fn.yiiListView.update('".$this->class2id($this->modelClass)."-list', {
					// data: { '\".get_class(\$model).\"':  }
					{$orden}
				});
				$('#".$this->class2id($this->modelClass)."-modal').modal('hide');
				return false;
			}
			return false;
		}\",
	),
)); ?>\n"; ?>

<div class="row">
	<div class="pln col-lg-<?php echo $optionsLayouts[0][0]?>">
<?php $shoyables=0;?>
<?php foreach($this->tableSchema->columns as $column):
if($column->autoIncrement)
		continue;
	if($column->name=='orden_id')
		continue;
	if($column->name=='created_at')
		continue;
	if($column->name=='updated_at')
		continue;

	$columnLat=explode('_', $column->name);
	if(isset($columnLat[0]) and isset($columnLat[2]) and $columnLat[0]=='map' and ($columnLat[2]=='lat' or $columnLat[2]=='lng'))
		continue;
	
?>
<?php $shoyables++;?>
<?php endforeach;?>

<?php $first=ceil($shoyables/2)?>
<?php $rest=$shoyables-$first?>
<?php $i=1;?>
<?php foreach($this->tableSchema->columns as $column) {

	if($column->autoIncrement)
		continue;
	if($column->name=='orden_id')
		continue;
	if($column->name=='created_at')
		continue;
	if($column->name=='updated_at')
		continue;

	$columnLat=explode('_', $column->name);
	if(isset($columnLat[0]) and isset($columnLat[2]) and $columnLat[0]=='map' and ($columnLat[2]=='lat' or $columnLat[2]=='lng'))
		continue;
	if($i<=$first)
	{
?>
<div class="form-group">
	<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
	<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
	<?php echo "<?php echo \$form->error(\$model,'{$column->name}',array('class'=>'help-block')); ?>\n"; ?>
</div>
<?php 
	}
	$i++;
} ?>
	</div>
	<div class="pln prn col-lg-<?php echo $optionsLayouts[0][1]?>">
<?php $i=1;?>
<?php foreach($this->tableSchema->columns as $column) {
	if($column->autoIncrement)
		continue;
	if($column->name=='orden_id')
		continue;
	if($column->name=='created_at')
		continue;
	if($column->name=='updated_at')
		continue;

	$columnLat=explode('_', $column->name);
	if(isset($columnLat[0]) and isset($columnLat[2]) and $columnLat[0]=='map' and ($columnLat[2]=='lat' or $columnLat[2]=='lng'))
		continue;
	if($i>$first)
	{
?>
<div class="form-group">
	<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
	<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
	<?php echo "<?php echo \$form->error(\$model,'{$column->name}',array('class'=>'help-block')); ?>\n"; ?>
</div>
<?php 
	}
	$i++;
} ?>
	</div>
</div>

<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal"><?php echo "<?php echo Yii::t('app','Cancel')?>"?></button>
	<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'".$this->class2id($this->modelClass)."-submit btn btn-primary btn-large')); ?>\n"; ?>
</div>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
