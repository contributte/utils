<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\System;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	Assert::true((bool) preg_match('#^\d+KB / \d+MB$#', System::memoryUsage()));
	Assert::true((bool) preg_match('#^\d+KB / \d+MB$#', System::memoryPeakUsage()));
});

Toolkit::test(function (): void {
	Assert::null(System::timer('basic-timer'));
	usleep(1000);

	$time = System::timer('basic-timer');
	Assert::true(is_float($time));
	Assert::true($time > 0.0);

	Assert::null(System::timer('basic-timer'));
});
