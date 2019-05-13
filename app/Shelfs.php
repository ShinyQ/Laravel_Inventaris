<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelfs extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['nomor','kode'];
}
