<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Exception\Runtime\InvalidEmailAddressException;
use Contributte\Utils\Values\Email;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	$email = new Email('foo@bar.baz');
	Assert::same('foo@bar.baz', $email->get());
});

Toolkit::test(function (): void {
	$email = new Email('foo@bar.baz');
	Assert::true($email->equal(new Email('foo@bar.baz')));
});

Toolkit::test(function (): void {
	Assert::exception(function (): void {
		new Email('not-an-email');
	}, InvalidEmailAddressException::class, 'Invalid email address "not-an-email"');
});

Toolkit::test(function (): void {
	$email = new Email('foo@bar.baz');
	Assert::same('foo@bar.baz', (string) $email);
});
