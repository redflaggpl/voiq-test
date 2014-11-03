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
/* @var $data <?php echo $this->getModelClass(); ?> */
?>
<?php $order='';?>
<?php $classOver='';?>
<?php foreach($this->tableSchema->columns as $column):?>
<?php if($column->name=='orden_id'):?>
<?php $order="<?php echo \$index.\"-\".\$data->id?>";?>
<?php $classOver=' cursor-move';?>
<?php endif;?>
<?php endforeach;?>
<li class="list-group-item<?php echo $classOver?>" id="<?php echo $order;?>">
	<div class="row">	
    <div class="col-lg-7 pls">
<div class="col-lg-4 pln prn">
<?php foreach($this->tableSchema->columns as $column):?><?php 
$columnLat=explode('_', $column->name);
    if(isset($columnLat[0]) and isset($columnLat[2]) and $columnLat[0]=='map' and ($columnLat[2]=='lat' or $columnLat[2]=='lng'))
        continue;
?>
<?php if(strpos($column->name, 'img_')!==false):?>
      <?php echo "<?php echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/'.\$data->".$column->name.",'',array('class'=>'img-responsive img-thumbnail','style'=>'width:100%'));?>"; ?>
<?php break;?>
<?php endif;?>
<?php if(strpos($column->name, 'file_')!==false):?>
            <?php echo "<?php echo CHtml::link('<i style=\"font-size:10em\" class=\"fa fa-download\"></i>',Yii::app()->request->baseUrl.'/uploads/'.\$data->".$column->name.",array('class'=>'mhl mvl'));?>"; ?>
<?php break;?>
<?php endif;?>
<?php endforeach;?>
<?php foreach($this->tableSchema->columns as $column):?><?php if(strpos($column->dbType,'tinyint(1)')!==false or $column->type==='boolean'):?><?php echo "\n<?php if(\$data->{$column->name}):?>\n"; ?>
        <?php echo "<?php echo '<span class=\"label label-success\">".ucwords(strtr($column->name,$arratClean))." '.Yii::t('app','Enabled').'</span>';?>\n"; ?>
        <?php echo "<?php else:?>\n"; ?>
        <?php echo "<?php echo '<span class=\"label label-danger\">".ucwords(strtr($column->name,$arratClean))." '.Yii::t('app','Disabled').'</span>';?>\n"; ?>
        <?php echo "<?php endif;?>\n"; ?>
<?php break;?>
<?php endif;?><?php endforeach;?>
</div>
<div class="col-lg-8">
    
<?php
echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";
echo "\t<?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}), '#'); ?>\n\t<br />\n\n";
$count=0;
foreach($this->tableSchema->columns as $column)
{
    if($column->isPrimaryKey)
        continue;
    if($column->autoIncrement)
        continue;
    if($column->name=='orden_id')
        continue;
    if($column->name=='created_at')
        continue;
    if($column->name=='updated_at')
        continue;

    if(++$count==2)
        echo "\t<?php /*\n";
    echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";
    echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
}
if($count>=2)
    echo "\t*/ ?>\n";
?>
</div>
    
    </div>
    <div class="col-lg-5">
        <?php echo "<?php echo CHtml::link('<i class=\"fa fa-pencil\"></i>', array('{$this->getControllerID()}/update', 'id'=>\$data->id, '".$this->foraneKey."'=>\$data->".$this->foraneKey."),
                    array('class'=>'btn btn-primary mls pull-right','data-action'=>'crud-{$this->getControllerID()}','data-type'=>'update','data-name'=>\$data->id)); ?>";?>
  
        <?php echo "<?php echo CHtml::link('<i class=\"fa fa-eye\"></i>', array('{$this->getControllerID()}/view', 'id'=>\$data->id, '".$this->foraneKey."'=>\$data->".$this->foraneKey."),
                    array('class'=>'btn btn-default mls pull-right','data-action'=>'crud-{$this->getControllerID()}','data-type'=>'view','data-name'=>\$data->id)); ?>"?>

        <?php echo "<?php echo CHtml::link('<i class=\"fa fa-trash-o\"></i>', array('{$this->getControllerID()}/delete', 'id'=>\$data->id),
            		array('class'=>'btn btn-default pull-right','data-action'=>'crud-{$this->getControllerID()}', 'data-type'=>'delete','data-name'=>\$data->id)); ?>"?>
    </div>
    </div>

</li>