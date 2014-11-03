<?php
class EArrayBehavior extends CBehavior
{
	private $owner;
	private $relations;
	
	public function toArray($attributesToShow=null)
	{
		$this->owner = $this->getOwner();
		if (is_subclass_of($this->owner,'CActiveRecord'))
		{
			$attributes = $this->owner->getAttributes($attributesToShow);
			$this->relations 	= $this->getRelated();
			foreach($this->relations as $name=>$data)
				$attributes[$name]=$data;
			$jsonDataSource = $attributes;
			return $jsonDataSource;
		}
		return false;
	}
	private function getRelated()
	{	
		$related = array();
		$obj = null;
		$md=$this->owner->getMetaData();
		foreach($md->relations as $name=>$relation)
		{
			$obj = $this->owner->getRelated($name);
			$related[$name] = $obj instanceof CActiveRecord ? $obj->getAttributes() : $obj;
		}
	    return $related;
	}
}