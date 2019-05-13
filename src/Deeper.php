<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\InvalidArgumentException;

class Deeper
{

	/**
	 * @param mixed $key
	 * @param mixed[] $arr
	 */
	public static function has($key, array $arr, string $sep = '.'): bool
	{
		try {
			static::get($key, $arr, $sep);
			return true;
		} catch (InvalidArgumentException $e) {
			return false;
		}
	}

	/**
	 * @param mixed $key
	 * @param mixed[] $arr
	 * @param mixed $default
	 * @return mixed
	 * @throws InvalidArgumentException Thrown if value is missing and $default is not specified
	 */
	public static function get($key, array $arr, string $sep = '.', $default = null)
	{
		if (func_num_args() < 4) {
			return Arrays::get($arr, static::flat($key, $sep));
		}

		return Arrays::get($arr, static::flat($key, $sep), $default);
	}

	/**
	 * @param mixed $key
	 * @return mixed[]
	 */
	public static function flat($key, string $sep = '.'): array
	{
		if ($key === '' || $key === null || $key === false) {
			return [];
		}

		return (array) explode($sep, $key);
	}

}
