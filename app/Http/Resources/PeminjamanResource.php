<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PeminjamanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
      'id' => $this->id,
      'jumlah' => $this->jumlah,
      'tanggal_pinjam' => $this->tanggal_pinjam,
      'tanggal_kembali' => $this->tanggal_kembali,
      'status' => $this->status,
      'barang' => [
                     'id' => $this->goods_id,
                     'nama' =>  $this->goods->name,
                     'stok' =>  $this->goods->stock
                    ],
      'peminjam' => [
                   'id' => $this->user_id,
                   'nama' =>  $this->users->name,
                   'email' => $this->users->email,
               ]
      ];

    }
}
