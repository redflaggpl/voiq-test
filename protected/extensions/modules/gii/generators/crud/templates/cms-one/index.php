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

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('app','Update'),
);\n";
?>
?>

<div class="col-lg-12">
<?php echo "<?php foreach(Yii::app()->user->getFlashes() as \$type => \$message):?>\n"?>
  <div class="alert alert-<?php echo "<?php echo \$type?>"?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo "<?php echo \$message?>\n";?>
  </div>
<?php echo "<?php endforeach;?>\n"?>

<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap ">
<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'htmlOptions'=>array(\"class\"=>\"\",\"role\"=>\"form\"),
	'enableAjaxValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>\n"; ?>
	<div class="col-lg-12">
	<?php echo "<?php echo \$form->errorSummary(\$model,null,null,array('class'=>'alert alert-danger')); ?>\n"; ?>

    <div class="form-group">
        <div class="text-right">
		<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>\n"; ?>
        </div>
    </div>

<div class="row">
    <div class="col-lg-<?php echo $optionsLayouts[0][0]?>">
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
    <div class="col-lg-<?php echo $optionsLayouts[0][1]?>">
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
<?php if(count($this->tableSchema->columns)>2):?>
    <div class="form-group">
        <div class="pull-right">
		<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'btn btn-primary btn-large')); ?>\n"; ?>
        </div>
    </div>
<?php endif;?>
    </div>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
        </div>
    </div>
</section>

</div>