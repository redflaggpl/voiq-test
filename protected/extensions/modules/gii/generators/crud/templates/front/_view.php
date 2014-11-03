<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$arratClean=Yii::app()->getModule('gii')->arrayClean;
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $data <?php echo $this->getModelClass(); ?> */
?>
<div class="col-lg-3">
	<div class="thumbnail">
<?php foreach($this->tableSchema->columns as $column):?><?php 
$columnLat=explode('_', $column->name);
    if(isset($columnLat[0]) and isset($columnLat[2]) and $columnLat[0]=='map' and ($columnLat[2]=='lat' or $columnLat[2]=='lng'))
        continue;
?>
<?php if(strpos($column->name, 'img_')!==false):?>
      <?php echo "<?php echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/'.\$data->".$column->name.",'',array('class'=>'img-responsive','style'=>'width:100%'));?>"; ?>
<?php break;?>
<?php endif;?>
<?php $columnLat=explode('_', $column->name);
    if(isset($columnLat[0]) and $columnLat[0]=='map'):?>
    <?php echo "<?php \$this->widget('ext.widgets.gmap.GShowLocation',array(
        'lat'=>\$data->{$column->name}_lat,
        'lng'=>\$data->{$column->name}_lng,
        'width'=>'100%',
        'height'=>'300',
        'zoom'=>'13',
    ));?>"; ?>
<?php break;?>
<?php endif;?><?php if(strpos($column->name, 'file_')!==false):?>
            <?php echo "<?php echo CHtml::link('<i style=\"font-size:10em\" class=\"fa fa-download\"></i>',Yii::app()->request->baseUrl.'/uploads/'.\$data->".$column->name.",array('class'=>'mhl mvl'));?>"; ?>
<?php break;?>
<?php endif;?>

<?php endforeach;?>
    <div class="caption">
    <h4>
        <?php echo ($nameColumn=='id')?$label." ":''; ?><?php echo "<?php echo \$data->{$nameColumn};?>"; ?>
<?php foreach($this->tableSchema->columns as $column):?><?php if(strpos($column->dbType,'tinyint(1)')!==false or $column->type==='boolean'):?><?php echo "\n<?php if(\$data->{$column->name}):?>\n"; ?>
        <?php echo "<?php echo '<span class=\"label label-success\">".ucwords(strtr($column->name,$arratClean))." '.Yii::t('app','Enabled').'</span>';?>\n"; ?>
        <?php echo "<?php else:?>\n"; ?>
        <?php echo "<?php echo '<span class=\"label label-danger\">".ucwords(strtr($column->name,$arratClean))." '.Yii::t('app','Disabled').'</span>';?>\n"; ?>
        <?php echo "<?php endif;?>\n"; ?>
<?php break;?>
<?php endif;?><?php endforeach;?>
    </h4>
<p><?php
echo "\t<?php echo CHtml::link('<i class=\"fa fa-eye\"></i>', array('view', 'id'=>\$data->{$this->tableSchema->primaryKey}),array('class'=>'btn btn-info btn-large')); ?>\n";
echo "\t<?php echo CHtml::link('<i class=\"fa fa-pencil-square\"></i>', array('update', 'id'=>\$data->{$this->tableSchema->primaryKey}),array('class'=>'btn btn-primary btn-large')); ?>";
?></p>
<?php foreach($this->tableSchema->columns as $column):?>
<?php if(stripos($column->dbType,'text')!==false):?>
    <p class="text-muted"><em><?php echo "<?php echo (substr(strip_tags(\$data->".$column->name."),0,50));?>"; ?></em></p>
<?php break;?>
<?php endif;?><?php endforeach;?>
    </div>
</div>

</div>