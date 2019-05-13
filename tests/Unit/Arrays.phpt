<?php declare(strict_types = 1);

use Contributte\Utils\Arrays;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

test(function (): void {
	$array1 = ['a', 'b', 'c', 'd'];
	$hash1 = Arrays::hash($array1);

	$array2 = ['d', 'c', 'b', 'a'];
	$hash2 = Arrays::hash($array2);

	Assert::same('61989d9767b812f110d23314bebf33c4', $hash1);
	Assert::same($hash1, $hash2); // array values are internally sorted so same values should produce same hash
	Assert::same(['d', 'c', 'b', 'a'], $array2); // hash generation should not affect original array
});
