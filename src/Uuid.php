<?php declare(strict_types = 1);

namespace Contributte\Utils;

final class Uuid
{

	/**
	 * @see https://stackoverflow.com/a/15875555
	 */
	public static function v4(): string
	{
		$data = random_bytes(16);

		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}

	public static function validateV4(string $uuid): bool
	{
		return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid) === 1;
	}

}
