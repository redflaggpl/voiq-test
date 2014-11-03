<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$label=$this->pluralize($this->class2name($this->modelClass));
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

?>

<h3><?php echo $label; ?></h3>

<!-- SEARCH FORM -->
<div class="row mbl mtl">
	<div class="col-lg-2">&nbsp;</div>
	<div class="col-lg-8">
		<div class="input-group">
	      <input data-action="search" type="text" class="form-control">
	      <span class="input-group-btn">
	        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
	      </span>
	    </div>
	</div>
	<div class="col-lg-2">&nbsp;</div>
</div>
<a class="btn btn-default" href="<?php echo "<?php echo \$this->createUrl('create')?>"?>">Create</a>

<!-- LIST OF ELEMENTS -->
<div class="row">
	<div class="col-lg-12">
<?php echo "<?php"; ?> $this->widget('zii.widgets.CListView', array(
    'id'=>'<?php echo $this->class2id($this->modelClass); ?>-list',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'itemsTagName'=>'div',
    'cssFile'=>false,
    'itemsCssClass'=>'row',
    'summaryCssClass'=>'summary text-center mbl',
)); ?>
	</div>
</div>

<script>
$(function () {
	
	/**
	 * Search functionality 
	 * in each keayup event call
	*/
	$(document).on('keyup','[data-action=search]',function (e) {
        var search = $(e.currentTarget).val();
    	console.log(search);
    	$.fn.yiiListView.update('<?php echo $this->class2id($this->modelClass); ?>-list',{
        	data:{search: search}
        });
    });
});
</script>