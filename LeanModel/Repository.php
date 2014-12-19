<?php

namespace LeanModel;

use LeanMapper\Repository as LeanRepository,
	LeanMapper\Exception\InvalidValueException,
	BadMethodCallException;


abstract class Repository extends LeanRepository
{

	/**
	 * Returns single entity by 'id'.
	 * 
	 * @param Entity|int $id
	 * @return Entity
	 * @throws InvalidValueException
	 */
	public function get($id)
	{
		return $this->getBy(array('id' => $id));
	}


	/**
	 * Returns single entity by condition.
	 * 
	 * @param string $by
	 * @return Entity
	 * @throws InvalidValueException
	 */
	public function getBy($by)
	{
		$rows = $this->createFluent()
			->where($by)
			->fetchAll();

		if (count($rows) === 1) {
			return $this->createEntity($rows[0]);
		}
		elseif (count($rows) > 1) {
			throw new InvalidValueException("There are more valid records in database. Use 'findBy()' instead.");
		}
		else {
			return NULL;
		}
	}


	/**
	 * Returns collection of all entities in repository.
	 * 
	 * @return Collection
	 */
	public function findAll()
	{
		$entities = $this->createFluent()
			->fetchAll();

		return $this->createEntities($entities);
	}


	/**
	 * Returns collection of entities by condition.
	 * 
	 * @param array $by
	 * @return Collection
	 */
	public function findBy($by)
	{
		$entities = $this->createFluent()
			->where($by)
			->fetchAll();

		return $this->createEntities($entities);
	}


	/**
	 * Magical methods eg. getByFoo('foo'), or  findByFooAndBar('foo', 'bar').
	 * 
	 * @param string $method
	 * @param mixed  $args
	 * @return Entity|Collection
	 */
	public function __call($method, $args)
	{
		if (self::stringStartsWith($method, 'findBy')) {
			$stringOfKeys = substr($method, 6);
			$arrayOfKeys = explode('And', $stringOfKeys);
			$arrayOfLowerKeys = array_map('lcFirst', $arrayOfKeys);
			$arrayOfArgs = array_combine($arrayOfLowerKeys, $args);
			return call_user_func(array($this, 'findBy'), $arrayOfArgs);
		}
		elseif (self::stringStartsWith($method, 'getBy')) {
			$stringOfKeys = substr($method, 5);
			$arrayOfKeys = explode('And', $stringOfKeys);
			$arrayOfLowerKeys = array_map('lcFirst', $arrayOfKeys);
			$arrayOfArgs = array_combine($arrayOfLowerKeys, $args);
			return call_user_func(array($this, 'getBy'), $arrayOfArgs);
		}
		else {
			$class = get_class($this);
			throw new BadMethodCallException("Call to undefined method $class::$method().");
		}
	}
	
	
	#====================
	
	
	/**
	 * Starts the $haystack string with the prefix $needle?
	 * @param  string
	 * @param  string
	 * @return bool
	 */
	private static function stringStartsWith($haystack, $needle)
	{
		return strncmp($haystack, $needle, strlen($needle)) === 0;
	}

}
