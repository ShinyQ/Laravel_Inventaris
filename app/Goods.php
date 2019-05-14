<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Goods;
use App\Categories;
use App\Shelfs;

class Goods extends Model
{
    use SoftDeletes;
    protected $table = 'goods';
    public $timestamps = true;
    protected $fillable = ['name','categories_id','shelfs_id','stock','status','foto'];

    public function categories()
    {
    	return $this->hasOne(Categories::class, "id","categories_id")->withTrashed();
    }

    public function shelfs()
    {
    	return $this->hasOne(Shelfs::class, "id","shelfs_id")->withTrashed();
    }
}
