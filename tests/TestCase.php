<?php

use Putheng\Taggy\TaggyServiceProvider;
use Orchestra\Database\ConsoleServiceProvider;

abstract class TestCase extends Orchestra\Testbench\TestCase
{
	protected function getPackageProviders($app)
	{
		return [
			TaggyServiceProvider::class
		];
	}

	public function setup()
	{
		parent::setUp();

		Eloquent::unguard();

		$this->artisan('migrate', [
			'--database' => 'testbench',
			'--realpath' => realpath(__DIR__ . '/../migrations'),
		]);
	}

	public function teardown()
	{
		\Schema::drop('lessions');
	}

	protected function getEnvironmentSetup($app)
	{
		$app['config']->set('database.default', 'testbench');

		$app['config']->set('database.connections.testbench', [
			'driver' => 'sqlite',
			'database' => ':memory:',
			'prefix' => '',
		]);

		\Schema::create('lessions', function($table){
			$table->increments('id');
			$table->string('title');
			$table->timestamps();
		});
	}
}