<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Login'=>array('/site/login'),
	'Confirmar correo',
);

?>

<div class="col-lg-12">
	<h4><?php echo $model->name?>!</h4>
	<p>
		 Hemos reenviado a tu correo <strong><?php echo $model->email?></strong> un enlace para confirmarlo, si no está en la bandeja de entrada por favor revisa tu bandeja de spam
	</p>
</div>