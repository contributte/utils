<?php

namespace Contributte\Utils;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Urls
{

	/**
	 * @param string $url
	 * @return bool
	 */
	public static function hasFragment($url)
	{
		return Strings::startsWith($url, '#');
	}

}
