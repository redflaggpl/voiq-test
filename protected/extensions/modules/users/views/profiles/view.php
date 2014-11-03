<?php
/* @var $this ProfilesController */
/* @var $model UsersAuthitem */

$this->breadcrumbs=array(
	'Users Authitems'=>array('admin'),
	$model->name,
);

?>
<div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
    <div class="form-group">
        <div class="text-right">
		<?php echo CHtml::link(Yii::t('app','Back'),array('admin'),array('class'=>'btn btn-large btn-default'))?>        
	</div>
    </div>
    <table class="table">
    	<tr>
    		<td>
    			<strong>Name</strong> <br>
    			<?php echo $model->name?>
    		</td>
    		<td>
    			<strong>Description</strong> <br>
    			<?php echo $model->description?>
    		</td>
    		<td>
    			<strong>Type</strong> <br>
    			<?php echo UsersAuthitem::types($model->type);?>
    		</td>
    		<td>
    			<strong>Bizrule</strong> <br>
    			<?php echo ($model->bizrule);?>
    		</td>
    		<td>
    			<strong>Data</strong> <br>
    			<?php echo ($model->data);?>
    		</td>
    	</tr>
    </table>
    <div class="form-group">
        <div class="text-right">
		<?php echo CHtml::link(Yii::t('app','Back'),array('admin'),array('class'=>'btn btn-large btn-default'))?>        </div>
    </div>
		</div>
    </div>
</section>
</div>