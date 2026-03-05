<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Exception\LogicalException;
use Contributte\Utils\ServerTiming;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	$serverTiming = new ServerTiming();

	Assert::exception(function () use ($serverTiming): void {
		$serverTiming->end('missing');
	}, LogicalException::class, 'Timer "missing" is not running');
});

Toolkit::test(function (): void {
	$serverTiming = new ServerTiming();

	$serverTiming->start('db', 'Database "query"');
	usleep(1000);
	$serverTiming->end('db');

	$serverTiming->start('cache');
	$serverTiming->end('cache');

	$formatted = $serverTiming->format();

	Assert::contains('db;dur=', $formatted);
	Assert::contains('cache;dur=', $formatted);
	Assert::contains(';desc="Database \\"query\\""', $formatted);
});

Toolkit::test(function (): void {
	Assert::same('', (new ServerTiming())->format());
});
