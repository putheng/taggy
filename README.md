Installation
------------

Require this package with composer. It is recommended to only require the package for development.
```
composer require putheng/taggy
```

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Setting up from scratch

#### Laravel 5.5+:
If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php
```php
Putheng\Taggy\TaggyServiceProvider::class,
```

#### The schema
For Laravel 5 migration
```php
php artisan migrate
```

#### The model
Your model should use `Putheng\Taggy\TaggableTrait` trait to enable tags:
```php
use Putheng\Taggy\TaggableTrait;

class Lession extends Model {
    use TaggableTrait;
}
```

## Usage
Seed your tags table
```php
use Putheng\Taggy\Models\Tag;

public function store(){
	foreach(['PHP', 'Laravel', 'Testing', 'Redis', 'Postgresql', 'Fun stuff'] as $tag){
		\Tag::create([
			'name' => $tag,
			'slug' => str_slug($tag),
			'count' => 0,
		]);
	}
}
```