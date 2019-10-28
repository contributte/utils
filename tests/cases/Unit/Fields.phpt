<?php declare(strict_types = 1);

/**
 * Test: Fields
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Utils\Fields;
use Tester\Assert;

// Fields::inn
test(function (): void {
	Assert::equal('11223344', Fields::inn('11223344'));
	Assert::equal('11223344', Fields::inn('11-22-33-44'));
	Assert::equal('11223344', Fields::inn('11 22 33 44'));
	Assert::equal('11223344', Fields::inn('11-22 33-44'));
	Assert::equal('11223344', Fields::inn('11-22   33-44'));
	Assert::equal('00001234', Fields::inn('1234'));
	Assert::equal('00001234', Fields::inn('1-2-3-4'));
});

// Fields::tin
test(function (): void {
	Assert::equal('CZ11223344', Fields::tin('CZ11223344'));
	Assert::equal('CZ11223344', Fields::tin('CZ11-22-33-44'));
	Assert::equal('CZ11223344', Fields::tin('CZ 11 22 33 44'));
	Assert::equal('CZ11223344', Fields::tin('cz 11-22 33-44'));
	Assert::equal('CZ11223344', Fields::tin('cz 11-22  33-44'));
	Assert::equal('CZ1234', Fields::tin('cz1234'));
	Assert::equal('CZ1234', Fields::tin('cz1-2-3-4'));
});

// Fields::phone
test(function (): void {
	Assert::equal('123456789', Fields::phone('123456789'));
	Assert::equal('123456789', Fields::phone(' 123456789 '));
	Assert::equal('123456789', Fields::phone(' 123 456 789 '));
	Assert::equal('123456789', Fields::phone(' 123     456 789 '));
	Assert::equal('+420123456789', Fields::phone('+420 123 456 789 '));
	Assert::equal('+420123456789', Fields::phone('+420     123 456 789 '));
});

// Fields::zip
test(function (): void {
	Assert::equal('10000', Fields::zip('10000'));
	Assert::equal('10000', Fields::zip('10 000'));
	Assert::equal('10000', Fields::zip(' 10000 '));
	Assert::equal('10000', Fields::zip(' 10 000 '));
	Assert::equal('10000', Fields::zip(' 10    000 '));
});
