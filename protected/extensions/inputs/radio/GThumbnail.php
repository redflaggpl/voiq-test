<?php
/**
 * GInput class file.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * GInput displays a star rating control that can collect user rating input.
 *
 * GInput is based on {@link http://www.fyneworks.com/jquery/star-rating/ jQuery Star Rating Plugin}.
 * It displays a list of stars indicating the rating values. Users can toggle these stars
 * to indicate their rating input. On the server side, when the rating input is submitted,
 * the value can be retrieved in the same way as working with a normal HTML input.
 * For example, using
 * <pre>
 * $this->widget('pat.to.location.GInput',array('name'=>'rating'));
 * </pre>
 * we can retrieve the rating value via <code>$_POST['rating']</code>.
 *
 * GInput allows customization of its appearance. It also supports empty rating as well as read-only rating.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @package system.web.widgets
 * @since 1.0
 */
class GThumbnail extends CInputWidget
{
	public $listData=array(
	  	'default'=>'<span class="label label-default">Default</span>',
		'primary'=>'<span class="label label-primary">Primary</span>',
		'success'=>'<span class="label label-success">Success</span>',
		'info'=>'<span class="label label-info">Info</span>',
		'warning'=>'<span class="label label-warning">Warning</span>',
		'danger'=>'<span class="label label-danger">Danger</span>'
	);

	public $columnClass='col-lg-4';

	private $_assets;
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the text field.
	 */
	public function run()
	{
		
		list($name,$id)=$this->resolveNameID();
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		#$this->registerClientScript($id);
		#$this->htmlOptions["class"]="form-control";
		$this->htmlOptions=array_merge($this->htmlOptions,array(
			// 'htmlOptions'=>array('container'=>null),
			'labelOptions'=>array('style'=>'width: 100%;height: 100%;cursor:pointer','class'=>'ptm pbm mbn'),
			'template'=>'<div class="'.$this->columnClass.'"><a href="#" class="thumbnail text-center" style="margin-left: -10px;margin-right: -10px;">{beginLabel}{labelTitle}<div class="text-center">{input}</div>{endLabel}</a></div>',
			'separator'=>'',
		));
		
		#echo "<small class=\"text-muted\"><em>Here a message for user</em></small>";
		#echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		echo '<div class="row">'.Chtml::activeRadioButtonList($this->model,$this->attribute,
		  $this->listData,$this->htmlOptions).'</div>';
		
	}

	/**
	 * Registers the necessary javascript and css scripts.
	 * @param string $id the ID of the container
	 */
	public function registerClientScript($id)
	{
		$js="
			$(function() {
		    	console.log('Hello world');
			});
		";
		$assets=$this->getAssets();
		$cs=Yii::app()->getClientScript();
		// $cs->registerScriptFile("https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing",CClientScript::POS_HEAD);
		// $cs->registerScriptFile($assets."/googleMap.js",CClientScript::POS_HEAD);
		$cs->registerScript('ext.GInput#'.$id,$js,CClientScript::POS_END);
	}

	public function getAssets()
	{
		if($this->_assets===null)
			$this->_assets=Yii::app()->assetManager->publish(dirname(__FILE__)."/assets/");
		return $this->_assets;
	}
}
