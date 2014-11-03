<?php
/**
 * GSWebUser class file
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2014 
 * @license http://www.yiiframework.com/license/
 */

class GSWebUser extends CWebUser
{
	public function checkAccessArray($roles=array())
	{
		if($roles===array())
			return false;
		foreach ($roles as $role) 
		{
			if($this->checkAccess($role))
				return true;
		}
		return false;
	}

	public function check($roles=null)
	{
		if($roles===null)
			return (!$this->isGuest);
		
		$args=func_get_args();
		if($args!==array() and count($args)>1)
			$roles=$args;
		
		if(is_array($roles))
		{
			foreach($roles as $role)
				if($this->checkAccess($role)) return true;
		}
		else if(is_string($roles))
			return $this->checkAccess($roles);

		return false;
	}

	private $_userToken;

	public function checkToken($roles=null)
	{
		$headers = apache_request_headers();
		if(isset($headers['Authorization']))
		{
			if($this->_userToken===null)
			{
				$token=null;
				$matches = array();
				if(Yii::app()->getModule('users')->allowBasicOAuth)
					preg_match('/Basic (.*)/', $headers['Authorization'], $matches);
				else
					preg_match('/Bearer (.*)/', $headers['Authorization'], $matches);
				
				if(isset($matches[1]))
					$token=$matches[1];

				if($token!==null)
				{
					if(Yii::app()->getModule('users')->allowBasicOAuth)
						$this->_userToken=Users::model()->findByBasic($token);
					else
						$this->_userToken=Users::model()->findByToken($token);
				}
			}
		}
		$args=func_get_args();
		if($args!==array() and count($args)>1)
			$roles=$args;
		
		if($this->_userToken===null)
			return false;
		return $this->_userToken->check($roles);
	}

	public function getUserToken()
	{
		$headers = apache_request_headers();
		if(isset($headers['Authorization']))
		{
			if($this->_userToken===null)
			{
				$token=null;
				$matches = array();
				if(Yii::app()->getModule('users')->allowBasicOAuth)
					preg_match('/Basic (.*)/', $headers['Authorization'], $matches);
				else
					preg_match('/Bearer (.*)/', $headers['Authorization'], $matches);
				
				if(isset($matches[1]))
					$token=$matches[1];

				if($token!==null)
				{
					if(Yii::app()->getModule('users')->allowBasicOAuth)
						$this->_userToken=Users::model()->findByBasic($token);
					else
						$this->_userToken=Users::model()->findByToken($token);
				}
			}
		}
		return $this->_userToken;
	}

	/**
	 * Returns a value indicating whether the user is a guest (not authenticated).
	 * @return boolean whether the current application user is a guest.
	 */

	/*
	private $_token;
	private $_userToken;
	public function getIsGuest()
	{
		if($isGuest=parent::getIsGuest())
		{
			$headers = apache_request_headers();
			if(isset($headers['Authorization']))
			{
				if($this->_userToken===null)
				{
					$matches = array();
					if(Yii::app()->getModule('users')->allowBasicOAuth)
						preg_match('/Basic (.*)/', $headers['Authorization'], $matches);
					else
						preg_match('/Bearer (.*)/', $headers['Authorization'], $matches);
					
					if(isset($matches[1]))
						$token=$matches[1];

					if(Yii::app()->getModule('users')->allowBasicOAuth)
						$this->_userToken=Users::model()->findByBasic($token);
					else
						$this->_userToken=Users::model()->findByToken($token);
				}
				
				return $this->_userToken===null;
			} 
		}
		return $isGuest;
	}
	*/

/*
	public function checkAccess($operation,$params=array(),$allowCaching=true)
	{
		$this->getIsGuest();
		if($this->_userToken!==null)
			return Yii::app()->authManager->checkAccess($operation,$this->_userToken->id,$params);
		return parent::checkAccess($operation,$params,$allowCaching);
	}
*/

	/**
	 * Returns a value that uniquely represents the user.
	 * @return mixed the unique identifier for the user. If null, it means the user is a guest.
	 */
	/*
	public function getId()
	{
		$this->getIsGuest();
		if($this->_userToken!==null and isset($this->_userToken->id))
			return $this->_userToken->id;
		else
			return parent::getId();
	}
	*/

	/**
	 * Returns the unique identifier for the user (e.g. username).
	 * This is the unique identifier that is mainly used for display purpose.
	 * @return string the user name. If the user is not logged in, this will be {@link guestName}.
	 */
	/*
	public function getName()
	{
		$this->getIsGuest();
		if($this->_userToken!==null and isset($this->_userToken->name))
			return $this->_userToken->name;
		else
			return parent::getName();
	}
	*/


	/**
	 * PHP magic method.
	 * This method is overriden so that persistent states can be accessed like properties.
	 * @param string $name property name
	 * @return mixed property value
	 */
	/*
	public function __get($name)
	{
		$this->getIsGuest();
		if($this->_userToken!==null and isset($this->_userToken->{$name}))
			return $this->_userToken->{$name};
		else
			return parent::__get($name);
	}
	*/
}