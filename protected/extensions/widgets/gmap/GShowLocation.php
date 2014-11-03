<?php
class GShowLocation extends CWidget
{
	/**
	 * @see http://www.yiiframework.com/extension/egmap/
	*/
	public $lat=4.659634;
	public $lng=-74.062035;
	
	public $locations=array();
	public $poligons=array();
	
	public $color='#F5A9BC';
	public $width=300;
	public $height=180;
	public $zoom=15;

	public function run()
	{
		Yii::setPathOfAlias("gmap",dirname(__FILE__));
		Yii::import('gmap.*');
	    $gMap = new EGMap();
	    $gMap->setWidth($this->width);
	    $gMap->setHeight($this->height);
	    $gMap->zoom = $this->zoom;
	    
	    $gMap->setCenter($this->lat, $this->lng);
	    
	    // Create custom icon   
		$icon = new EGMapMarkerImage(Yii::app()->request->getBaseUrl(true).'/img/etiqueta.png');
		// $icon->setSize(32, 37);
		// $icon->setAnchor(16, 16.5);
		// $icon->setOrigin(0, 0);
	    if($this->locations!==array())
	    {
	    	foreach($this->locations as $data)
	    	{
				$gMap->addMarker(
			         new EGMapMarker($data->lat, $data->lng, array('icon'=>$icon))
			    );
			}
	    }
	    else
	    {
	    	$gMap->addMarker(
		         new EGMapMarker($this->lat, $this->lng, array('icon'=>$icon))
		    );
	    }
	    if($this->poligons!==array())
	    {
    		$coords=array();
    		foreach($this->poligons as $pol)
	    	{
    			$coords[]=new EGMapCoord($pol->lat, $pol->lng);
	    		// echo CJSON::encode($pol)."<br>";
	    		// foreach($pol as $coord)
	    		// 	echo CJSON::encode($coord)."<br>";
	    	}
    		$polygon=new EGMapPolygon($coords,array('fillColor'=>'"'.$this->color.'"','strokeColor'=>'"'.$this->color.'"'));
			// $polygon->addHtmlInfoWindow(new EGMapInfoWindow('Hey! I am a polygon!'));
			$gMap->addPolygon($polygon);
	    	$gMap->setCenter($this->poligons[0]->lat, $this->poligons[0]->lng);
		}
	    $gMap->renderMap();
	}
}