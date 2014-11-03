<?php
/**
 * GUpload class file.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * GUpload displays a star rating control that can collect user rating input.
 *
 * GUpload is based on {@link http://www.fyneworks.com/jquery/star-rating/ jQuery Star Rating Plugin}.
 * It displays a list of stars indicating the rating values. Users can toggle these stars
 * to indicate their rating input. On the server side, when the rating input is submitted,
 * the value can be retrieved in the same way as working with a normal HTML input.
 * For example, using
 * <pre>
 * $this->widget('pat.to.location.GUpload',array('name'=>'rating'));
 * </pre>
 * we can retrieve the rating value via <code>$_POST['rating']</code>.
 *
 * GUpload allows customization of its appearance. It also supports empty rating as well as read-only rating.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @package system.web.widgets
 * @since 1.0
 */
class GUpload extends CInputWidget
{

	public $typeError;
	public $sizeError;
	public $minSizeError;
	public $emptyError;
	public $onLeave;

	public $sizeValidate=array(); // $this->createUrl('upload')
	public $actionUrl; // $this->createUrl('upload')
	public $containerCss='stick-image';
	public $buttonText='Seleccione un archivo';
	public $allowedExtensions=array('png','jpg','jpeg');
	public $templateSmall='Tamaño recomendado ({width}px X {height}px)';
	public $cssFile=false;
	public $iconButtom='fa-camera';
	public $imgContainerOptions=array();

	public $width='300';
	public $height='400';
	public $crop=false;

	// @TODO Implementar extensiones y iconos
	public $iconExtensions=array('pdf'=>'fa fa-file-pdf-o fa-5x');

	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the text field.
	 */
	public function run()
	{
		$uploadDir=Yii::app()->baseUrl.'/uploads';
		list($name,$id)=$this->resolveNameID();
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		$this->registerClientScript($id);
	    
	    if($this->sizeValidate!==array() and isset($this->sizeValidate['width'],$this->sizeValidate['height']))
	    {
	    	$this->width=$this->sizeValidate['width'];
	    	$this->height=$this->sizeValidate['height'];
			
			$textSmall=strtr($this->templateSmall,
				array('{width}'=>$this->sizeValidate['width'],
					'{height}'=>$this->sizeValidate['height']));
	    	echo '<small class="text-muted">'.$textSmall.'</small>';
	    }
		
		$img='';
		
		if(!$this->model->isNewRecord and !empty($this->model->{$this->attribute}))
			$img="<img id=\"jcrop_target{$id}\" class=\"img-responsive img-rounded\" src=\"{$uploadDir}/{$this->model->{$this->attribute}}\" alt=\"\">";
		
		$arrayFile=explode('.', $this->model->{$this->attribute});
		$ext = end($arrayFile);
		if(isset($this->iconExtensions[$ext])) {
			$filenamePreview = $this->iconExtensions[$ext];
			$img = "<div class=\"text-center\"><a href=\"{$uploadDir}/{$this->model->{$this->attribute}}\" target=\"_blank\"><i class=\"{$filenamePreview}\"></i></a></div>";
		}
		
		if(isset($this->imgContainerOptions['class']))
			$this->imgContainerOptions['class']=$this->imgContainerOptions['class']." {$this->containerCss} {$id}_img text-center";
		else
			$this->imgContainerOptions['class']="{$this->containerCss} {$id}_img text-center";
		$this->imgContainerOptions['data-url']="{$uploadDir}";

		
		$icon="";
		if($this->iconButtom!==false)
			$icon="<i class=\"fa {$this->iconButtom} mtl\" style=\"font-size: 10em;color: #f0f0f0\"></i>";
		if(!$this->model->isNewRecord and !empty($this->model->{$this->attribute}))
			$icon="";
		
		echo "<div class=\"tile qq-upload-extra-drop-area\">
	  	<div".CHtml::renderAttributes($this->imgContainerOptions).">
		  	{$img}
	    	{$icon}
	  	</div>
	    	<div id=\"{$id}_link\"></div>
	    </div>";
	    echo CHtml::activeHiddenField($this->model,$this->attribute,$this->htmlOptions);
		
	}

	/**
	 * Registers the necessary javascript and css scripts.
	 * @param string $id the ID of the container
	 */
	public function registerClientScript($id)
	{
		$this->typeError=Yii::t('app',"Unfortunately the file(s) you selected weren't the type we were expecting. Only {extensions} files are allowed.");
		$this->sizeError=Yii::t('app',"{file} is too large, maximum file size is {sizeLimit}.");
		$this->minSizeError=Yii::t('app',"{file} is too small, minimum file size is {minSizeLimit}.");
		$this->emptyError=Yii::t('app',"{file} is empty, please select files again without it.");
		$this->onLeave=Yii::t('app',"The files are being uploaded, if you leave now the upload will be cancelled.");
		
		$params=$this->sizeValidate===array()?'{}':CJSON::encode($this->sizeValidate);
		$uploadDir=Yii::app()->baseUrl.'/uploads';
		$iconSmall="";
		if($this->iconButtom!==false)
			$iconSmall="<i class=\"fa {$this->iconButtom}\"></i>";
		
		$crop="";
		if($this->crop)
		{
			$crop="
$(function(){
    // Create variables (in this scope) to hold the API and image size
    var jcrop_api, boundx, boundy;

    $('#jcrop_target{$id}').Jcrop({
        onChange: updatePreview,
        onSelect: updatePreview,
        aspectRatio: 0.75,
        trueSize: [{$this->width},{$this->height}]
    },function(){
        // Use the API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[0.75];
        //trueSize: [ancho,alto],
        // Store the API in the jcrop_api variable
        jcrop_api = this;
    });

    function updatePreview(c){
        if (parseInt(c.w) > 0){
            var rx = {$this->width} / c.w;
            var ry = {$this->height} / c.h;

            $('#preview').css({
                width: Math.round(rx * boundx) + 'px',
                height: Math.round(ry * boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
        }
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };
});";
		}
		$js="
		{$crop}
			var uploader{$id} = new qq.FileUploader({
		        element: document.getElementById('{$id}_link'),
		        action: '{$this->actionUrl}',
		        params: {$params},
		        allowedExtensions: ".CJSON::encode($this->allowedExtensions).",
		        dragText: 'Arrastre su archivo aquí',
		        uploadButtonText: '<a class=\"btn btn-primary btn-large btn-block\" href=\"#\">{$iconSmall} {$this->buttonText}</a>',
		        // debug: true,
		        // multiple: false,
		        extraDropzones: [qq.getByClass(document, 'qq-upload-extra-drop-area')[0]],
		        hideShowDropArea: false,
		        showMessage: function(message){
		            bootbox.alert(message);
		        },
		        messages: {
					typeError: \"{$this->typeError}\",
					sizeError: \"{$this->sizeError}\",
					minSizeError: \"{$this->minSizeError}\",
					emptyError: \"{$this->emptyError}\",
					onLeave: \"{$this->onLeave}\"
				},
				fileTemplate: '<li>' +
	                '<span class=\"qq-progress-bar pls\"></span>' +
	                '<span class=\"qq-upload-file pls\"></span>' +
	                '<span class=\"qq-upload-spinner pls\"></span>' +
	                '<span class=\"qq-upload-size pls\"></span>' +
	                '<a class=\"qq-upload-cancel\" href=\"#\">{cancelButtonText}</a>' +
	                '<span class=\"qq-upload-failed-text\">{failUploadtext}</span>' +
	            '</li>',
		        onComplete: function(id, fileName, responseJSON){
		        	if(responseJSON.success) {
		        		var iconExtensions = ".CJSON::encode($this->iconExtensions).";
		        		$('.{$this->containerCss}.{$id}_img').empty();
		        		
		        		var ext = responseJSON.fileName.split('.').pop();
		        		var filenamePreview = responseJSON.fileName;
		        		var html = '<img id=\"jcrop_target{$id}\" class=\"img-responsive img-rounded\" src=\"{$uploadDir}/'+filenamePreview+'\" alt=\"\">';
		        		
		        		if(iconExtensions[ext]) {
							filenamePreview = iconExtensions[ext];
		        			html = '<div class=\"text-center\"><a href=\"{$uploadDir}/'+responseJSON.fileName+'\" target=\"_blank\"><i class=\"'+filenamePreview+'\"></i></a></div>';
		        		}
		        		$('#{$id}').val(responseJSON.fileName);
		        		$('.{$this->containerCss}.{$id}_img').html(html);
		        	}
		        },
		    });
		";
		$cropCss="";
		if($this->crop)
		{
			$cropCss="
				.{$this->containerCss} {
					overflow-x: auto;
				}
			";
		}
		$assets=Yii::app()->assetManager->publish(dirname(__FILE__)."/assets/");
		$cs=Yii::app()->getClientScript();
		$cs->registerScript('ext.GUpload#'.$id,$js,CClientScript::POS_LOAD);
		$cs->registerScriptFile($assets."/fileuploader.js",CClientScript::POS_HEAD);
		if($this->crop)
		{
			$cs->registerScriptFile($assets."/jcrop/js/jquery.Jcrop.min.js",CClientScript::POS_HEAD);
			$cs->registerCssFile($assets."/jcrop/css/jquery.Jcrop.min.css");
		}
		$cs->registerCss('ext.GUploadCss#'.$id,"
			{$cropCss}
			.qq-upload-list {
				/*display: none;*/
			}
			.qq-upload-failed-text {
				display: none;
			}
			.qq-upload-drop-area {
				text-align: center;
				color: #ccc;
				font-size: 0.9em;
				padding: 10px 0 10px 0;
			}
			.tile.qq-upload-extra-drop-area {
				border-radius: 8px;
				border: 6px #f0f0f0 dotted;
				min-height: 50px;
			}
		");

		if($this->cssFile!==false)
			self::registerCssFile($this->cssFile);
	}

	/**
	 * @TODO
	 * Registers the needed CSS file.
	 * @param string $url the CSS URL. If null, a default CSS URL will be used.
	 */
	public static function registerCssFile($url=null)
	{
		$cs=Yii::app()->getClientScript();
		if($url===null)
			$url=$cs->getCoreScriptUrl().'/path/to/my.css';
		$cs->registerCssFile($url);
	}
}