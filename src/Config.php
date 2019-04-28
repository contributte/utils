<?php declare(strict_types = 1);

namespace Contributte\Utils;

use stdClass;

class Config extends stdClass
{

	/**
	 * @param mixed[] $config
	 */
	public function __construct(array $config)
	{
		$this->config = $this->hydrateArray($config, $this);
	}

	/**
	 * @param mixed[] $config
	 */
	private function hydrateArray(array $config, stdClass $parent): stdClass
	{
		foreach ($config as $key => $value) {
			$parent->$key = is_array($value)
				? $this->hydrateArray($value, new stdClass())
				: $value;
		}

		return $parent;
	}

}
