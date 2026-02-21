<?php declare(strict_types = 1);

namespace Contributte\Utils;

class System
{

	/** @var array<string, float> */
	public static array $timers = [];

	public static function memoryUsage(): string
	{
		return sprintf(
			'%dKB / %dMB',
			round(memory_get_usage(true) / 1024),
			round(memory_get_usage(true) / 1024 / 1024)
		);
	}

	public static function memoryPeakUsage(): string
	{
		return sprintf(
			'%dKB / %dMB',
			round(memory_get_peak_usage(true) / 1024),
			round(memory_get_peak_usage(true) / 1024 / 1024)
		);
	}

	public static function timer(string $timer): float|null
	{
		if (isset(self::$timers[$timer])) {
			$time = microtime(true) - self::$timers[$timer];
			unset(self::$timers[$timer]);

			return $time;
		}

		self::$timers[$timer] = microtime(true);

		return null;
	}

}
