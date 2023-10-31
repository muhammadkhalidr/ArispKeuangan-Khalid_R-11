<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'txtnama' => 'required',
            'txtbarang' => 'required',
            'txtharga' => 'required|numeric',
            'txtjumlah' => 'required|numeric',
            'txttotal' => 'required|numeric',
            'txtket' => 'required',
            'txtdp' => 'required|numeric',
            'txtsisa' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'txtnama.required'            => ':attribute Tidak Boleh Kosong',
            'txtbarang.required'            => ':attribute Tidak Boleh Kosong',
            'txtharga.required'            => ':attribute Tidak Boleh Kosong',
            'txtjumlah.required'            => ':attribute Tidak Boleh Kosong',
            'txttotal.required'            => ':attribute Tidak Boleh Kosong',
            'txtket.required'            => ':attribute Tidak Boleh Kosong',
            'txtdp.required'            => ':attribute Tidak Boleh Kosong',
            'txtsisa.required'            => ':attribute Tidak Boleh Kosong',
        ];
    }

    public function attributes(): array
    {
        return [
            'txtnama' => 'Nama',
            'txtbarang' => 'Barang',
            'txtharga' => 'Harga',
            'txtjumlah' => 'Jumlah',
            'txttotal' => 'Total Harga',
            'txtket' => 'Keterangan',
            'txtdp' => 'Uang Muka',
            'txtsisa' => 'Sisa',
        ];
    }
}
