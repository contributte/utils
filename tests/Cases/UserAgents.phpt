<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\UserAgents;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	$first = UserAgents::get();
	$second = UserAgents::get();

	Assert::notSame($first, $second);

	for ($i = 0; $i < count(UserAgents::USER_AGENTS) - 2; $i++) {
		UserAgents::get();
	}

	Assert::same($first, UserAgents::get());
});

Toolkit::test(function (): void {
	$random = UserAgents::random();

	Assert::true(in_array($random, UserAgents::USER_AGENTS, true));
});
