<?php
/* @var $this AppsController */
/* @var $model Apps */

$this->breadcrumbs=array(
	'Apps'=>array('admin'),
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
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'table table-striped'),
    'itemTemplate'=>"<tr class=\"{class}\"><td><strong>{label}</strong><br><small>{value}</small></td></tr>\n",
    'attributes'=>array(
		'id',
		'name',
		'client_id',
		array(
			'name'=>'client_secret',
			'type'=>'html',
			'value'=>'<code>'.$model->client_secret.'</code>',
		),
		'redirect_uri',
		array(
			'label'=>'scopes',
			'type'=>'html',
			'value'=>implode(',<br>',CHtml::listData( $model->scopesapp, 'name' , 'name')),
		),
	),
)); ?>

<h4>Create an Access Token via Client Credentials</h4>
Your User Id: <strong><?php echo $model->id?></strong><br> 

<a href="<?php echo $this->createAbsoluteUrl('page/token',array(
	'client_id'=>$model->client_id,
	'client_secret'=>$model->client_secret,
	'grant_type'=>'client_credentials',
	'web_generate'=>'web_generate',
))?>" class="btn btn-primary">Generate a Token!</a>



    <h3> Call APIs on Behalf of Another User</h3>
    <p>
       Below is the url <code>authorize</code>:
    </p>
   
    <pre class="alert-info"><code><a target="_blank" href="<?php echo $this->createAbsoluteUrl('page/authorize',array(
		'client_id'=>$model->client_id,
		'response_type'=>'code',
	))?>"><?php echo $this->createAbsoluteUrl('page/authorize',array(
		'client_id'=>$model->client_id,
		'response_type'=>'code',
	))?></a></code></pre>


    <div class="form-group">
        <div class="text-right">
		<?php echo CHtml::link(Yii::t('app','Back'),array('admin'),array('class'=>'btn btn-large btn-default'))?>        </div>
    </div>
		</div>
    </div>
</section>
</div>