<?php declare(strict_types = 1);

namespace Contributte\Utils\Monad;

use Nette\InvalidStateException;
use Throwable;

/**
 * @phpstan-consistent-constructor
 */
class Optional
{

	private mixed $value;

	private mixed $elseValue = null;

	private ?Throwable $elseThrow = null;

	protected function __construct(mixed $value)
	{
		$this->value = $value;
	}

	/**
	 * @return static
	 */
	public static function of(mixed $value): self
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
	 * @return static
	 */
	public function orElse(mixed $value): self
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

	public function get(): mixed
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
