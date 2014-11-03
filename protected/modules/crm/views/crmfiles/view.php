<?php
/* @var $this CrmfilesController */
/* @var $model CrmFiles */

$this->breadcrumbs=array(
	'files'=>array('admin'),
	$model->id,
);

?>
<div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
    <div class="form-group">
        <div class="text-right">
		<?php echo CHtml::link(Yii::t('app','Back'),array('admin'),array('class'=>'btn btn-large btn-default'))?>        </div>
    </div>

<div class="row">
    <div class="col-lg-7">
<div class="thumbnail">



    <div class="caption">
    <h4>
        files <?php echo $model->id;?>    </h4>
    </div>
</div>

    </div>
    <div class="col-lg-5">
        <div class="panel panel-default">
          <!-- Default panel contents -->
          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('file')); ?>:</b></div>
          <div class="panel-body">
            <p><?php echo $model->file;?></p>
          </div>

          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('date')); ?>:</b></div>
          <div class="panel-body">
              <?php echo Yii::app()->format->formatShort($model->date);?>
            <span class="text-muted">
              <?php echo Yii::app()->format->formatAgoComment($model->date);?>
            </span>
          </div>


        </div>
    </div>
</div>

    <div class="form-group">
        <div class="text-right">
        <?php echo CHtml::link(Yii::t('app','Back'),array('admin'),array('class'=>'btn btn-large btn-default'))?>        </div>
    </div>
        </div>
    </div>
</section>
</div>