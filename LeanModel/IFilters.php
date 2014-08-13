<?php

namespace LeanModel;

use LeanMapper\Connection;


interface IFilters
{
	
	public function registerFilters(Connection $connection);
	
}
