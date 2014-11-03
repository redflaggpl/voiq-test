<?php
/**
 * GMap class file.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * GMap displays a star rating control that can collect user rating input.
 *
 * GMap is based on {@link http://www.fyneworks.com/jquery/star-rating/ jQuery Star Rating Plugin}.
 * It displays a list of stars indicating the rating values. Users can toggle these stars
 * to indicate their rating input. On the server side, when the rating input is submitted,
 * the value can be retrieved in the same way as working with a normal HTML input.
 * For example, using
 * <pre>
 * $this->widget('pat.to.location.GMap',array('name'=>'rating'));
 * </pre>
 * we can retrieve the rating value via <code>$_POST['rating']</code>.
 *
 * GMap allows customization of its appearance. It also supports empty rating as well as read-only rating.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @package system.web.widgets
 * @since 1.0
 */
class GMap extends CInputWidget
{
	
	public $templateSmall='Puede seleccionar una dirección desde el mapa, dando clic ';
	
	public $iconButton='fa fa-map-marker';
	public $readonly=false;
	public $searchWithDepartament=false;
	

	/*
	 * @imgIcon
	 * In this attribute you can send
	 * absolute or relatyve url for icon 
	 * for marker
	 * if you have your icon on your img dir:
	 * 
	 * ...
	 * 'imgIcon'=>Yii::app()->request->baseUrl.'/img/myicon.png',
	 * ...
	 * 
	 * 
	 * Or if you have your icon on your theme folder
	 * ...
	 * 'imgIcon'=>Yii::app()->theme->baseUrl.'/img/myicon.png',
	 * ...
	*/
	public $imgIcon;

	private $_assets;
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the text field.
	 */
	public function run()
	{
		if($this->imgIcon!==null)
			$imageIcon=$this->imgIcon;
		else
		{
			$assets=$this->getAssets();
			$imageIcon=$assets.'/etiqueta.png';
		}

		list($name,$id)=$this->resolveNameID();
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

		$this->registerClientScript($id);
	    
	    $this->htmlOptions["class"]="form-control";
		if($this->readonly)
			$this->htmlOptions["readonly"]="readonly";
		
		$idLat=strtr("{$id}",array(get_class($this->model)."_"=>""))."_lat";
		$idLng=strtr("{$id}",array(get_class($this->model)."_"=>""))."_lng";
		
		$valLat='';		
		if(isset($this->model->{$idLat}))
			$valLat=$this->model->{$idLat};

		$valLng='';		
		if(isset($this->model->{$idLng}))
			$valLng=$this->model->{$idLng};		
		
		// @TODO hacer editable el path es un array
		$valPath='';		
		// if(isset($this->model->path))
		// 	$valLng=$this->model->path;
		
		$valAddress='';
		if(isset($this->model->{$this->attribute}))
			$valAddress=$this->model->{$this->attribute};
		
		echo "<small class=\"text-muted\"><em>{$this->templateSmall} <a href=\"#\" id=\"{$id}_button\" class=\"\"> aquí <i class=\"fa fa-map-marker\"></i></a></em></small>";
		echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);

echo "<input value=\"{$valLat}\" type=\"hidden\" id=\"{$id}_lat\" name=\"".get_class($this->model)."[".strtr($id,array(get_class($this->model).'_'=>''))."_lat]\">";
echo "<input value=\"{$valLng}\" type=\"hidden\" id=\"{$id}_long\" name=\"".get_class($this->model)."[".strtr($id,array(get_class($this->model).'_'=>''))."_lng]\">";
echo "<input value=\"{$valPath}\" type=\"hidden\" id=\"{$id}_path\" name=\"".get_class($this->model)."[".strtr($id,array(get_class($this->model).'_'=>''))."_path]\">";

		echo "<div class=\"modal fade\" id=\"{$id}_modal\" tabindex=\"-1\" role=\"{$id}_modal\" aria-hidden=\"true\">
<div class=\"modal-dialog\" style=\"width: auto;\">
    <div class=\"modal-content\">
        <div class=\"modal-header\">
            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
            <h4 class=\"modal-title\"><i class=\"fa fa-map-marker\"></i> Ubicar dirección en el mapa</h4>
        </div>
    	<div class=\"modal-body\">
    	 	<div class=\"input-group\">
				<span class=\"input-group-addon\">
				    <a href=\"#\" id=\"{$id}_ttext\"></a> > <a href=\"#\" id=\"{$id}_dtext\"></a>
				</span>
 		 	<input type=\"text\" id=\"{$id}_address\" value=\"{$valAddress}\" placeholder=\"Digíta una dirección o lugar - Ej: Calle 85 Carrera 90\" class=\"form-control\">
    			<span class=\"input-group-btn\">
				    <a href=\"#\" id=\"{$id}_search\" class=\"btn btn-primary\"><i class=\"fa fa-search\"></i> Buscar</a>
					<a href=\"#\" id=\"{$id}_close\" class=\"btn btn-primary\"><i class=\"fa fa-map-marker\"></i> Listo</a>
					<a href=\"#\" id=\"{$id}_draw\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i> Dibujar cuadrante</a>
				</span>	
			</div>
    	
    		<br>
    		<div data-img=\"{$imageIcon}\" style=\"width:100%;height:500px\" id=\"{$id}_map\"></div>
        </div>
        </div>
    </div>
</div>";
		
	}

	/**
	 * Registers the necessary javascript and css scripts.
	 * @param string $id the ID of the container
	 */
	public function registerClientScript($id)
	{
		$validateDepartament="$('#{$id}_modal').modal('show');";
		if($this->searchWithDepartament)
		{
			$validateDepartament="
			if($({$id}).attr('readonly')=='readonly') {
				bootbox.alert('En este tipo de notificacion no es posible cambiar la dirección seleccionada.');
			} else {
				if($('#Notifications_department_id').val()!='' && $('#Notifications_town_id')!='') {
					$('#{$id}_modal').modal('show');
		    	} else {
		    		bootbox.alert('Por favor seleccione ciudad y departamento');
				}
	    	}";
		}

		$js="
			/*-----------------------REPORTAR EVENTO EN EL MAPA {$id}-----------------------------------*/
			//Actios Eventos
			$(function() {

		    	$('#{$id}_modal').on('shown.bs.modal', function (e) {
				  	crearevento('{$id}');
			    	setTimeout(function(){
			            $('#{$id}_address').focus();
			        }, 1);
				})
				$(document).on('click','#{$id}_button, #{$id}',function(e) {
			    	e.preventDefault();
			    	{$validateDepartament}
			    });
				$(document).on('click','#{$id}_close',function(e) {
					e.preventDefault();
			    	if($('#{$id}_address').val()=='') {
			    		bootbox.alert('Por favor digíta una dirección o lugar - Ej: Calle 85 Carrera 90<br> Al digitar la dirección presione enter o clic en buscar, Esta dirección buscará en la ciudad y departamento seleccionada previamente.');
			    	} else {
						$('#{$id}').val($('#{$id}_address').val());
				    	$('#{$id}_modal').modal('hide');
					}
			    });
			});
		";
		$assets=$this->getAssets();
		$cs=Yii::app()->getClientScript();
		$cs->registerScriptFile("https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing",CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets."/googleMap.js",CClientScript::POS_HEAD);
		$cs->registerScript('ext.GMap#'.$id,$js,CClientScript::POS_END);
	}

	public function getAssets()
	{
		if($this->_assets===null)
			$this->_assets=Yii::app()->assetManager->publish(dirname(__FILE__)."/assets/");
		return $this->_assets;
	}
}