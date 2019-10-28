<?php declare(strict_types = 1);

/**
 * Test: DateTime [comparing]
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Utils\DateTime;
use Tester\Assert;

// Test: datetime
test(function (): void {
	// Now
	$now = new DateTime('2014-1-2 00:00:00');

	// Limits
	$from = new DateTime('2014-1-1 00:00:00');
	$until = new DateTime('2014-1-5 00:00:00');

	Assert::false($from > $now);
	Assert::false($until < $now);
});

// Test: datetime convert to strtotime
test(function (): void {
	// Now
	$now = strtotime((string) new DateTime('2014-1-2 00:00:00'));

	// Limits
	$from = strtotime((string) new DateTime('2014-1-1 00:00:00'));
	$until = strtotime((string) new DateTime('2014-1-5 00:00:00'));

	Assert::false($from > $now);
	Assert::false($until < $now);
});

// Test: now == until
test(function (): void {
	// Now
	$now = new DateTime('2014-1-5 00:00:00');

	// Limits
	$from = new DateTime('2014-1-1 00:00:00');
	$until = new DateTime('2014-1-5 00:00:00');

	Assert::false($from > $now);
	Assert::false($until < $now);
});

// Test: datetimes with DD.MM.YYYY 00:00:00
test(function (): void {
	// Now
	$now = new DateTime('now');
	$now->setTime(0, 0, 0);

	// Limits
	$from = new DateTime('- 1 day');
	$from->setTime(0, 0, 0);

	$until = new DateTime('now');
	$until->setTime(0, 0, 0);

	Assert::false($from > $now);
	Assert::false($until < $now);
});
