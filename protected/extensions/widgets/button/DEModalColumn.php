<?php
class DEModalColumn extends CLinkColumn
{

	public $label='Ver más';
	public $urlExpression='Yii::app()->controller->createUrl("view",array("id"=>$data->primaryKey))';
	// public $url='#basic';
	// public $viewButtonUrl='Yii::app()->controller->createUrl("view",array("id"=>$data->primaryKey))';
	public $linkHtmlOptions=array(
		'class'=>'de-modal btn default',
		// 'data-toggle'=>'modal',
		'data-target'=>'#basic',
	);

	public function init()
	{
		Yii::app()->clientScript->registerScript("modalAdmin","
		    $('body').on('click', '.de-modal', function (e) {
		   		e.preventDefault();
		   		$.ajax({
		   			url:  $(this).attr('href'),
		   			success: function (data) {
		   				$('#basic').html(data);
		   				$('#basic').modal('show');
		   			}
		   		});
		   		
		        console.log('Showing modal...');
		    });
		");
		parent::init();
	}

}