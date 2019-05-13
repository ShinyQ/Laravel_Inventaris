<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsResource extends JsonResource
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
      'name' => $this->name,
      // 'gambar' => "http://localhost:2002/images/$this->image",
      'stock' => $this->stock,
      'kategori' => [
                     'id' => $this->categories_id,
                     'nama' =>  $this->categories->name
                    ],
      'rak' => [
                   'id' => $this->shelfs_id,
                   'nomor' =>  $this->shelfs->nomor,
                   'kode' => $this->shelfs->kode,
               ]
      ];

    }
}
