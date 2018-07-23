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

		$builder->addDefinition($this->prefix('factory'))
			->setImplement(IDateTimeFactory::class);
	}

}
