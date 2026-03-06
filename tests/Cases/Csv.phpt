<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Csv;
use Nette\InvalidStateException;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	Assert::same('', Csv::toCsv([]));

	set_error_handler(static fn (int $severity, string $message): bool => $severity === E_DEPRECATED
		&& str_contains($message, 'fputcsv(): the $escape parameter must be provided'));

	try {
		$csv = Csv::toCsv([
			['name', 'city'],
			['Milan', 'Hradec Kralove'],
		]);
	} finally {
		restore_error_handler();
	}

	Assert::contains('name,city', $csv);
	Assert::contains('Milan,"Hradec Kralove"', $csv);
});

// Simple array matching
Toolkit::test(function (): void {
	Assert::equal([
		0 => [
			'name' => 'Milan',
			'surname' => 'Sulc',
			'city' => 'HK',
			'id' => '123456',
			'x' => 'foo',
		],
		1 => [
			'name' => 'John',
			'surname' => 'Doe',
			'city' => 'Doens',
			'id' => '111111',
			'x' => 'bar',
		],
	], Csv::structural([
		0 => 'name',
		1 => 'surname',
		2 => 'city',
		3 => 'id',
		4 => 'x',
	], __DIR__ . '/../Fixtures/sample.csv'));
});

// Complex array matching
Toolkit::test(function (): void {
	Assert::equal([
		0 => [
			'user' => [
				'name' => 'Milan',
				'surname' => 'Sulc',
			],
			'city' => 'HK',
			'extra' => [
				'id' => '123456',
				'x' => 'foo',
			],
		],
		1 => [
			'user' => [
				'name' => 'John',
				'surname' => 'Doe',
			],
			'city' => 'Doens',
			'extra' => [
				'id' => '111111',
				'x' => 'bar',
			],
		],
	], Csv::structural([
		0 => 'user.name',
		1 => 'user.surname',
		2 => 'city',
		3 => 'extra.id',
		4 => 'extra.x',
	], __DIR__ . '/../Fixtures/sample.csv'));
});

// Part of simple array matching
Toolkit::test(function (): void {
	Assert::equal([
		0 => [
			'x' => 'foo',
		],
		1 => [
			'x' => 'bar',
		],
	], Csv::structural([
		4 => 'x',
	], __DIR__ . '/../Fixtures/sample.csv'));
});

// Part of complex array matching
Toolkit::test(function (): void {
	Assert::equal([
		0 => [
			'x' => [
				'y' => [
					'z' => 'foo',
				],
			],
		],
		1 => [
			'x' => [
				'y' => [
					'z' => 'bar',
				],
			],
		],
	], Csv::structural([
		4 => 'x.y.z',
	], __DIR__ . '/../Fixtures/sample.csv'));
});

// Overriding
Toolkit::test(function (): void {
	Assert::equal([
		0 => [
			'x' => 'foo',
		],
		1 => [
			'x' => 'bar',
		],
	], Csv::structural([
		2 => 'x',
		4 => 'x',
	], __DIR__ . '/../Fixtures/sample.csv'));
});

// Invalid arguments
Toolkit::test(function (): void {
	Assert::throws(function (): void {
		Csv::structural([
			0 => 'a',
			1 => 'b',
			2 => 'c',
			3 => 'd',
			4 => 'e',
			5 => 'f',
			6 => 'g',
		], __DIR__ . '/../Fixtures/sample.csv');
	}, InvalidStateException::class);
});

Toolkit::test(function (): void {
	$emptyFile = tempnam(sys_get_temp_dir(), 'csv-empty');

	if ($emptyFile === false) {
		Assert::fail('Unable to create temporary file');
	}

	try {
		Assert::same([], Csv::structural([0 => 'name'], $emptyFile));
	} finally {
		@unlink($emptyFile);
	}
});

Toolkit::test(function (): void {
	$liner = ['existing' => 'value'];

	$proxy = new class extends Csv {

		/**
		 * @param array<int|string, mixed> $liner
		 * @param string[] $keys
		 */
		public static function invokeMatchValue(mixed $value, array &$liner, array $keys): void
		{
			self::matchValue($value, $liner, $keys);
		}

	};

	$proxy::invokeMatchValue('new', $liner, []);

	Assert::same(['existing' => 'value'], $liner);
});
