<?php declare(strict_types = 1);

namespace Contributte\Utils\Monad;

use Nette\InvalidStateException;
use Throwable;

class Optional
{

	/** @var mixed */
	private $value;

	/** @var mixed */
	private $elseValue;

	/** @var Throwable */
	private $elseThrow;

	/**
	 * @param mixed $value
	 */
	protected function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * @param mixed $value
	 * @return static
	 */
	public static function of($value): self
	{
		return new static($value);
	}

	/**
	 * @return static
	 */
	public static function empty(): self
	{
		return new static(null);
	}

	public function isPresent(): bool
	{
		return $this->value !== null;
	}

	/**
	 * @param mixed $value
	 * @return static
	 */
	public function orElse($value): self
	{
		$this->elseValue = $value;

		return $this;
	}

	/**
	 * @return static
	 */
	public function orElseThrow(Throwable $e): self
	{
		$this->elseThrow = $e;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function get()
	{
		if ($this->value !== null) {
			return $this->value;
		}

		if ($this->elseValue !== null) {
			return $this->elseValue;
		}

		if ($this->elseThrow !== null) {
			throw $this->elseThrow;
		}

		throw new InvalidStateException('Invalid optional value');
	}

}
