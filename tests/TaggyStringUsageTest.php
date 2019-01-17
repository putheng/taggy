<?php

class TaggyStringUsageTest extends TestCase
{
	protected $lession;

	public function setUp()
	{
		parent::setUp();

		foreach(['PHP', 'Laravel', 'Testing', 'Redis', 'Postgresql', 'Fun stuff'] as $tag){
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
	public function can_tag_a_lession()
	{
		$this->lession->tag(['laravel', 'php']);

		$this->assertCount(2, $this->lession->tags);

		foreach(['Laravel', 'PHP'] as $tag){
			$this->assertContains($tag, $this->lession->tags->pluck('name'));
		}
	}

	/** @test */
	public function can_untag_a_lession()
	{
		$this->lession->tag(['laravel', 'php', 'testing']);
		$this->lession->untag(['laravel']);

		$this->assertCount(2, $this->lession->tags);

		foreach(['PHP', 'Testing'] as $tag){
			$this->assertContains($tag, $this->lession->tags->pluck('name'));
		}
	}

	/** @test */
	public function can_untag_all_lession_tags()
	{
		$this->lession->tag(['Laravel', 'php', 'testing']);
		$this->lession->untag();

		$this->lession->load('tags');

		$this->assertCount(0, $this->lession->tags);
		$this->assertEquals(0, $this->lession->tags->count());
	}

	/** @test */
	public function can_retag_lession_tags()
	{
		$this->lession->tag(['Laravel', 'php', 'testing']);
		$this->lession->retag(['Laravel', 'postgresql', 'redis']);

		$this->lession->load('tags');

		$this->assertCount(3, $this->lession->tags);

		foreach(['Laravel', 'Postgresql', 'Redis'] as $tag){
			$this->assertContains($tag, $this->lession->tags->pluck('name'));
		}
	}

	/** @test*/
	public function non_existing_tags_are_ignored_on_tagging()
	{
		$this->lession->tag(['Laravel', 'c++', 'redis']);

		$this->assertCount(2, $this->lession->tags);

		foreach(['Laravel', 'Redis'] as $tag){
			$this->assertContains($tag, $this->lession->tags->pluck('name'));
		}
	}

	/** @test*/
	public function inconsistent_tag_cases_are_normalised()
	{
		$this->lession->tag(['Laravel', 'REDis', 'TeStIng', 'Fun stuff']);

		$this->assertCount(4, $this->lession->tags);

		foreach(['Laravel', 'Redis', 'Testing', 'Fun stuff'] as $tag){
			$this->assertContains($tag, $this->lession->tags->pluck('name'));
		}
	}
}