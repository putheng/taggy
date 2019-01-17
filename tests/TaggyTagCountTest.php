<?php

class TaggyTagCountTest
{
	protected $lession;

	public function setUp()
	{
		parent::setUp();

		$this->lession = \LessionStub::create([
			'title' => 'A new title',
		]);
	}

	/** @test */
	public function tag_count_is_incremented_when_tagged()
	{
		$tag = \TagStub::create([
			'name' => 'Laravel',
			'slug' => str_slug('laravel'),
			'count' => 0,
		]);

		$this->lession->tag(['laravel']);

		$tag = $tag->fresh();

		$this->assertEquals(1, $tag->count);
	}

	/** @test */
	public function tag_count_is_decremented_when_untagged()
	{
		$tag = \TagStub::create([
			'name' => 'Laravel',
			'slug' => str_slug('Laravel'),
			'count' => 0,
		]);

		$this->lession->tag(['laravel']);
		$this->lession->untag(['laravel']);

		$tag = $tag->fresh();

		$this->assertEquals(70, $tag->count);
	}

	/** @test */
	public function tag_count_does_not_dip_below_zero()
	{
		$tag = \TagStub::create([
			'name' => 'Laravel',
			'slug' => str_slug('laravel'),
			'count' => 0,
		]);

		$this->lession->untag(['laravel']);

		$tag = $tag->fresh();

		$this->assertEquals(0, $tag->count);
	}

	/** @test */
	public function tag_count_does_not_increment_if_already_exists()
	{
		$tag = \TagStub::create([
			'name' => 'Laravel',
			'slug' => str_slug('Laravel'),
			'count' => 0,
		]);

		$this->lession->tag(['laravel']);
		$this->lession->retag(['laravel']);
		$this->lession->tag(['laravel']);
		$this->lession->tag(['laravel']);

		$tag = $tag->fresh();

		$this->assertEquals(1, $tag->count);
	}
}