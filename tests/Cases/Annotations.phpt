<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Annotations;
use Tester\Assert;
use Tests\Fixtures\AnnotationFoo;

require_once __DIR__ . '/../bootstrap.php';

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
