<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\Utils\Arrays as NetteArrays;
use Nette\Utils\Json;

class Arrays extends NetteArrays
{

	/**
	 * @param mixed[] $arr
	 */
	public static function hash(array $arr): string
	{
		array_multisort($arr);

		return md5(Json::encode($arr));
	}

}
