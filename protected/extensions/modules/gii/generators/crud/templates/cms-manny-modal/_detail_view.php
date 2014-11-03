<div class="panel panel-default mtl">
    
    <?php foreach($this->tableSchema->columns as $column):
		echo "<div class=\"panel-heading\"><?php echo CHtml::encode(\$model->getAttributeLabel('{$column->name}')); ?></div>\n";
	?>
    <div class="panel-body">
        <p id="<?php echo $this->getModelClass(); ?>_<?php echo $column->name ?>_label"></p>
    </div>
	<?php endforeach;?>
</div>


<div class="modal-footer">
    <div class="col-lg-12">
        <button type="button" class="btn btn-default" data-dismiss="modal">
        	<?php echo "<?php echo Yii::t('app','Close')?>"?>
        </button>
    </div>
</div>
