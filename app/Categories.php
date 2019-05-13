<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categories;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['name'];
}
