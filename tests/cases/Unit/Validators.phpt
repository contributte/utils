<?php declare(strict_types = 1);

/**
 * Test: Validators
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Utils\Validators;
use Tester\Assert;

// Validators::isRc
test(function (): void {
	Assert::equal(true, Validators::isRc('780123/3540'));
	Assert::equal(true, Validators::isRc('9609030739'));
	Assert::equal(true, Validators::isRc('875917/7383'));
	Assert::equal(true, Validators::isRc('465816/043'));
	Assert::equal(true, Validators::isRc('9353218105'));
	Assert::equal(true, Validators::isRc('1210050094'));
	Assert::equal(true, Validators::isRc('0712050735'));

	Assert::equal(false, Validators::isRc('9353218115'));
	Assert::equal(false, Validators::isRc('9357218115'));
	Assert::equal(false, Validators::isRc('93572184115'));
	Assert::equal(false, Validators::isRc('a935184115'));
});

// Validators::isIco
test(function (): void {
	Assert::equal(false, Validators::isIco('CZ11223344'));
	Assert::equal(false, Validators::isIco('4513543'));
	Assert::equal(true, Validators::isIco('69663963'));
	Assert::equal(true, Validators::isIco('48136450'));
	Assert::equal(true, Validators::isIco('00274046'));
	Assert::equal(true, Validators::isIco('00274046'));
	Assert::equal(true, Validators::isIco('00064581'));
	Assert::equal(true, Validators::isIco('44992785'));
	Assert::equal(true, Validators::isIco('26443341'));
});
