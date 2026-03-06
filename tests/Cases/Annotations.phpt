<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Annotations;
use Contributte\Utils\Exception\LogicalException;
use Tester\Assert;
use Tests\Fixtures\AnnotationCoverageFixture;
use Tests\Fixtures\AnnotationFoo;

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../Fixtures/AnnotationCoverageFixture.php';

// Class
Toolkit::test(function (): void {
	$r = new ReflectionClass(AnnotationFoo::class);
	$annotations = Annotations::getAnnotations($r);

	Assert::count(2, $annotations);
	Assert::equal(['DG'], $annotations['creator']);
	Assert::equal([true], $annotations['test']);

	Assert::equal('DG', Annotations::getAnnotation($r, 'creator'));
	Assert::equal(true, Annotations::getAnnotation($r, 'test'));
	Assert::equal(null, Annotations::getAnnotation($r, 'fake'));

	Assert::equal(true, Annotations::hasAnnotation($r, 'test'));
	Assert::equal(false, Annotations::hasAnnotation($r, 'test2'));
});

// Method
Toolkit::test(function (): void {
	$r = new ReflectionMethod(AnnotationFoo::class, 'fake');
	$annotations = Annotations::getAnnotations($r);

	Assert::count(2, $annotations);
	Assert::equal(['Felix'], $annotations['creator']);
	Assert::equal([false, true], iterator_to_array($annotations['test'][0]));

	Assert::equal('Felix', Annotations::getAnnotation($r, 'creator'));
	Assert::equal([false, true], iterator_to_array(Annotations::getAnnotation($r, 'test')));
	Assert::equal(null, Annotations::getAnnotation($r, 'fake'));

	Assert::equal(true, Annotations::hasAnnotation($r, 'test'));
	Assert::equal(false, Annotations::hasAnnotation($r, 'test2'));
});

// Coverage branch: class description and scalar parsing
Toolkit::test(function (): void {
	$r = new ReflectionClass(AnnotationCoverageFixture::class);
	$annotations = Annotations::getAnnotations($r);

	Assert::same('Coverage fixture description', $annotations['description'][0]);
	Assert::same(123, $annotations['number'][0]);
	Assert::same([
		'name' => 'demo',
		'count' => 10,
		'enabled' => true,
	], iterator_to_array($annotations['options'][0]));
});

// Coverage branch: ReflectionFunction
Toolkit::test(function (): void {
	$r = new ReflectionFunction('Tests\\Fixtures\\annotationCoverageFunction');

	set_error_handler(static fn (int $severity, string $message): bool => $severity === E_DEPRECATED
		&& str_contains($message, 'Using null as an array offset is deprecated'));

	try {
		Assert::same('Function fixture description', Annotations::getAnnotation($r, 'description'));
		Assert::same([
			'name' => 'function',
		], iterator_to_array(Annotations::getAnnotation($r, 'options')));
	} finally {
		restore_error_handler();
	}
});

// Coverage branch: ReflectionProperty
Toolkit::test(function (): void {
	$r = new ReflectionProperty(AnnotationCoverageFixture::class, 'property');

	Assert::same([
		'name' => 'property',
	], iterator_to_array(Annotations::getAnnotation($r, 'options')));
});

// Coverage branch: empty annotations
Toolkit::test(function (): void {
	$r = new ReflectionMethod(AnnotationCoverageFixture::class, 'withoutDoc');

	Assert::null(Annotations::getAnnotation($r, 'anything'));
});

// Coverage branch: parseComment split failure
Toolkit::test(function (): void {
	$parseComment = new ReflectionMethod(Annotations::class, 'parseComment');

	$backtrackLimit = ini_get('pcre.backtrack_limit');
	ini_set('pcre.backtrack_limit', '1');

	try {
		Assert::exception(
			static fn () => $parseComment->invoke(null, str_repeat('@annotation ', 1000)),
			LogicalException::class,
			'Cannot split comment'
		);
	} finally {
		if ($backtrackLimit !== false) {
			ini_set('pcre.backtrack_limit', $backtrackLimit);
		}
	}
});
