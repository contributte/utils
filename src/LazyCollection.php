<?php declare(strict_types = 1);

namespace Contributte\Utils;

use ArrayIterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<int, mixed>
 */
class LazyCollection implements IteratorAggregate
{

	/** @var callable */
	private $callback;

	/** @var mixed[] */
	private $data = null;

	private function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	public static function fromCallback(callable $callback): self
	{
		return new static($callback);
	}

	/**
	 * @return ArrayIterator<int, mixed>
	 */
	public function getIterator(): ArrayIterator
	{
		if ($this->data === null) {
			$res = call_user_func($this->callback);
			$this->data = $res === false ? [] : (array) $res;
		}

		return new ArrayIterator($this->data);
	}

}
