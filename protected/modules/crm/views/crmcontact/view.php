<?php
/* @var $this CrmcontactController */
/* @var $model CrmContact */

$this->breadcrumbs=array(
	'contact'=>array('admin'),
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
    <div class="col-lg-3">
<div class="thumbnail">







    <div class="caption">
    <h4>
        contact <?php echo $model->id;?>    </h4>
    </div>
</div>

    </div>
    <div class="col-lg-9">
        <div class="panel panel-default">
          <!-- Default panel contents -->
          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('firstname')); ?>:</b></div>
          <div class="panel-body">
            <p><?php echo $model->firstname;?></p>
          </div>

          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('lastname')); ?>:</b></div>
          <div class="panel-body">
            <p><?php echo $model->lastname;?></p>
          </div>

          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:</b></div>
          <div class="panel-body">
            <p><?php echo $model->email;?></p>
          </div>

          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('sex')); ?>:</b></div>
          <div class="panel-body">
            <p><?php echo $model->sex;?></p>
          </div>

          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('id_number')); ?>:</b></div>
          <div class="panel-body">
            <p><?php echo $model->id_number;?></p>
          </div>

          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('CrmContactPhones')); ?>:</b></div>
          <div class="panel-body">
            <p><?php echo $model->phones;?></p>
          </div>

          <div class="panel-heading"><b><?php echo CHtml::encode($model->getAttributeLabel('created_at')); ?>:</b></div>
          <div class="panel-body">
              <?php echo Yii::app()->format->formatShort($model->created_at);?>
            <span class="text-muted">
              <?php echo Yii::app()->format->formatAgoComment($model->created_at);?>
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