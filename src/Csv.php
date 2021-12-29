<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\InvalidStateException;

class Csv
{

	/**
	 * @param array<int|string, bool|float|int|string|null>[] $data
	 */
	public static function toCsv(array $data): string
	{
		if ($data === []) {
			return '';
		}

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

	/**
	 * @param array<string|float|int|bool> $scheme
	 * @return mixed[]
	 */
	public static function structural(array $scheme, string $file, string $delimiter = ';', string $enclosure = '"'): array
	{
		$data = [];

		// Read and parse CSV file
		$content = (array) file($file);
		foreach ($content as $n1 => $line1) {
			$data[$n1] = str_getcsv((string) $line1, $delimiter, $enclosure);
		}

		// No data at all
		if (count($data) <= 0) {
			return [];
		}

		// Validate scheme and CSV row
		if (count($scheme) > count($data[0])) {
			throw new InvalidStateException('Scheme has more fields then CSV line');
		}

		$result = [];
		foreach ($data as $line) {
			$liner = [];

			foreach ($line as $n => $v) {
				// Skip it
				if (!isset($scheme[$n])) {
					continue;
				}

				// Match value
				self::matchValue($v, $liner, explode('.', (string) $scheme[$n]));
			}

			$result[] = $liner;
		}

		return $result;
	}

	/**
	 * @param mixed $value
	 * @param mixed[][] $liner
	 * @param string[] $keys
	 */
	protected static function matchValue($value, array &$liner, array $keys): void
	{
		if (count($keys) > 1) {
			$tmp = array_shift($keys);
			if (!isset($liner[$tmp])) {
				$liner[$tmp] = [];
			}

			$liner[$tmp][current($keys)] = [];
			self::matchValue($value, $liner[$tmp], $keys);
		} else {
			$liner[current($keys)] = $value;
		}
	}

}
