<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\Utils\Strings as NetteStrings;

class Strings extends NetteStrings
{

	/**
	 * Replaces $s at the start with $replacement
	 */
	public static function replacePrefix(string $s, string $search, string $replacement = ''): string
	{
		if (strncmp($s, $search, strlen($search)) === 0) {
			$s = $replacement . substr($s, strlen($search));
		}

		return $s;
	}

	/**
	 * Replaces $s at the end with $replacement
	 */
	public static function replaceSuffix(string $s, string $search, string $replacement = ''): string
	{
		if (substr($s, -strlen($search)) === $search) {
			$s = substr($s, 0, -strlen($search)) . $replacement;
		}

		return $s;
	}

	/**
	 * Remove spaces from the beginning and end of a string
	 * and between chars
	 */
	public static function spaceless(string $s): string
	{
		$s = trim($s);
		$s = self::replace($s, '#\s#', '');

		return $s;
	}

	/**
	 * Remove spaces from the beginning and end of a string
	 * and convert double and more spaces between chars to one space
	 */
	public static function doublespaceless(string $s): string
	{
		$s = trim($s);
		$s = self::replace($s, '#\s{2,}#', ' ');

		return $s;
	}

	/**
	 * Remove spaces from the beginning and end of a string and remove dashes
	 */
	public static function dashless(string $s): string
	{
		$s = trim($s);
		$s = self::replace($s, '#\-#', '');

		return $s;
	}

	/**
	 * Remove spaces from the beginning and end of a string
	 * and convert double and more slashes between chars to one slash
	 */
	public static function slashless(string $s): string
	{
		$s = trim($s);
		$s = self::replace($s, '#\/{2,}#', '/');

		return $s;
	}

}
