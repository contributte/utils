<?php

/**
 * Test: DI\DateTimeFactoryExtension
 */

use Contributte\Utils\DatetimeFactory;
use Contributte\Utils\DI\DateTimeFactoryExtension;
use Contributte\Utils\IDateTimeFactory;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

test(function () {
	$loader = new ContainerLoader(TEMP_DIR, TRUE);
	$class = $loader->load(function (Compiler $compiler) {
		$compiler->addExtension('datetime', new DateTimeFactoryExtension());
	}, 1);

	/** @var Container $container */
	$container = new $class;

	Assert::type(DatetimeFactory::class, $container->getByType(IDateTimeFactory::class));
});
