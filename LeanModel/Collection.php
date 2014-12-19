<?php

namespace LeanModel;

use ArrayObject;


class Collection extends ArrayObject
{
	
	/**
	 * Returns array of pairs $key => $value.
	 * @param string $key
	 * @param string $value
	 * @return array
	 */
	public function fetchPairs($key, $value)
	{
		$pairs = array();
		foreach ($this as $entity) {
			$pairs[$entity->$key] = $entity->$value;
		}
		return $pairs;
	}
	
	
	/**
	 * Returns array of $entity->toArray().
	 * @return array
	 */
	public function toArray()
	{
		$array = array();
		foreach($this as $entity)
		{
			$array[] = $entity->toArray();
		}
		return $array;
	}
	
	
	/**
	 * Returns array of $entity->toIdentifier(), usually array of int.
	 * @return array
	 */
	public function toArrayOfIdentifiers()
	{
		$array = array();
		foreach($this as $entity)
		{
			$array[] = $entity->toIdentifier();
		}
		return $array;
	}

}
