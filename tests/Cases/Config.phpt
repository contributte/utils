<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Config;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Toolkit::test(function (): void {
	$data = [
		'foo' => 'bar',
		'conn' => [
			'host' => 'http://hostname',
			'auth' => [
				'user' => 'username',
				'pass' => 'password',
			],
			'debug' => true,
			'limit' => 10,
		],
	];

	$cfg = new Config($data);

	Assert::type(stdClass::class, $cfg);
	Assert::equal('bar', $cfg->foo);
	Assert::type(stdClass::class, $cfg->conn);
	Assert::equal('http://hostname', $cfg->conn->host);
	Assert::equal(true, $cfg->conn->debug);
	Assert::equal(10, $cfg->conn->limit);
	Assert::type(stdClass::class, $cfg->conn->auth);
	Assert::equal('username', $cfg->conn->auth->user);
	Assert::equal('password', $cfg->conn->auth->pass);
});
