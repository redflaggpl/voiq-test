<section class="panel">
    <div class="panel-body">
    	<a href="<?php echo $this->createUrl('create') ?>" class="btn btn-compose">
        	<i class="fa fa-list"></i> <?php echo Yii::t('app','Create Users')?>
        </a>
        <?php $this->widget('zii.widgets.CMenu', array(
			'items'=>array(
				array('label'=>Yii::t('app','Update Users'), 'url'=>array('update', 'id'=>@$model->id),'visible'=>(isset($model) and !$model->isNewRecord)),
				array('label'=>Yii::t('app','Delete Users'), 'url'=>'#', 'visible'=>(isset($model) and !$model->isNewRecord), 'linkOptions'=>array('submit'=>array('delete','id'=>@$model->id),'confirm'=>Yii::t('app','Are you sure you want to delete this item?'))),
				array('label'=>Yii::t('app','List Users'), 'url'=>array('index')),
				array('label'=>Yii::t('app','Manage Users'), 'url'=>array('admin')),
			),
			'htmlOptions'=>array('class'=>'nav nav-pills nav-stacked mail-nav'),
		)); ?>
    </div>
</section>
