<?php

use Illuminate\Database\Eloquent\Model;
use Putheng\Taggy\Scopes\TagUsedScopesTrait;

class TagStub extends Model
{
    use TagUsedScopesTrait;

    protected $connection = 'testbench';

    protected $table = 'tags';
}
