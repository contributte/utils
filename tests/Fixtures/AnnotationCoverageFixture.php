<?php declare(strict_types = 1);

namespace Tests\Fixtures;

/**
 * Coverage fixture description
 *
 * @number 123
 * @options(name='demo', count=10, enabled=true)
 */
class AnnotationCoverageFixture
{

	/** @options(name='property') */
	public string $property = 'value';

	public function withoutDoc(): void
	{
		// Intentionally empty.
	}

}

/**
 * Function fixture description
 *
 * @options(name='function')
 */
function annotationCoverageFunction(): void
{
	// Intentionally empty.
}
