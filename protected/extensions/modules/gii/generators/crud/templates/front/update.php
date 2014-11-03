<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

?>

<h3>Update <?php echo $this->modelClass." <?php echo \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h3>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>