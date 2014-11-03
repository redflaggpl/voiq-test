<?php 
class GExcelAction extends CAction 
{
	public $modelName;
	public $modelView;
	public $scenario='search';
	public function run()
	{
		if($this->modelName===null)
			throw new CException("El modelo y la vista para el excel son requeridos.");
		
			$m=$this->modelName;
			$modelSearch= new $m($this->scenario);
			$modelSearch->unsetAttributes();  // clear any default values
			if(isset($_GET[$this->modelName]))
				$modelSearch->attributes=$_GET[$this->modelName];
			if($this->modelView===null)
			{
				$content="<table border=1>";
					$content.="<tr>";
					foreach ($modelSearch->attributeNames() as $keyCol => $column)
						$content.="<th style=\"background-color:#555;color:#FFF;\">".$modelSearch->getAttributeLabel($column)."</th>";
					$content.="</tr>";
				foreach ($modelSearch->findAll($modelSearch->search()->getCriteria()) as $key => $data)
				{
					$background=$key%2==0?" style=\"background-color:#F0F0F0;\"":"";
					$content.="<tr>";
					foreach ($modelSearch->attributeNames() as $keyCol => $column)
						$content.="<td".$background.">".$data->{$column}."</td>";
					$content.="</tr>";
				}
				$content.="</table>";
			}
			else
				$content=$this->controller->renderPartial($this->modelView,array('model'=>$modelSearch),true);
			#Yii::app()->log->enable=false;
			Yii::app()->request->sendFile(get_class($modelSearch).".xls",$content);
	}
}