<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Stringable;

final class TextString implements Stringable
{

	public function __construct(
		private string $text,
	)
	{
	}

	public function __toString(): string
	{
		return $this->text;
	}

}
