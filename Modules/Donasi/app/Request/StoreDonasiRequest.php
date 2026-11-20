<?php

namespace Modules\Donasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()
            && $this->user()->role === 'admin';
    }


    public function rules(): array
    {
        return [

            'kode' => [
                'required',
                'string',
                'max:50',
                'unique:donasis,kode',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
                'max:1000',
            ],

            /*
             * Di project kita field katalog masih
             * bernama jumlah_porsi.
             *
             * Ini berfungsi sebagai batas_porsi.
             */
            'jumlah_porsi' => [
                'required',
                'integer',
                'min:1',
            ],

            /*
             * Di project kita field lokasi
             * bernama lokasi_pengambilan.
             */
            'lokasi_pengambilan' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:Tersedia,Tidak Tersedia',
            ],
        ];
    }


    public function messages(): array
    {
        return [

            'kode.required' =>
                'Kode katalog wajib diisi.',

            'kode.unique' =>
                'Kode katalog sudah digunakan.',

            'kode.max' =>
                'Kode maksimal 50 karakter.',


            'nama.required' =>
                'Nama katalog wajib diisi.',

            'nama.max' =>
                'Nama maksimal 255 karakter.',


            'jumlah_porsi.required' =>
                'Batas porsi wajib diisi.',

            'jumlah_porsi.integer' =>
                'Batas porsi harus berupa angka bulat.',

            'jumlah_porsi.min' =>
                'Batas porsi minimal 1.',


            'lokasi_pengambilan.required' =>
                'Lokasi pengambilan wajib diisi.',


            'status.required' =>
                'Status katalog wajib dipilih.',

            'status.in' =>
                'Status katalog tidak valid.',

        ];
    }


    public function attributes(): array
    {
        return [
            'jumlah_porsi' =>
                'batas porsi',

            'lokasi_pengambilan' =>
                'lokasi pengambilan',
        ];
    }
}