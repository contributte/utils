<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\InvalidArgumentException;

class Deeper
{

	/**
	 * @template T
	 * @param array<T> $arr
	 * @param non-empty-string $sep
	 */
	public static function has(string|int $key, array $arr, string $sep = '.'): bool
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
	 * @param array<T> $arr
	 * @param non-empty-string $sep
	 * @param ?T $default
	 * @return ?T
	 */
	public static function get(string|int $key, array $arr, string $sep = '.', mixed $default = null): mixed
	{
		if (func_num_args() < 4) {
			return Arrays::get($arr, static::flat($key, $sep));
		}

		return Arrays::get($arr, static::flat($key, $sep), $default);
	}

	/**
	 * @param non-empty-string $sep
	 * @return string[]
	 */
	public static function flat(string|int|bool|null $key, string $sep = '.'): array
	{
		if ($key === '' || $key === null || $key === false) {
			return [];
		}

		return explode($sep, (string) $key);
	}

}
