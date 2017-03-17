<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = 'Domain';

    protected $fillable = ['name','ip','active','token'];
}
