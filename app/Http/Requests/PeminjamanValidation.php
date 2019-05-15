<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeminjamanValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'goods_id' => 'required',
          'jumlah' => 'required | numeric',
          'tanggal_pinjam' => 'required | before:tanggal_kembali',
          'tanggal_kembali' => 'required | after:tanggal_pinjam',
        ];
    }
}
