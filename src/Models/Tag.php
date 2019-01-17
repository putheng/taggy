<?php

namespace Putheng\Taggy\Models;

use Illuminate\Database\Eloquent\Model;
use Putheng\Taggy\Scopes\TagUsedScopesTrait;

class Tag extends Model
{
    use TagUsedScopesTrait;

    protected $fillable = [
    	'name',
    	'slug'
    ];
}
