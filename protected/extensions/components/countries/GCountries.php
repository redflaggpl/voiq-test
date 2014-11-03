<?php
/**
By @gsalgadotoledo
Basado en
http://chir.ag/projects/geoiploc/
*/
#include(dirname(__FILE__)."/geoiploc.php"); // Must include this
class GCountries extends CApplicationComponent
{
	public $ip;
	public $cacheID="cache";

	public function init()
	{
		#$this->ip="190.146.253.122"; #esta es de prueba porque no funciona conn localhost
		$this->ip=$_SERVER["REMOTE_ADDR"];
		parent::init();
	}

	public function getIni()
	{
		return "";#getCountryFromIP($this->ip);
	}

	public function get()
	{
		if($this->cacheID!==false && ($cache=Yii::app()->getComponent($this->cacheID))!==null)
		{
			$ps=$cache->get("paisesVisitantes");
			if(isset($ps[$this->ip]))
				return $ps[$this->ip];
		}
		#$ps[$this->ip]=getCountryFromIP($this->ip," NamE ");
		$meta=@unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$this->ip));
		$ps[$this->ip]=$meta['geoplugin_countryName']." ".$meta['geoplugin_region']." ".$meta['geoplugin_city'];
		if(isset($cache))
			$cache->set("paisesVisitantes",$ps,(3600*24*3650));
		// full name of country - spaces are trimmed
		return $ps[$this->ip];
	}

	public function getAbr()
	{
		// print country abbreviation - case insensitive
		return "";#getCountryFromIP($this->ip,"AbBr");
	}

	  // optionally, you can specify the return type
	  // type can be "code" (default), "abbr", "name"
	public function getCode()
	{
		return "";#getCountryFromIP($this->ip,"code");
	}
}