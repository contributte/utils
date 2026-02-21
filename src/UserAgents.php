<?php declare(strict_types = 1);

namespace Contributte\Utils;

final class UserAgents
{

	public const USER_AGENTS = [
		'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
		'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
		'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
		'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0',
		'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:140.0) Gecko/20100101 Firefox/140.0',
		'Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0',
		'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.0 Safari/605.1.15',
		'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edg/138.0.0.0 Safari/537.36',
		'Go-http-client/1.1',
		'okhttp/4.12.0',
	];

	private static int $usedCursor = 0;

	public static function get(): string
	{
		$agent = self::USER_AGENTS[self::$usedCursor];
		self::$usedCursor = (self::$usedCursor + 1) % count(self::USER_AGENTS);

		return $agent;
	}

	public static function random(): string
	{
		$index = array_rand(self::USER_AGENTS);

		return self::USER_AGENTS[$index];
	}

}
