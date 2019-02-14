<?php declare(strict_types = 1);

namespace Contributte\Utils\DI;

use Contributte\Utils\IDateTimeFactory;
use Nette\DI\CompilerExtension;

class DateTimeFactoryExtension extends CompilerExtension
{

	/**
	 * Register services
	 */
	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		if (method_exists($builder, 'addFactoryDefinition')) {
			$builder->addFactoryDefinition($this->prefix('factory'))
				->setImplement(IDateTimeFactory::class);
		} else {
			$builder->addDefinition($this->prefix('factory'))
				->setImplement(IDateTimeFactory::class);
		}
	}

}
