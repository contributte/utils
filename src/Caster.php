<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Contributte\Utils\Exception\LogicalException;

final class Caster
{

	public static function stringOrNull(mixed $value): string|null
	{
		if ($value === null) {
			return null;
		}

		if (!is_scalar($value)) {
			throw new LogicalException('Given value must be scalar or null');
		}

		return (string) $value;
	}

	public static function ensureString(mixed $value): string
	{
		return self::stringOrNull($value) ?? '';
	}

	public static function forceString(mixed $value): string
	{
		if (!is_scalar($value)) {
			throw new LogicalException('Given value must be scalar');
		}

		return (string) $value;
	}

	public static function intOrNull(mixed $value): int|null
	{
		if ($value === null) {
			return null;
		}

		if (!Validators::isNumericInt($value)) {
			throw new LogicalException('Given value must be integer or null');
		}

		return (int) $value; // @phpstan-ignore-line
	}

	public static function ensureInt(mixed $value): int
	{
		return self::intOrNull($value) ?? 0;
	}

	public static function forceInt(mixed $value): int
	{
		if (!Validators::isNumericInt($value)) {
			throw new LogicalException('Given value must be integer');
		}

		return (int) $value; // @phpstan-ignore-line
	}

	public static function floatOrNull(mixed $value): float|null
	{
		if ($value === null) {
			return null;
		}

		if (!Validators::isNumeric($value)) {
			throw new LogicalException('Given value must be float or null');
		}

		return (float) $value; // @phpstan-ignore-line
	}

	public static function ensureFloat(mixed $value): float
	{
		return self::floatOrNull($value) ?? 0.0;
	}

	public static function forceFloat(mixed $value): float
	{
		if (!Validators::isNumeric($value)) {
			throw new LogicalException('Given value must be float');
		}

		return (float) $value; // @phpstan-ignore-line
	}

	public static function boolOrNull(mixed $value): bool|null
	{
		if ($value === null) {
			return null;
		}

		if ($value === true || $value === false) {
			return $value;
		}

		if (!is_scalar($value)) {
			return null;
		}

		return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
	}

	public static function ensureBool(mixed $value): bool
	{
		return self::boolOrNull($value) ?? false;
	}

	public static function forceBool(mixed $value): bool
	{
		if (!is_bool($value)) {
			throw new LogicalException('Given value must be boolean');
		}

		return $value;
	}

	/**
	 * @template T
	 * @param T|T[]|null $value
	 * @return T[]
	 */
	public static function ensureArray(mixed $value): array
	{
		if (is_array($value)) {
			return $value;
		}

		if ($value === null) {
			return [];
		}

		if (is_scalar($value)) {
			return [$value];
		}

		throw new LogicalException('Given value must be array, scalar or null');
	}

	/**
	 * @template T
	 * @param T|T[] $value
	 * @return T[]
	 */
	public static function forceArray(mixed $value): array
	{
		if (!is_array($value)) {
			throw new LogicalException('Given value must be array');
		}

		return $value;
	}

}
