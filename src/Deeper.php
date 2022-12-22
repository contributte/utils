<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\InvalidArgumentException;

class Deeper
{

	/**
	 * @template T
	 * @param array-key $key
	 * @param array<T> $arr
	 * @param non-empty-string $sep
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
	 * @template T
	 * @param array-key $key
	 * @param array<T> $arr
	 * @param non-empty-string $sep
	 * @param ?T $default
	 * @return ?T
	 */
	public static function get($key, array $arr, string $sep = '.', $default = null)
	{
		if (func_num_args() < 4) {
			return Arrays::get($arr, static::flat($key, $sep));
		}

		return Arrays::get($arr, static::flat($key, $sep), $default);
	}

	/**
	 * @param string|int|bool|null $key
	 * @param non-empty-string $sep
	 * @return string[]
	 */
	public static function flat($key, string $sep = '.'): array
	{
		if ($key === '' || $key === null || $key === false) {
			return [];
		}

		$res = explode($sep, (string) $key);

		if ($res === false) {
			return [];
		}

		return $res;
	}

}
