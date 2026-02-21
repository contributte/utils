<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\TextString;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	$text = new TextString('hello');

	Assert::same('hello', (string) $text);
	Assert::same('hello', $text->__toString());
});
