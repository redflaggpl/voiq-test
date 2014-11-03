<?php
include_once(dirname(__FILE__).'/PHPExcel.php');
class GExcel extends PHPExcel_Reader_Excel5  implements IApplicationComponent
{
	private $_initialized=false;
	public function init()
	{
		$this->_initialized=true;
	}
	public function getIsInitialized()
	{
		return $this->_initialized;
	}
}