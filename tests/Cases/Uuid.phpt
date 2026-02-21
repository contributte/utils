<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Uuid;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	$uuid = Uuid::v4();

	Assert::true(Uuid::validateV4($uuid));
});

Toolkit::test(function (): void {
	Assert::false(Uuid::validateV4('not-a-uuid'));
	Assert::false(Uuid::validateV4('550e8400-e29b-11d4-a716-446655440000'));
	Assert::true(Uuid::validateV4('550e8400-e29b-41d4-a716-446655440000'));
});
