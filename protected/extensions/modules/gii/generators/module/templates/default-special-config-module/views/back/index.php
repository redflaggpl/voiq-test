<?php echo "<?php\n"; ?>
/* @var $this BackController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<div class="col-lg-12">
<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">


<h4>Esta es la vista del back <?php echo "<?php"; ?> echo $this->uniqueId . '/' . $this->action->id; ?></h4>
<?php echo "<?php"; ?> echo CHtml::link('EL BACK Controller de este módulo es',array('/'.$this->module->id.'/back'),array('class'=>'btn btn-default')); ?>
<p>
Para personalizar este actualiza <tt><?php echo "<?php"; ?> echo __FILE__; ?></tt>
</p>

	</div>
    </div>
</section>
</div>