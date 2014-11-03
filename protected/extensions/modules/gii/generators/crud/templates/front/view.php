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
        array('12','12'),
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
	'$label'=>array('admin'),
	\$model->{$nameColumn},
);\n";
?>

?>
<div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
    <div class="form-group">
        <div class="text-right">
		<a class="btn btn-default mtl" href="<?php echo "<?php echo \$this->createUrl('index')?>"?>">View all</a>
        </div>
    </div>

<div class="row">
    <div class="col-lg-<?php echo $optionsLayouts[0][0]?>">
<div class="thumbnail">
<?php foreach($this->tableSchema->columns as $column):?><?php 
$columnLat=explode('_', $column->name);
    if(isset($columnLat[0]) and isset($columnLat[2]) and $columnLat[0]=='map' and ($columnLat[2]=='lat' or $columnLat[2]=='lng'))
        continue;
?>
<?php if(strpos($column->name, 'img_')!==false):?>
      <?php echo "<?php echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/'.\$model->".$column->name.",'',array('class'=>'img-responsive','style'=>'width:100%'));?>"; ?>
<?php break;?>
<?php endif;?>
<?php $columnLat=explode('_', $column->name);
    if(isset($columnLat[0]) and $columnLat[0]=='map'):?>
    <?php echo "<?php \$this->widget('ext.widgets.gmap.GShowLocation',array(
        'lat'=>\$model->{$column->name}_lat,
        'lng'=>\$model->{$column->name}_lng,
        'width'=>'100%',
        'height'=>'300',
        'zoom'=>'13',
    ));?>"; ?>
<?php break;?>
<?php endif;?><?php if(strpos($column->name, 'file_')!==false):?>
            <?php echo "<?php echo CHtml::link('<i style=\"font-size:10em\" class=\"fa fa-download\"></i>',Yii::app()->request->baseUrl.'/uploads/'.\$model->".$column->name.",array('class'=>'mhl mvl'));?>"; ?>
<?php break;?>
<?php endif;?>

<?php endforeach;?>
    <div class="caption">
    <h4>
        <?php echo ($nameColumn=='id')?$label." ":''; ?><?php echo "<?php echo \$model->{$nameColumn};?>"; ?>
<?php foreach($this->tableSchema->columns as $column):?><?php if(strpos($column->dbType,'tinyint(1)')!==false or $column->type==='boolean'):?><?php echo "\n<?php if(\$model->{$column->name}):?>\n"; ?>
        <?php echo "<?php echo '<span class=\"label label-success\">".ucwords(strtr($column->name,$arratClean))." '.Yii::t('app','Enabled').'</span>';?>\n"; ?>
        <?php echo "<?php else:?>\n"; ?>
        <?php echo "<?php echo '<span class=\"label label-danger\">".ucwords(strtr($column->name,$arratClean))." '.Yii::t('app','Disabled').'</span>';?>\n"; ?>
        <?php echo "<?php endif;?>\n"; ?>
<?php break;?>
<?php endif;?><?php endforeach;?>
    </h4>
<?php foreach($this->tableSchema->columns as $column):?>
<?php if(stripos($column->dbType,'text')!==false):?>
    <p><?php echo "<?php echo Yii::app()->format->toBr(\$model->".$column->name.");?>"; ?></p>
<?php break;?>
<?php endif;?><?php endforeach;?>
    </div>
</div>

    </div>
    <div class="col-lg-<?php echo $optionsLayouts[0][1]?>">
        <div class="panel panel-default">
          <!-- Default panel contents -->
<?php foreach($this->tableSchema->columns as $column):?>
<?php 
    $columnLat=explode('_', $column->name);

    if($column->name=='orden_id')
        continue;

    if($column->name=='id')
        continue;

    if(isset($columnLat[0]) and isset($columnLat[2]) and $columnLat[0]=='map' and ($columnLat[2]=='lat' or $columnLat[2]=='lng'))
        continue;

?>
<?php if(strpos($column->name, 'img_')!==false):?>
          <div class="panel-heading"><?php echo ucwords(strtr($column->name,$arratClean)); ?></div>
          <div class="panel-body text-center">
            <?php echo "<?php echo CHtml::image(Yii::app()->request->baseUrl.'/uploads/'.\$model->".$column->name.",'',array('class'=>'img-responsive img-thumbnail'));?>\n"; ?>
          </div>
<?php elseif(stripos($column->dbType,'text')!==false):?>
          <div class="panel-heading"><?php echo ucwords(strtr($column->name,$arratClean)); ?></div>
          <div class="panel-body">
            <?php echo "<?php echo Yii::app()->format->toBr(\$model->".$column->name.");?>\n"; ?>
          </div>
<?php 
    elseif(isset($columnLat[0]) and $columnLat[0]=='map'):
?>
          <div class="panel-heading"><?php echo ucwords(strtr($column->name,$arratClean)); ?></div>
          <div class="panel-body ptn pln prn pbn">
            <?php echo "<?php \$this->widget('ext.widgets.gmap.GShowLocation',array(
            'lat'=>\$model->{$column->name}_lat,
            'lng'=>\$model->{$column->name}_lng,
            'width'=>'100%',
            'height'=>'300',
            'zoom'=>'13',
        ));?>\n"; ?>
          </div>
<?php elseif(strpos($column->name, 'file_')!==false):?>
          <div class="panel-heading"><?php echo ucwords(strtr($column->name,$arratClean)); ?></div>
          <div class="panel-body">
            <?php echo "<?php echo CHtml::link('<i class=\"fa fa-download\"></i>',Yii::app()->request->baseUrl.'/uploads/'.\$model->".$column->name.",array('font-size:100%'));?>\n"; ?>
          </div>
<?php elseif(strpos($column->dbType,'tinyint(1)')!==false or $column->type==='boolean'):?>
          <div class="panel-heading"><?php echo ucwords(strtr($column->name,$arratClean)); ?></div>
          <div class="panel-body">
            <?php echo "<?php if(\$model->{$column->name}):?>\n"; ?>
            <?php echo "<?php echo '<span class=\"label label-success\">".ucwords(strtr($column->name,$arratClean))." '.Yii::t('app','Enabled').'</span>';?>\n"; ?>
            <?php echo "<?php else:?>\n"; ?>
            <?php echo "<?php echo '<span class=\"label label-danger\">".ucwords(strtr($column->name,$arratClean))." '.Yii::t('app','Disabled').'</span>';?>\n"; ?>
            <?php echo "<?php endif;?>\n"; ?>
          </div>
<?php elseif(strpos($column->dbType,'date')!==false):?>
          <div class="panel-heading"><?php echo ucwords(strtr($column->name,$arratClean)); ?></div>
          <div class="panel-body">
              <?php echo "<?php echo Yii::app()->format->formatShort(\$model->".$column->name.");?>\n"; ?>
            <span class="text-muted">
              <?php echo "<?php echo Yii::app()->format->formatAgoComment(\$model->".$column->name.");?>\n"; ?>
            </span>
          </div>
<?php else:?>
          <div class="panel-heading"><?php echo ucwords(strtr($column->name,$arratClean)); ?></div>
          <div class="panel-body">
            <p><?php echo "<?php echo \$model->{$column->name};?>"; ?></p>
          </div>
<?php endif;?>

<?php endforeach;?>

        </div>
    </div>
</div>

<?php if(count($this->tableSchema->columns)>2):?>
    <div class="form-group">
        <div class="text-right">
        <a class="btn btn-default mtl" href="<?php echo "<?php echo \$this->createUrl('index')?>"?>">View all</a>
        </div>
    </div>
<?php endif;?>
        </div>
    </div>
</section>
</div>
