<?php

namespace Modules\Donasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDonasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()
            && $this->user()->role === 'admin';
    }


    public function rules(): array
    {
        $id = $this->route('id');


        return [

            'kode' => [
                'required',
                'string',
                'max:50',

                /*
                 * Kode harus unik,
                 * tetapi record sendiri diabaikan.
                 */
                Rule::unique(
                    'donasis',
                    'kode'
                )->ignore($id),
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


            'jumlah_porsi' => [
                'required',
                'integer',
                'min:1',
            ],


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
                'Kode katalog sudah digunakan katalog lain.',


            'nama.required' =>
                'Nama katalog wajib diisi.',


            'jumlah_porsi.required' =>
                'Batas porsi wajib diisi.',

            'jumlah_porsi.integer' =>
                'Batas porsi harus berupa angka bulat.',

            'jumlah_porsi.min' =>
                'Batas porsi minimal 1.',


            'lokasi_pengambilan.required' =>
                'Lokasi pengambilan wajib diisi.',


            'status.required' =>
                'Status wajib dipilih.',

            'status.in' =>
                'Status katalog tidak valid.',

        ];
    }
}