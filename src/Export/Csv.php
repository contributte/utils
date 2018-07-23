<?php declare(strict_types = 1);

namespace Contributte\Utils\Export;

class Csv
{

	/**
	 * @param mixed[] $data
	 */
	public static function toCsv(array $data): string
	{
		if ($data === []) return '';

		/** @var resource $resource */
		$resource = fopen('php://temp/maxmemory:' . (5 * 1024 * 1024), 'r+'); // 5MB of memory allocated
		foreach ($data as $row) {
			fputcsv($resource, $row);
		}

		rewind($resource);
		$output = stream_get_contents($resource);
		fclose($resource);

		return (string) $output;
	}

}
