<?php

/**
 * Test: Strings
 */

require_once __DIR__ . '/../bootstrap.php';

use Contributte\Utils\Strings;
use Tester\Assert;

// Strings::spaceless
test(function () {
	Assert::equal('CZ11223344', Strings::spaceless('CZ11223344'));
	Assert::equal('CZ11223344', Strings::spaceless(' CZ 11 22 33 44'));
	Assert::equal('CZ11223344', Strings::spaceless('CZ 11 22 33 44 '));
	Assert::equal('CZ11223344', Strings::spaceless('CZ 11 22 33 44'));
	Assert::equal('CZ11223344', Strings::spaceless('CZ 11   22 33 44'));
	Assert::equal('CZ11223344', Strings::spaceless('    CZ 11 22 33 44'));
});

// Strings::doublespaceless
test(function () {
	Assert::equal('CZ11223344', Strings::doublespaceless('CZ11223344'));
	Assert::equal('CZ11223344', Strings::doublespaceless(' CZ11223344 '));
	Assert::equal('CZ11223344', Strings::doublespaceless(' CZ11223344 '));
	Assert::equal('CZ 11 22 33 44', Strings::doublespaceless(' CZ  11  22  33  44 '));
	Assert::equal('foo bar', Strings::doublespaceless('foo           bar'));
	Assert::equal('foo bar', Strings::doublespaceless('   foo           bar   '));
});

// Strings::dashless
test(function () {
	Assert::equal('CZ11223344', Strings::dashless('CZ-11-22-33-44'));
	Assert::equal('CZ11223344', Strings::dashless('CZ-11223344'));
	Assert::equal('CZ11223344', Strings::dashless('CZ-11---223344'));
	Assert::equal('CZ11223344', Strings::dashless(' CZ-11223344 '));
	Assert::equal('CZ11223344', Strings::dashless('     CZ-11223344     '));
});
