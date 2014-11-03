<?php 
class GExcel extends CWidget
{
	public $searchForm;
	public $url=array('excel');
	public $label='<i class="fa fa-list"></i> Excel';
	public $htmlOptions=array();
	
	public function init()
	{
		$id=$this->getId();
		$this->htmlOptions['id']=$id;
		echo CHtml::link($this->label,$this->url,$this->htmlOptions);
		Yii::app()->clientScript->registerScript("excel.GExcel#".$id,"
			$(document).on('click','#{$id}',function(e) {
				e.preventDefault();
				var href = $(this).attr('href');
				var url = $('{$this->searchForm}').serialize();
				window.location=href+'?'+url;
			});
		");
	}
}