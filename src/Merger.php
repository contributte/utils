<?php declare(strict_types = 1);

namespace Contributte\Utils;

class Merger
{

	/**
	 * @param mixed $left
	 * @param mixed $right
	 * @return mixed
	 */
	public static function merge($left, $right)
	{
		if (is_array($left) && is_array($right)) {
			foreach ($left as $key => $val) {
				if (is_int($key)) {
					$right[] = $val;
				} else {
					if (isset($right[$key])) {
						$val = self::merge($val, $right[$key]);
					}

					$right[$key] = $val;
				}
			}

			return $right;
		}

		if ($left === null && is_array($right)) {
			return $right;
		}

		return $left;
	}

}
