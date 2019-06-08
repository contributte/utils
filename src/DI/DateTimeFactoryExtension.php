<?php declare(strict_types = 1);

namespace Contributte\Utils\DI;

use Contributte\Utils\IDateTimeFactory;
use Nette\DI\CompilerExtension;

class DateTimeFactoryExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addFactoryDefinition($this->prefix('factory'))
			->setImplement(IDateTimeFactory::class);
	}

}
