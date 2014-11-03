<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Model extends CActiveRecord
{
	public function behaviors() 
	{
	    return array(
	        'EJsonBehavior'=>array(
	    	    'class'=>'ext.behaviors.EJsonBehavior'
	        ),
	        'EArrayBehavior'=>array(
	    	    'class'=>'ext.behaviors.EArrayBehavior'
	        ),
	    );
	}


	/**
	 * Finds all active records satisfying the specified condition.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return CActiveRecord[] list of active records satisfying the specified condition. An empty array is returned if none is found.
	 */
	public function arrayAll($condition='',$params=array(),$attributesToShow=null)
	{
		$result=array();
		$models=parent::findAll($condition,$params);
		// convert an array to related records
		foreach($models as $data)
			$result[]=$data->toArray($attributesToShow);
		return $result;
	}

	
	/**
	 * Finds a single active record with the specified primary key.
	 * See {@link find()} for detailed explanation about $condition and $params.
	 * @param mixed $pk primary key value(s). Use array for multiple primary keys. For composite key, each key value must be an array (column name=>column value).
	 * @param mixed $condition query condition or criteria.
	 * @param array $params parameters to be bound to an SQL statement.
	 * @return CActiveRecord the record found. Null if none is found.
	 */
	public function arrayByPk($pk,$condition='',$params=array(),$attributesToShow=null)
	{
		$model=parent::findByPk($pk,$condition,$params);
		if($model!==null)
			return $model->toArray($attributesToShow);
		return $model;
	}

	/**
	 * Finds a single active record with the specified condition.
	 * @param mixed $condition query condition or criteria.
	 * If a string, it is treated as query condition (the WHERE clause);
	 * If an array, it is treated as the initial values for constructing a {@link CDbCriteria} object;
	 * Otherwise, it should be an instance of {@link CDbCriteria}.
	 * @param array $params parameters to be bound to an SQL statement.
	 * This is only used when the first parameter is a string (query condition).
	 * In other cases, please use {@link CDbCriteria::params} to set parameters.
	 * @return CActiveRecord the record found. Null if no record is found.
	 */
	public function findToArray($condition='',$params=array(),$attributesToShow=null)
	{
		$model=parent::find($condition,$params);
		if($model!==null)
			return $model->toArray($attributesToShow);
		return $model;
	}


	// For encode to array to use
	// $data=array_map(function($model){return $model->toArray();},$data);
	// echo CJSON::encode($data);
}