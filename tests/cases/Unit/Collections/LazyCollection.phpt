<?php declare(strict_types = 1);

/**
 * Test: ViewModel\Collections\LazyCollection
 */

use Contributte\Utils\Collections\LazyCollection;
use Tester\Assert;

require_once __DIR__ . '/../../../bootstrap.php';

test(function (): void {
	$data = ['foo', 'bar', 'baz'];

	$callback = function () use ($data): array {
		return $data;
	};

	$collection = LazyCollection::fromCallback($callback);

	foreach ($collection as $key => $item) {
		Assert::same($data[$key], $item);
	}
});
