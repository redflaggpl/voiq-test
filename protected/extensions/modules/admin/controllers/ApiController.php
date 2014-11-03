<?php

class ApiController extends Controller
{
	/**
	 * Handles the request whose action is not recognized.
	 * This method is invoked when the controller cannot find the requested action.
	 * The default implementation simply throws an exception.
	 * @param string $actionID the missing action name
	 * @throws CHttpException whenever this method is invoked
	 */
	public function missingAction($actionID)
	{
		$api=Yii::app()->api->getSlim();
		$api->get('/admin/api/resume/:id', function ($name) {
		    echo "Hello, $name";
		});
		$api->run();
	}
}