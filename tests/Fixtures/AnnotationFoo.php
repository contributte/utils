<?php declare(strict_types = 1);

namespace Tests\Fixtures;

/**
 * @creator DG
 * @test(true)
 */
class AnnotationFoo
{

	/**
	 * @creator Felix
	 * @test(false, true)
	 */
	public function fake(): bool
	{
		return true;
	}

}
