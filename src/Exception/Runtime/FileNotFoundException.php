<?php declare(strict_types = 1);

namespace Contributte\Utils\Exception\Runtime;

use Contributte\Utils\Exception\RuntimeException;

class FileNotFoundException extends RuntimeException
{

	public function __construct(string $path)
	{
		parent::__construct(sprintf('File not found at path "%s"', $path));
	}

}
