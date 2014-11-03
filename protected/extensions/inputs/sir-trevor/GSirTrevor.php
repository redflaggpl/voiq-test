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
class GSirTrevor extends CInputWidget
{
	
	// public $primaryColor="#34e0c2"; // thi is a default original ligrary color
	public $primaryColor="#428bca";
	
	/*
	 * Set an overall total number of blocks that can be displayed.
	 * Defaults to 0 (infinite).
	*/
	public $blockLimit=0;

	/*
	 *	{
	 *	    "Text": 2,
	 *	    "Image": 1
	 *	}
	*/
	public $blockTypeLimits=array();
	
	/*
	 * Specify which block types are required for validatation.
	 * Defaults to none.
	*/	
	public $required=array('Text');

	/*
	 * Call a function once the Editor has rendered.
	 * Defaults to undefined.
	*/
	public $onEditorRender='js:function(){}';
	
	public $uploadUrl='/upload';
	public $baseImageUrl;
	
	public $blockTypes=array(
		"Heading",
		"Text",
		"List",
		"Quote",
		"Image",
		"Video",
		"Tweet");


	private $_assets;
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the text field.
	 */
	public function run()
	{
		$widgetID=$this->getId();
		
		list($name,$id)=$this->resolveNameID();
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		$this->registerClientScript($id);
		// $this->htmlOptions["class"]="form-control";
		if(isset($this->htmlOptions["class"]))
			$this->htmlOptions["class"].=" sir-trevor-{$widgetID}";
		else
			$this->htmlOptions["class"]="sir-trevor-{$widgetID}";

		#echo "<small class=\"text-muted\"><em>Here a message for user</em></small>";
		echo CHtml::activeTextArea($this->model,$this->attribute,$this->htmlOptions);
		
	}

	/**
	 * Registers the necessary javascript and css scripts.
	 * @param string $id the ID of the container
	 */
	public function registerClientScript($id)
	{
		$this->baseImageUrl=Yii::app()->request->baseUrl."/uploads/";
		$typeLimits="";
		if($this->blockTypeLimits===array())
			$typeLimits="{}";
		else
			$typeLimits=CJavaScript::encode($this->blockTypeLimits);

		$widgetID=$this->getId();
		$js="
		    $(function(){
		      
		      window.editor{$widgetID} = new SirTrevor.Editor({
		        el: $('.sir-trevor-{$widgetID}'),
		        blockLimit: {$this->blockLimit},
		        blockTypeLimits: ".$typeLimits.",
		        required: ".CJavaScript::encode($this->required).",
		        onEditorRender: ".CJavaScript::encode($this->onEditorRender).",
		        blockTypes: ".CJavaScript::encode($this->blockTypes).",
		        baseImageUrl: '{$this->baseImageUrl}',
		      });

		    });
		";		

		$jsAll="
		    $(function(){
		      
			SirTrevor.DEBUG = true;
			SirTrevor.LANGUAGE = \"en\";
			
			SirTrevor.setDefaults({
			  uploadUrl: \"{$this->uploadUrl}\"
			});

		      SirTrevor.setBlockOptions(\"Text\", {
		        onBlockRender: function() {
		          console.log(\"Text block rendered\");
		        }
		      });
			  // SirTrevor.setBlockOptions(\"Tweet\", {
				 // fetchUrl: function(tweetID) {
				 //   return \"http://twitter.com/tweets/?tweet_id=\" + tweetID;
				 // }
			  // });

		    });
		";
/*
<style>
body {
  font-family: 'Source Sans Pro', sans-serif;
}
</style>
*/
		$assets=$this->getAssets();
		$cs=Yii::app()->getClientScript();
		
		$cs->registerCss("ext.inputs-sir-trevor.GSirTrevor#","

/*alert alert-danger*/

.st-errors {
margin-left: 0;
position: relative;
padding-left: 30px;
background-color: #f2dede;
border-color: #ebccd1;
color: #a94442;
padding: 15px;
margin-bottom: 20px;
border: 1px solid transparent;
border-radius: 4px;}

.st-errors p,
.st-errors ul {
  margin: 0; }

.st-errors ul {
  padding-left: 1em; }

.st-errors p {
  margin-bottom: 0.5em;
  font-weight: 700; }

.st-block__inner ::-moz-selection {
  background: {$this->primaryColor};
  text-shadow: none; }
.st-block__inner ::selection {
  background: {$this->primaryColor};
  text-shadow: none; }

.st-block-controls__top:hover:before {
  color: {$this->primaryColor};
  background: #f3f3f3; }

.st-block-control:hover {
  color: {$this->primaryColor}; }

.st-block__inner:hover {
  border-color: {$this->primaryColor}; }


.st-block--with-plus:after {
  background: #f3f3f3;
  color: {$this->primaryColor}; }
.st-block__upload-container:hover .st-upload-btn {
  background: {$this->primaryColor}; }

.st-block__messages {
  display: none;
  position: relative;
  top: -1.9em;
  left: -1.9em;
  padding: .3em .5em;
  border: 2px solid {$this->primaryColor};
  border-left: none;
  border-top: none;
  max-width: 80%; }

.st-block-positioner {
  border: 0.125em solid {$this->primaryColor};
  position: absolute;
  z-index: 2;
  left: -5.5em;
  bottom: 0.4em;
  background: #fff;
  visibility: hidden;
  opacity: 0;
  -webkit-transition: opacity 0.2s ease-in-out;
  -moz-transition: opacity 0.2s ease-in-out;
  transition: opacity 0.2s ease-in-out; }

.st-block-positioner:after {
  content: '';
  display: block;
  width: 0.4em;
  height: 0.4em;
  position: absolute;
  right: -0.3em;
  bottom: 0.6em;
  z-index: 1;
  border: 0.125em solid {$this->primaryColor};
  background: #fff;
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg); }

.st-block-positioner__title {
  color: {$this->primaryColor};
  font-size: 0.7em;
  font-style: italic;
  font-weight: normal;
  margin: 0;
  border-bottom: 1px solid {$this->primaryColor};
  padding: 0.5em;
  text-align: center; }

.st-block-ui-btn, .st-block-control-ui-btn {
  display: block;
  float: left;
  width: 3em;
  height: 2.5em;
  line-height: 2.5em;
  font-size: 1.4em;
  color: {$this->primaryColor};
  background: #fff;
  text-align: center;
  border: 2px solid {$this->primaryColor};
  border-right: 0;
  border-bottom: 0;
  margin-bottom: 0;
  cursor: pointer; }

.st-block-control-ui-btn {
  width: 2em;
  height: 1.75em;
  font-size: 1.5em;
  line-height: 1.25em;
  height: 1.25em;
  border: 2px solid {$this->primaryColor};
  border-left: 0;
  border-bottom: 0; }


.st-block-ui-btn:hover, .st-block-control-ui-btn:hover,
.st-block-control-ui-btn:hover {
  color: #fff;
  background: {$this->primaryColor}; }

.st-format-btn:hover,
.st-format-btn--is-active {
  color: {$this->primaryColor}; }

		");
		$cs->registerScriptFile($assets."/js/underscore/underscore.js",CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets."/js/Eventable/eventable.js",CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets."/js/sir-trevor.js",CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets."/js/locales/de.js",CClientScript::POS_HEAD);
		
		$cs->registerCssFile($assets."/css/sir-trevor-icons.css");
		$cs->registerCssFile($assets."/css/sir-trevor.css");
		$cs->registerCssFile("http://fonts.googleapis.com/css?family=Source+Sans+Pro");

		$cs->registerScript('ext.inputs-sir-trevor.GSirTrevor#',$jsAll,CClientScript::POS_END);
		$cs->registerScript('ext.inputs-sir-trevor.GSirTrevor#'.$widgetID,$js,CClientScript::POS_END);
	}

	public function getAssets()
	{
		if($this->_assets===null)
			$this->_assets=Yii::app()->assetManager->publish(dirname(__FILE__)."/assets/");
		return $this->_assets;
	}
}
