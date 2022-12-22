<?php declare(strict_types = 1);

namespace Tests\Cases;

require_once __DIR__ . '/../bootstrap.php';

use Contributte\Utils\Deeper;
use Nette\InvalidArgumentException;
use Tester\Assert;
use Tester\TestCase;

class DeeperTest extends TestCase
{

	public function testHas(): void
	{
		Assert::true(Deeper::has('foo', ['foo' => 'bar']));
		Assert::false(Deeper::has('foo', []));
	}

	public function testGet(): void
	{
		Assert::same('default', Deeper::get('foo', [], '.', 'default'));
		Assert::same('bar', Deeper::get('foo', ['foo' => 'bar']));
		Assert::same('baz', Deeper::get('foo.bar', ['foo' => ['bar' => 'baz']]));
	}

	public function testGetFailure(): void
	{
		Assert::exception(function (): void {
			Deeper::get('missing', []);
		}, InvalidArgumentException::class);
	}

	/**
	 * @dataProvider validFlatProvider
	 * @param mixed   $key
	 * @param mixed[] $array
	 */
	public function testFlat($key, array $array): void
	{
		Assert::same($array, Deeper::flat($key));
	}

	/**
	 * @return string[]
	 */
	public function validFlatProvider(): iterable
	{
		yield [null, []];
		yield [false, []];
		yield ['', []];
		yield ['db', ['db']];
		yield ['db.host', ['db', 'host']];
		yield ['db.host.new', ['db', 'host', 'new']];
		yield ['db.db', ['db', 'db']];
	}

}

(new DeeperTest())->run();
