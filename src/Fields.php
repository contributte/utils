<?php

namespace Contributte\Utils;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Fields
{

	/**
	 * @param string $s
	 * @return mixed
	 */
	public static function inn($s)
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);
		$s = sprintf('%08s', $s);

		return $s;
	}

	/**
	 * @param string $s
	 * @return mixed
	 */
	public static function tin($s)
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);
		$s = strtoupper($s);

		return $s;
	}

	/**
	 * @param string $s
	 * @return mixed
	 */
	public static function zip($s)
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);

		return $s;
	}

	/**
	 * @param string $s
	 * @return mixed
	 */
	public static function phone($s)
	{
		$s = Strings::spaceless($s);
		$s = Strings::dashless($s);

		return $s;
	}

}
