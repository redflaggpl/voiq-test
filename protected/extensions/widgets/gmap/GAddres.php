<?php
class GAddress extends CWidget
{
	/**
	 * @see http://www.yiiframework.com/extension/egmap/
	*/
	public $address="Czech Republic, Prague, Olivova";
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
	    $sample_address = $this->address;
	    // Create geocoded address
	    $geocoded_address = new EGMapGeocodedAddress($sample_address);
	    $geocoded_address->geocode($gMap->getGMapClient());
	    // Center the map on geocoded address
	     $gMap->setCenter($geocoded_address->getLat(), $geocoded_address->getLng());
	    // Add marker on geocoded address
	    $gMap->addMarker(
	         new EGMapMarker($geocoded_address->getLat(), $geocoded_address->getLng())
	    );
	    $gMap->renderMap();
	}
}