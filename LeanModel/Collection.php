<?php

namespace Saman\LeanModel;

use ArrayObject;


class Collection extends ArrayObject
{
	
	/**
	 * Returns array of $entity->toArray().
	 * @return array
	 */
	public function toArray()
	{
		$array = [];
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
		$array = [];
		foreach($this as $entity)
		{
			$array[] = $entity->toIdentifier();
		}
		return $array;
	}

}
