<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Emptiness;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	Assert::same(true, Emptiness::empty(null));
	Assert::same(true, Emptiness::empty(''));
	Assert::same(true, Emptiness::empty([]));
	Assert::same(false, Emptiness::empty(0));
	Assert::same(false, Emptiness::empty('0'));

	Assert::same(false, Emptiness::notEmpty(null));
	Assert::same(true, Emptiness::notEmpty('foo'));
});
