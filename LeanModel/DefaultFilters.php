<?php

namespace LeanModel;

use LeanMapper\Connection,
	LeanMapper\Fluent;


class DefaultFilters implements IFilters
{
	
	public function registerFilters(Connection $connection)
	{
		$connection->registerFilter('limit', array($this, 'limit'));
		$connection->registerFilter('where', array($this, 'where'));
		$connection->registerFilter('is', array($this, 'is'));
		$connection->registerFilter('not', array($this, 'not'));
	}


	public function limit(Fluent $statement, $limit)
	{
		$statement->limit($limit);
	}
	
	
	public function where(Fluent $statement, $where)
	{
		$statement->where($where);
	}
	
	
	public function is(Fluent $statement, $column)
	{
		$statement->where(array($column => TRUE));
	}
	
	
	public function not(Fluent $statement, $column)
	{
		$statement->where(array($column => FALSE));
	}
	
}
