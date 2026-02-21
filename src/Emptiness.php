<?php declare(strict_types = 1);

namespace Contributte\Utils;

final class Emptiness
{

	public static function empty(mixed $value): bool
	{
		return $value === null || $value === '' || $value === [];
	}

	public static function notEmpty(mixed $value): bool
	{
		return !self::empty($value);
	}

}
