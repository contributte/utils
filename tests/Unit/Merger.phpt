<?php declare(strict_types = 1);

use Contributte\Utils\Merger;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

test(function (): void {
	$right = [
		'default' => 'default',
		'overriden' => 'not-overriden',
		'merged' => [
			'foo' => 'foo',
			'bar' => 'bar',
			'baz' => 'baz',
		],
	];

	$left = [
		'overriden' => 'overriden',
		'new' => 'new',
		'merged' => [
			'baz' => 'foo',
		],
	];

	$expected = [
		'default' => 'default',
		'overriden' => 'overriden',
		'merged' => [
			'foo' => 'foo',
			'bar' => 'bar',
			'baz' => 'foo',
		],
		'new' => 'new',
	];

	$merged = Merger::merge($left, $right);
	Assert::same($expected, $merged);
});

test(function (): void {
	$left = [
		0 => 'zero left',
		'one' => 'one left',
		2 => 'two left',
		'3' => 'three left',
	];

	$right = [
		2 => 'two right',
		'3' => 'three right',
		4 => 'four right',
	];

	$expected = [
		2 => 'two right',
		'3' => 'three right',
		4 => 'four right',
		5 => 'zero left',
		'one' => 'one left',
		6 => 'two left',
		7 => 'three left',
	];

	Assert::same($expected, Merger::merge($left, $right));
});

test(function (): void {
	$left = 10;
	$right = 20;
	Assert::same(10, Merger::merge($left, $right));
});

test(function (): void {
	$left = ['foo' => 'bar'];
	$right = 10;
	Assert::same(['foo' => 'bar'], Merger::merge($left, $right));
});

test(function (): void {
	$left = 10;
	$right = ['foo' => 'bar'];
	Assert::same(10, Merger::merge($left, $right));

	$left = null;
	$right = ['foo' => 'bar'];
	Assert::same(['foo' => 'bar'], Merger::merge($left, $right));
});
