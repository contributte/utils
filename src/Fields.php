<?php declare(strict_types = 1);

namespace Contributte\Utils;

class Fields
{

	public static function inn(string $s): mixed
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);
		$s = sprintf('%08s', $s);

		return $s;
	}

	public static function tin(string $s): mixed
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);
		$s = strtoupper($s);

		return $s;
	}

	public static function zip(string $s): mixed
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);

		return $s;
	}

	public static function phone(string $s): mixed
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);

		return $s;
	}

}
