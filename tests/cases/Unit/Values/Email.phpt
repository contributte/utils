<?php declare(strict_types = 1);

/**
 * Test: Values\Email
 */

use Contributte\Utils\Values\Email;
use Tester\Assert;

require_once __DIR__ . '/../../../bootstrap.php';

test(function (): void {
	$email = new Email('foo@bar.baz');
	Assert::same('foo@bar.baz', $email->get());
});

test(function (): void {
	$email = new Email('foo@bar.baz');
	Assert::true($email->equal(new Email('foo@bar.baz')));
});
