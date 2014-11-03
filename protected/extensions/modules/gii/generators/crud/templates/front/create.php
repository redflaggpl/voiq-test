<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$label=$this->pluralize($this->class2name($this->modelClass));
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */


?>

<h3>Create <?php echo $this->modelClass; ?></h3>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
