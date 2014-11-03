<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class JsonController extends Controller
{
	
    public $app;
    public $user;
	public function filters()
    {
        return array(
            array(
                'ext.filters.GApi',
            ),
        );
    }

    /**
	 * Handles the request whose action is not recognized.
	 * This method is invoked when the controller cannot find the requested action.
	 * The default implementation simply throws an exception.
	 * @param string $actionID the missing action name
	 * @throws CHttpException whenever this method is invoked
	 */
	public function missingAction($actionID)
	{
		$url='/'.$this->module->id.'/'.strtolower($this->id);
		$this->app=Yii::app()->api->getSlim();
		$this->app->response->headers->set('Content-Type', 'application/json');
		$req=$this->app->request;
		$res=$this;
		if($req->headers->get('Authorization')!="")
    	{
		    $tokenArray=explode(" ",$req->headers->get('Authorization'));
		    $token=isset($tokenArray[1])?$tokenArray[1]:null;
			if($token!==null and $tokenArray[0]==='Bearer')
				$res->user=Users::model()->findByToken($token);
			else if(__users()->allowBasicOAuth)
    		{
    			if($token!==null and $tokenArray[0]==='Basic')
					$res->user=Users::model()->findByBasic($token);
    		}
    	}
    	$this->routes($this->app,$url,$req,$res);
	}

	public function checkAccess()
	{
		return $this->user!==null;
	}

	public function filterAuth()
	{
		if(!$this->checkAccess())
			$this->error("access_denied","You do not have access to take this action",null);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Task the loaded model
	 * @throws CHttpException
	 */
	public function notFound()
	{
		$result=array(
			'error'=>'not_found',
			'error_description'=>'The requested page does not exist.',
		);
		echo CJSON::encode($result);
		$this->app->stop();
	}

	public function error($code,$error_description,$data=null)
	{
		echo CJSON::encode(array(
			"error"=>$code,
			"error_description"=>$error_description,
			"data"=>$data
		));
		$this->app->stop();
	}

	public function success($data=null,$message="Successful response")
	{
		echo CJSON::encode(array(
			"success"=>true,
			"message"=>$message,
			"data"=>$data
		));
		$this->app->stop();
	}

	public function validateSuccess($model=null)
	{
		$this->success($model,get_class($model)." has been saved successful");
		$this->app->stop();
	}

	public function validateError($errors=array())
	{
		$this->error("no_save","Validations errors",$errors);
		$this->app->stop();
	}

	public function toJson($json=array())
	{
		echo CJSON::encode($json);
		$this->app->stop();
	}
}