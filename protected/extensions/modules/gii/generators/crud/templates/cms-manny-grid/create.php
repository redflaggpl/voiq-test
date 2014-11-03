<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$label=$this->labelName;
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	Yii::t('app','Create'),
);\n ?>";

?>
<div class="col-lg-12">
	<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
</div>
