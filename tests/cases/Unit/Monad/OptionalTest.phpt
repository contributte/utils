<?php declare(strict_types = 1);

namespace Tests\Contributte\Utils\Unit\Monad;

use Contributte\Utils\Monad\Optional;
use Exception;
use Nette\InvalidStateException;
use Tester\Assert;
use Tester\TestCase;
use Throwable;

require_once __DIR__ . '/../../../bootstrap.php';

class OptionalTest extends TestCase
{

	public function testValue(): void
	{
		$optional = Optional::of('foo');
		Assert::true($optional->isPresent());
		Assert::same('foo', $optional->get());
	}

	public function testEmpty(): void
	{
		$optional = Optional::empty();
		Assert::false($optional->isPresent());

		Assert::exception(function () use ($optional): void {
			$optional->get();
		}, InvalidStateException::class, 'Invalid optional value');
	}

	public function testElse(): void
	{
		$optional = Optional::empty();
		$optional->orElse('else');
		Assert::same('else', $optional->get());
	}

	public function testElseThrow(): void
	{
		$optional = Optional::empty();
		$optional->orElse(null);
		$optional->orElseThrow(new Exception('Waldo not found'));

		Assert::exception(function () use ($optional): void {
			$optional->get();
		}, Throwable::class, 'Waldo not found');
	}

}

(new OptionalTest())->run();
