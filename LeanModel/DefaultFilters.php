<?php

namespace LeanModel;

use LeanMapper\Connection,
	LeanMapper\Fluent;


class DefaultFilters implements IFilters
{
	
	public function registerFilters(Connection $connection)
	{
		$connection->registerFilter('limit', [$this, 'limit']);
		$connection->registerFilter('where', [$this, 'where']);
		$connection->registerFilter('is', [$this, 'is']);
		$connection->registerFilter('not', [$this, 'not']);
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
		$statement->where([$column => TRUE]);
	}
	
	
	public function not(Fluent $statement, $column)
	{
		$statement->where([$column => FALSE]);
	}
	
}
