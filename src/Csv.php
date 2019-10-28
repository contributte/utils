<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\InvalidStateException;

class Csv
{

	/**
	 * @param mixed[] $scheme
	 * @return mixed[]
	 */
	public static function structural(array $scheme, string $file, string $delimiter = ';', string $enclosure = '"'): array
	{
		$data = [];

		// Read and parse CSV file
		$content = (array) file($file);
		foreach ($content as $n => $line) {
			$data[$n] = str_getcsv((string) $content[$n], $delimiter, $enclosure);
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
				if (!isset($scheme[$n]) || $scheme[$n] === null) {
					continue;
				}
				// Match value
				self::matchValue($v, $liner, explode('.', $scheme[$n]));
			}
			$result[] = $liner;
		}

		return $result;
	}

	/**
	 * @param mixed $value
	 * @param mixed[] $liner
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
