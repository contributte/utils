<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Caster;
use Contributte\Utils\Exception\LogicalException;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	Assert::same(null, Caster::stringOrNull(null));
	Assert::same('123', Caster::stringOrNull(123));
	Assert::same('foo', Caster::ensureString('foo'));
	Assert::same('', Caster::ensureString(null));
	Assert::same('123', Caster::forceString(123));

	Assert::exception(function (): void {
		Caster::stringOrNull(new stdClass());
	}, LogicalException::class, 'Given value must be scalar or null');

	Assert::exception(function (): void {
		Caster::forceString([]);
	}, LogicalException::class, 'Given value must be scalar');
});

Toolkit::test(function (): void {
	Assert::same(null, Caster::intOrNull(null));
	Assert::same(12, Caster::intOrNull('12'));
	Assert::same(12, Caster::ensureInt('12'));
	Assert::same(0, Caster::ensureInt(null));
	Assert::same(12, Caster::forceInt('12'));

	Assert::exception(function (): void {
		Caster::intOrNull('12.5');
	}, LogicalException::class, 'Given value must be integer or null');

	Assert::exception(function (): void {
		Caster::forceInt('12.5');
	}, LogicalException::class, 'Given value must be integer');
});

Toolkit::test(function (): void {
	Assert::same(null, Caster::floatOrNull(null));
	Assert::same(12.5, Caster::floatOrNull('12.5'));
	Assert::same(12.5, Caster::ensureFloat('12.5'));
	Assert::same(0.0, Caster::ensureFloat(null));
	Assert::same(12.5, Caster::forceFloat('12.5'));

	Assert::exception(function (): void {
		Caster::floatOrNull('foo');
	}, LogicalException::class, 'Given value must be float or null');

	Assert::exception(function (): void {
		Caster::forceFloat('foo');
	}, LogicalException::class, 'Given value must be float');
});

Toolkit::test(function (): void {
	Assert::same(null, Caster::boolOrNull(null));
	Assert::same(true, Caster::boolOrNull('true'));
	Assert::same(false, Caster::boolOrNull('false'));
	Assert::same(null, Caster::boolOrNull('foo'));
	Assert::same(false, Caster::ensureBool(null));
	Assert::same(true, Caster::ensureBool('yes'));
	Assert::same(true, Caster::forceBool(true));

	Assert::exception(function (): void {
		Caster::forceBool(1);
	}, LogicalException::class, 'Given value must be boolean');
});

Toolkit::test(function (): void {
	Assert::same(['foo'], Caster::ensureArray('foo'));
	Assert::same([], Caster::ensureArray(null));
	Assert::same(['foo', 'bar'], Caster::ensureArray(['foo', 'bar']));
	Assert::same(['foo'], Caster::forceArray(['foo']));

	Assert::exception(function (): void {
		Caster::ensureArray(new stdClass());
	}, LogicalException::class, 'Given value must be array, scalar or null');

	Assert::exception(function (): void {
		Caster::forceArray('foo');
	}, LogicalException::class, 'Given value must be array');
});
