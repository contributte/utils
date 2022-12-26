<?php declare(strict_types = 1);

require_once __DIR__ . '/../bootstrap.php';

use Contributte\Utils\Annotations;
use Tester\Assert;
use Tests\Fixtures\AnnotationFoo;

// Class
test(function (): void {
	$annotations = Annotations::getAll(new ReflectionClass(AnnotationFoo::class));

	Assert::count(2, $annotations);
	Assert::equal(['DG'], $annotations['creator']);
	Assert::equal([true], $annotations['test']);
});

// Method
test(function (): void {
	$annotations = Annotations::getAll(new ReflectionMethod(AnnotationFoo::class, 'fake'));

	Assert::count(2, $annotations);
	Assert::equal(['Felix'], $annotations['creator']);
	Assert::equal([false], $annotations['test']);
});
