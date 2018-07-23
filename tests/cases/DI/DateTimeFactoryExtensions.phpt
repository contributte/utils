<?php declare(strict_types = 1);

/**
 * Test: DI\DateTimeFactoryExtension
 */

use Contributte\Utils\DI\DateTimeFactoryExtension;
use Contributte\Utils\IDateTimeFactory;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

test(function (): void {
	$loader = new ContainerLoader(TEMP_DIR, true);
	$class = $loader->load(function (Compiler $compiler): void {
		$compiler->addExtension('datetime', new DateTimeFactoryExtension());
	}, 1);

	/** @var Container $container */
	$container = new $class();

	Assert::type(IDateTimeFactory::class, $container->getByType(IDateTimeFactory::class));
});
