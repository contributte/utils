<?php declare(strict_types = 1);

namespace Contributte\Utils\Collections;

use ArrayIterator;
use IteratorAggregate;

class LazyCollection implements IteratorAggregate
{

	/** @var callable */
	private $callback;

	/** @var mixed[]|null */
	private $data;

	private function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	public static function fromCallback(callable $callback): self
	{
		return new static($callback);
	}

	public function getIterator(): ArrayIterator
	{
		if ($this->data === null) {
			$this->data = call_user_func($this->callback);
		}

		return new ArrayIterator($this->data);
	}

}
