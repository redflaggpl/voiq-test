<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends Controller
{
	
	public function init()
	{
		parent::init();
		$this->isFrontAction();
	}
}