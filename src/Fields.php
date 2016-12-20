<?php

namespace Contributte\Utils;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Fields
{

	/**
	 * @param string $str
	 * @return mixed
	 */
	public static function inn($str)
	{
		$str = Strings::spaceless($str);
		$str = Strings::dashless($str);
		$str = sprintf('%08s', $str);

		return $str;
	}

	/**
	 * @param string $str
	 * @return mixed
	 */
	public static function tin($str)
	{
		$str = Strings::spaceless($str);
		$str = Strings::dashless($str);
		$str = strtoupper($str);

		return $str;
	}

	/**
	 * @param string $str
	 * @return mixed
	 */
	public static function zip($str)
	{
		$str = Strings::spaceless($str);
		$str = Strings::dashless($str);

		return $str;
	}

	/**
	 * @param string $str
	 * @return mixed
	 */
	public static function phone($str)
	{
		$str = Strings::spaceless($str);
		$str = Strings::dashless($str);

		return $str;
	}

}
