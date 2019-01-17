<?php

use Putheng\Taggy\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class LessionStub extends Model
{
    use TaggableTrait;

    protected $connection = 'testbench';

    protected $table = 'lessions';
}
