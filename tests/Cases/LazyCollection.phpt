<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\LazyCollection;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	$data = ['foo', 'bar', 'baz'];

	$callback = fn (): array => $data;

	$collection = LazyCollection::fromCallback($callback);

	foreach ($collection as $key => $item) {
		Assert::same($data[$key], $item);
	}
});
