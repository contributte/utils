<?php declare(strict_types = 1);

namespace Contributte\Utils\Exception\Runtime;

use Contributte\Utils\Exception\RuntimeException;

class InvalidEmailAddressException extends RuntimeException
{

	public function __construct(string $value)
	{
		parent::__construct(sprintf('Invalid email address "%s"', $value));
	}

}
