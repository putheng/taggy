<?php

class TaggyModelUsageTest extends TestCase
{
	protected $lession;

	public function setUp()
	{
		parent::setUp();

		foreach(['PHP', 'Laravel', 'Testing', 'Redis', 'Postgres', 'Fun stuff'] as $tag){
			\TagStub::create([
				'name' => $tag,
				'slug' => str_slug($tag),
				'count' => 0,
			]);
		}

		$this->lession = \LessionStub::create([
			'title' => 'A lession title',
		]);
	}

	/** @test */
	public function can_tag_lession()
	{
		$this->lession->tag(\TagStub::where('slug', 'laravel')->first());

		$this->assertCount(1, $this->lession->tags);
		$this->assertContains('Laravel', $this->lession->tags->pluck('name'));
	}

	/** @test */
	public function can_tag_lession_with_collection_of_tags()
	{
		$tags = \TagStub::whereIn('slug', ['laravel', 'php', 'redis'])->get();

		$this->lession->tag($tags);

		$this->assertCount(3, $this->lession->tags);

		foreach (['Laravel', 'PHP', 'Redis'] as $tag) {
			$this->assertContains($tag, $this->lession->tags->pluck('name'));
		}
	}

	/** @test */
	public function can_untag_lession_tags()
	{
		$tags = \TagStub::whereIn('slug', ['laravel', 'php', 'redis'])->get();

		$this->lession->tag($tags);

		// Using Laravel
		$this->lession->untag($tags->first());

		$this->assertCount(2, $this->lession->tags);

		foreach (['PHP', 'Redis'] as $tag) {
			$this->assertContains($tag, $this->lession->tags->pluck('name'));
		}
	}

	/** @test */
	public function can_untag_all_lession_tags()
	{
		$tags = \TagStub::whereIn('slug', ['laravel', 'php', 'redis'])->get();

		$this->lession->tag($tags);
		$this->lession->untag();

		$this->lession->load('tags');

		$this->assertCount(0, $this->lession->tags);
	}

	/** @test */
	public function can_retag_lession_tags()
	{
		$tags = \TagStub::whereIn('slug', ['laravel', 'php', 'redis'])->get();
		$toRetag = \TagStub::whereIn('slug', ['laravel', 'postgres', 'redis'])->get();

		$this->lession->tag($tags);
		$this->lession->retag($toRetag);

		$this->lession->load('tags');

		$this->assertCount(3, $this->lession->tags);

		foreach (['Laravel', 'Postgres', 'Redis'] as $tag) {
			$this->assertContains($tag, $this->lession->tags->pluck('name'));
		}
	}

	/** @test */
	public function non_models_are_filtered_when_using_collection()
	{
		$tags = \TagStub::whereIn('slug', ['laravel', 'php', 'testing'])->get();
		$tags->push('not a tag model');

		$this->lession->tag($tags);
		
		$this->assertCount(3, $this->lession->tags);
	}

}