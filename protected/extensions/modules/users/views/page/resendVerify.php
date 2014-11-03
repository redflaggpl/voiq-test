<div class="col-lg-12">
	<?php if($sended):?>
	<h4><?php echo $model->name?>!</h4>
	<p><?php echo Yii::t('app','We have forwarded your mail <strong>{email}</strong> a link to confirm, if it is not in your inbox please check your spam folder',array('{email}'=>$model->email))?></p>
	<?php else:?>
	<h4><?php echo Yii::t('app','Email not found')?></h4>
	<p><?php echo Yii::t('app','Your email <strong>{email}</strong> not found on owr database',array("{email}"=>isset($_GET['email'])?$_GET['email']:''));?></p>
	<?php endif;?>
</div>