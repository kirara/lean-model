<?php

namespace LeanModel;

use LeanMapper\Entity as LeanEntity,
	LeanMapper\Exception\MemberAccessException,
	DateTime;


abstract class Entity extends LeanEntity
{
	
	/**
	 * Time format used when convert entity to array.
	 * @var string
	 */
	protected $dateTimeFormat = DateTime::ATOM;
	
	
	/**
	 * Its possibe assign just foreign key value instead assign whole instance of entity.
	 * @example $book->author = 1;
	 *
	 * @param string $name
	 * @param mixed  $value
	 */
	public function __set($name, $value)
	{
		$property = $this->getCurrentReflection()->getEntityProperty($name);
		if ($property->hasRelationship() && !($value instanceof Entity))
		{
			$relationship = $property->getRelationship();
			$this->row->{$property->getColumn()} = $value;
			$this->row->cleanReferencedRowsCache($relationship->getTargetTable(), $relationship->getColumnReferencingTargetTable());
		}
		else
		{
			parent::__set($name, $value);
		}
	}


	/**
	 * Returns identifier of this entity.
	 * @return int|string
	 */
	public function toIdentifier()
	{
		if($this->getCurrentReflection()->getEntityProperty('id') === NULL )
		{
			$class = $this->getReflection()->name;
			throw new MemberAccessException("There are no property 'id' in entity '$class'! Please, rewrite 'toIdentifier()' method.");
		}
		else
		{
			return $this->id;
		}
	}

	
	/**
	 * @return array
	 */
	public function toArray()
	{
		$array = [];
		$data = $this->isDetached() ? $this->row->getData() : $this->getData();
		foreach($data as $property => $value)
		{
			if($value instanceof Entity) {
				$array[$property] = $value->toIdentifier();
			}
			elseif($value instanceof Collection) {
				$array[$property] = $value->toArrayOfIdentifiers();
			}
			elseif($value instanceof DateTime) {
				$array[$property] = $value->format($this->dateTimeFormat);
			}
			else {
				$array[$property] = $value;
			}
		}
		return $array;
	}

}
