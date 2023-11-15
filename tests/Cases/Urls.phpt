<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Urls;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// Urls::spaceless
Toolkit::test(function (): void {
	Assert::equal(false, Urls::hasFragment('https://has-fragment.com'));
	Assert::equal(true, Urls::hasFragment('https://has-fragment.com#fragment'));
	Assert::equal(true, Urls::hasFragment('#fragment'));
});
