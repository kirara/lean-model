<?php

namespace LeanModel;

use Nette\DI\CompilerExtension;


/**
 * LeanMapper extension for Nette Framework 2.2. Creates services 'connection' and 'panel'. Optionally 'mapper' and 'entityFactory'
 *
 * @author David Grudl, Miroslav Mrázek
 */
class LeanModelExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig();

		
		$useProfiler = isset($config['profiler'])
			? $config['profiler']
			: class_exists('Tracy\Debugger') && $container->parameters['debugMode'];

		unset($config['profiler']);
		
		if (isset($config['flags'])) {
			$flags = 0;
			foreach ((array) $config['flags'] as $flag) {
				$flags |= constant($flag);
			}
			$config['flags'] = $flags;
		}
		
		if (isset($config['entityFactory'])) {
			$entityFactory = $config['entityFactory'];
			unset($config['entityFactory']);
		}

		if (isset($config['mapper'])) {
			$mapper = $config['mapper'];
			unset($config['mapper']);
		}
		
		if (isset($config['defaultEntityNamespace'])) {
			$defaultEntityNamespace = $config['defaultEntityNamespace'];
			unset($config['defaultEntityNamespace']);
		} else {
			$defaultEntityNamespace = 'App\Model';
		}
		
		$connection = $container->addDefinition($this->prefix('connection'))
			->setClass('LeanMapper\Connection', [$config]);
		
		
		if (isset($config['filters'])) {
			$filters = $config['filters'];
			unset($config['filters']);
		}
		else
		{
			$filters = [];
		}
		
		foreach ($filters as $key => $filter)
		{
			$filterName = (is_array($filter) ? key($filter) : (string)$key);
			$filterClass = (is_array($filter) ? $filter[$filterName] : $filter);
			
			$$filterName = $container->addDefinition($this->prefix("filters.$filterName"))
				->setClass($filterClass);

			$connection->addSetup([$$filterName, 'registerFilters'], [$connection]);
		}
			
		
		if(isset($entityFactory)) {
			$container->addDefinition($this->prefix('entityFactory'))
			->setClass($entityFactory);
		}
		
		if(isset($mapper)) {
			$container->addDefinition($this->prefix('mapper'))
			->setClass($mapper, [$defaultEntityNamespace]);
		}

		if ($useProfiler) {
			$panel = $container->addDefinition($this->prefix('panel'))
				->setClass('Dibi\Bridges\Tracy\Panel');
			$connection->addSetup([$panel, 'register'], [$connection]);
		}
	}

}
