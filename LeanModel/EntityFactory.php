<?php

namespace Saman\LeanModel;

use LeanMapper\IEntityFactory;


class EntityFactory implements IEntityFactory
{

	/**
	 * @param string $entityClass
	 * @param Row|Traversable|array|null $arg
	 * @return Entity
	 */
	public function createEntity($entityClass, $arg = null)
	{
		return new $entityClass($arg);
	}


	/**
	 * @param Entity[] $entities
	 * @return Collection
	 */
	public function createCollection(array $entities)
	{
		return new Collection($entities);
	}

}