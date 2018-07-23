<?php declare(strict_types = 1);

namespace Contributte\Utils;

class Fields
{

	/**
	 * @return mixed
	 */
	public static function inn(string $s)
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);
		$s = sprintf('%08s', $s);

		return $s;
	}

	/**
	 * @return mixed
	 */
	public static function tin(string $s)
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);
		$s = strtoupper($s);

		return $s;
	}

	/**
	 * @return mixed
	 */
	public static function zip(string $s)
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);

		return $s;
	}

	/**
	 * @return mixed
	 */
	public static function phone(string $s)
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);

		return $s;
	}

}
