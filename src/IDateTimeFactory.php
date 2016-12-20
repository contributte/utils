<?php

namespace Contributte\Utils;

use DateTime as NativeDateTime;
use Nette\Utils\DateTime as NetteDateTime;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
interface IDateTimeFactory
{

	/**
	 * @return DateTime|NetteDateTime|NativeDateTime
	 */
	public function create();

}
