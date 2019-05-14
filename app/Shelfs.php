<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Goods;

class Shelfs extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['nomor','kode'];

    function goods(){
      return $this->hasMany(Goods::class, 'shelfs_id', 'id');
    }
}
