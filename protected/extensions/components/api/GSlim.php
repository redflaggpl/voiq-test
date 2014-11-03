<?php
/**
 * GSWebUser class file
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2014 
 * @license http://www.yiiframework.com/license/
 */
require dirname(__FILE__).'/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

class GSlim extends CApplicationComponent
{
	public function getSlim()
	{
		return new \Slim\Slim();
	}
}
