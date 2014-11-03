<?php

class ModuleCode extends CCodeModel
{

	public $title='Module Generator';
	public $subTitle='Module Generator code';

	public $moduleID;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('moduleID', 'filter', 'filter'=>'trim'),
			array('moduleID', 'required'),
			array('moduleID', 'match', 'pattern'=>'/^\w+$/', 'message'=>'{attribute} should only contain word characters.'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'moduleID'=>'Module ID',
		));
	}

	public function successMessage()
	{
		if(Yii::app()->hasModule($this->moduleID))
			return 'The module has been generated successfully. You may '.CHtml::link('try it now', Yii::app()->createUrl($this->moduleID), array('target'=>'_blank')).'.';
$moduleID=ucfirst($this->moduleID);
		$output=<<<EOD
<p>The module has been generated successfully.</p>
<p>Paste this on protected/config/modules.php:</p>
EOD;

$author="/**
	 * {$moduleID}Module is a module for implement 
	 * a list of controllers, apis and models availables
	 * for to manage {$this->moduleID}s resources
	 *
	 * With the above configuration, you will be able to access 
	 * {$this->moduleID} module on your browser using
	 * the following URL:
	 * ".Yii::app()->createAbsoluteUrl($this->moduleID)."
	 *
	 * If you want make your module more reusable you can set all 
	 * {$moduleID}Module public parameters class
	 * of the below way
	 * <pre>
	 *		'{$this->moduleID}'=>array(
	 *			'class'=>'application.modules.{$this->moduleID}.{$moduleID}Module',
	 *			'myParamerer1' => 10000,
	 *			'myOtherParameter' => false,
	 *		),
	 * </pre>
	 *
	 * @author ".Yii::app()->user->name." <".Yii::app()->user->email.">
	 * @package modules.{$this->moduleID}
	 * @version 1.0
	 */";
		$code=<<<EOD
<?php
	...
	'{$this->moduleID}'=>array(
		'class'=>'application.modules.{$this->moduleID}.{$moduleID}Module',
		// 'showMenuFromAdmin'=>false, // If you want hide your module on CMS left menu
 	),
	...
EOD;

		return $output.highlight_string($code,true);
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		$modulePath=$this->modulePath;
		$moduleTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'module.php';

		$this->files[]=new CCodeFile(
			$modulePath.'/'.$this->moduleClass.'.php',
			$this->render($moduleTemplateFile)
		);

		$files=CFileHelper::findFiles($templatePath,array(
			'exclude'=>array(
				'.DS_Store',
				'.svn',
				'.gitignore'
			),
		));

		foreach($files as $file)
		{
			if($file!==$moduleTemplateFile)
			{
				if(CFileHelper::getExtension($file)==='php')
					$content=$this->render($file);
				elseif(basename($file)==='.yii')  // an empty directory
				{
					$file=dirname($file);
					$content=null;
				}
				else
					$content=file_get_contents($file);
				$this->files[]=new CCodeFile(
					$modulePath.substr($file,strlen($templatePath)),
					$content
				);
			}
		}
	}

	public function getModuleClass()
	{
		return ucfirst($this->moduleID).'Module';
	}

	public function getModulePath()
	{
		return Yii::app()->modulePath.DIRECTORY_SEPARATOR.$this->moduleID;
	}
}