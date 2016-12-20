<?php

namespace Contributte\Utils\Export;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Csv
{

	/**
	 * @param array $data
	 * @return string
	 */
	public static function toCsv(array $data)
	{
		if (!$data) return NULL;

		$resource = fopen('php://temp/maxmemory:' . (5 * 1024 * 1024), 'r+'); // 5MB of memory allocated
		foreach ($data as $row) {
			fputcsv($resource, $row);
		}

		rewind($resource);
		$output = stream_get_contents($resource);
		fclose($resource);

		return $output;
	}

}
