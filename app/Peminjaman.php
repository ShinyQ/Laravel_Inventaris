<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Goods;
use App\Categories;
use App\Shelfs;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['user_id','goods_id','jumlah','tanggal_pinjam','tanggal_kembali', 'status'];

    public function goods()
    {
    	return $this->hasOne(Goods::class, "id","goods_id");
    }

    public function users()
    {
    	return $this->hasOne(User::class, "id","user_id");
    }
}
