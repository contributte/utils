<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Http;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// Http::metadata
Toolkit::test(function (): void {
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

Toolkit::test(function (): void {
	Assert::exception(function (): void {
		Http::metadata('plain text without html meta tags');
	}, LogicException::class, 'Matches count is not equal.');
});

Toolkit::test(function (): void {
	$backtrackLimit = ini_get('pcre.backtrack_limit');
	ini_set('pcre.backtrack_limit', '1');

	try {
		Assert::same([], Http::metadata(str_repeat('<meta name="foo" content="bar">', 2000)));
	} finally {
		if ($backtrackLimit !== false) {
			ini_set('pcre.backtrack_limit', $backtrackLimit);
		}
	}
});
