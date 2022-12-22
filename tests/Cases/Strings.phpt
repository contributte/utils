<?php declare(strict_types = 1);

/**
 * Test: Strings
 */

require_once __DIR__ . '/../bootstrap.php';

use Contributte\Utils\Strings;
use Tester\Assert;

// Strings::spaceless
test(function (): void {
	Assert::equal('CZ11223344', Strings::spaceless('CZ11223344'));
	Assert::equal('CZ11223344', Strings::spaceless(' CZ 11 22 33 44'));
	Assert::equal('CZ11223344', Strings::spaceless('CZ 11 22 33 44 '));
	Assert::equal('CZ11223344', Strings::spaceless('CZ 11 22 33 44'));
	Assert::equal('CZ11223344', Strings::spaceless('CZ 11   22 33 44'));
	Assert::equal('CZ11223344', Strings::spaceless('    CZ 11 22 33 44'));
});

// Strings::doublespaceless
test(function (): void {
	Assert::equal('CZ11223344', Strings::doublespaceless('CZ11223344'));
	Assert::equal('CZ11223344', Strings::doublespaceless(' CZ11223344 '));
	Assert::equal('CZ11223344', Strings::doublespaceless(' CZ11223344 '));
	Assert::equal('CZ 11 22 33 44', Strings::doublespaceless(' CZ  11  22  33  44 '));
	Assert::equal('foo bar', Strings::doublespaceless('foo           bar'));
	Assert::equal('foo bar', Strings::doublespaceless('   foo           bar   '));
});

// Strings::dashless
test(function (): void {
	Assert::equal('CZ11223344', Strings::dashless('CZ-11-22-33-44'));
	Assert::equal('CZ11223344', Strings::dashless('CZ-11223344'));
	Assert::equal('CZ11223344', Strings::dashless('CZ-11---223344'));
	Assert::equal('CZ11223344', Strings::dashless(' CZ-11223344 '));
	Assert::equal('CZ11223344', Strings::dashless('     CZ-11223344     '));
});

// Strings::slashless
test(function (): void {
	Assert::equal('foo/bar', Strings::slashless('foo//bar'));
	Assert::equal('foo/bar', Strings::slashless(' foo//bar'));
	Assert::equal('foo/bar', Strings::slashless('foo//bar '));
	Assert::equal('foo/bar', Strings::slashless(' foo///////bar '));
});

// Strings::replacePrefix
// Strings::replaceSuffix
test(function (): void {
	Assert::equal('foobar', Strings::replacePrefix('foobar', 'ob', 'prefix_'));
	Assert::equal('prefix_', Strings::replacePrefix('foobar', 'foobar', 'prefix_'));
	Assert::equal('prefix_bar', Strings::replacePrefix('foobar', 'foo', 'prefix_'));
	Assert::equal('prefix_foofoo', Strings::replacePrefix('foofoofoo', 'foo', 'prefix_'));

	Assert::equal('foobar', Strings::replaceSuffix('foobar', 'ob', '_suffix'));
	Assert::equal('_suffix', Strings::replaceSuffix('foobar', 'foobar', '_suffix'));
	Assert::equal('foo_suffix', Strings::replaceSuffix('foobar', 'bar', '_suffix'));
	Assert::equal('foofoo_suffix', Strings::replaceSuffix('foofoofoo', 'foo', '_suffix'));
});
