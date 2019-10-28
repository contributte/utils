<?php declare(strict_types = 1);

/**
 * Test: Http
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Utils\Http;
use Tester\Assert;

// Http::metadata
test(function (): void {
	Assert::equal([
		'bar' => 'foo',
		'bar1' => 'foo',
		'bar2 bar' => 'foo',
		'bar3' => 'foo',
		'bar4' => 'foo',
		'bar5' => 'foo',
		'bar6.bar' => 'foo',
		'bar7.bar' => 'foo',
	], Http::metadata('
		<meta content = foo name = bar />
		<meta content = foo name = bar1 >
		<meta name=  bar2 bar content= foo >
		<meta content="foo" name="bar3">
		<meta name  ="bar4" content  =  " foo ">
		<meta name=  "bar5" content="  foo  ">
		<meta name="bar6.bar" content="foo ">
		<meta  content=\' foo\' name = bar7.bar >
	'));
});
