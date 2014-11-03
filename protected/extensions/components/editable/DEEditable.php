<?php
class DEEditable extends CApplicationComponent
{
	public function init()
	{
		$assets=Yii::app()->assetManager->publish(dirname(__FILE__)."/assets/");

		Yii::app()->clientScript->registerCoreScript("jquery");
		Yii::app()->clientScript->registerScriptFile($assets."/js/bootstrap-editable.min.js",CClientScript::POS_END);
		Yii::app()->clientScript->registerCssFile($assets."/css/bootstrap-editable.css");
		Yii::app()->clientScript->registerScript("de-editable","
			$('body').editable({
			    'selector': '.de-editable',
			    'emptytext':'Sin asignar',
			    'placement':'bottom',
			});
		");
	}

	public function map($key,$val)
	{
		return array("value"=>$key,"text"=>$val);
	}

	public function select($label, $source=array(), $htmlOptions=array())
	{
		$htmlOptions['data-type']='select';

		$dataSource=array_map(array($this,"map"),array_keys($source),$source);

		$htmlOptions['data-source']=CJSON::encode($dataSource);
		$htmlOptions['class']='de-editable';
		return CHtml::link($label,"#",$htmlOptions);
	}

	public function text($label, $htmlOptions=array())
	{
		$htmlOptions['data-type']='text';
		$htmlOptions['class']='de-editable';
		return CHtml::link($label,"#",$htmlOptions);
	}

	public function link($model, $input, $url, $htmlOptions=array(),$source=array())
	{
		$htmlOptions["data-name"]=$input;
		$htmlOptions["data-value"]=empty($model->{$input})?"":$model->{$input};
		// $htmlOptions["data-value"]=$model->{$input};
		$htmlOptions["data-url"]=$url;
		$htmlOptions["data-pk"]=$model->id;
		$htmlOptions["data-title"]=ucfirst($input);

		$htmlOptions['data-type']=isset($htmlOptions['data-type'])?$htmlOptions['data-type']:'text';
		if($htmlOptions['data-type']==="select")
		{
			$dataSource=array_map(array($this,"map"),array_keys($source),$source);

			$htmlOptions['data-source']=CJSON::encode($dataSource);
		}
		$htmlOptions['class']=empty($model->{$input})?'de-editable editable-empty':'de-editable';
		return CHtml::link(empty($model->{$input})?'Sin asignar':$model->{$input},"#",$htmlOptions);
	}

	public function action($className="")
	{
		if(empty($className))
			throw new CHttpException(500,"Class name es requerido");
			
		if(!Yii::app()->request->isAjaxRequest)
			throw new CHttpException(500,"Petición inválida");
		if(!Yii::app()->request->isPostRequest)
			throw new CHttpException(500,"Petición inválida");
		if(!isset($_POST['name']) and !isset($_POST['value']) and !isset($_POST['pk']))
			throw new CHttpException(500,"Petición inválida");
			
		$model=CActiveRecord::model($className)->findByPk($_POST['pk']);
		$model->{$_POST['name']}=$_POST['value'];
		
		if(!$model->save(true,array($_POST['name'])))
			throw new CHttpException(500,implode(",",$model->getErrors($_POST['name'])));
	}
}