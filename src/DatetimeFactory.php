<?php

namespace Contributte\Utils;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class DatetimeFactory implements IDateTimeFactory
{

	/**
	 * @return DateTime
	 */
	public function create()
	{
		return new DateTime();
	}

}
