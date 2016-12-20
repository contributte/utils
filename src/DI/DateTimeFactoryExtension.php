<?php

namespace Contributte\Utils\DI;

use Contributte\Utils\DatetimeFactory;
use Contributte\Utils\IDateTimeFactory;
use Nette\DI\CompilerExtension;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class DateTimeFactoryExtension extends CompilerExtension
{

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('factory'))
			->setClass(IDateTimeFactory::class)
			->setFactory(DatetimeFactory::class);
	}

}
