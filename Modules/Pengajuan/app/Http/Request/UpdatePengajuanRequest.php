<?php

namespace Modules\Pengajuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Modules\Donasi\Models\Donasi;
use Modules\Pengajuan\Models\Pengajuan;

class UpdatePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pengajuan = Pengajuan::find(
            $this->route('id')
        );


        if (!$pengajuan) {
            return false;
        }


        return $this->user()
            && $this->user()->role === 'pemohon'
            && $pengajuan->user_id === $this->user()->id
            && $pengajuan->status === 'Menunggu';
    }


    public function rules(): array
    {
        return [

            'donasi_id' => [
                'required',
                'integer',
                'exists:donasis,id',
            ],


            'jumlah_porsi' => [
                'required',
                'integer',
                'min:1',
            ],


            'tanggal_ambil' => [
                'required',
                'date',
            ],


            'catatan' => [
                'required',
                'string',
                'max:1000',
            ],


            'foto_bukti' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

        ];
    }


    public function after(): array
    {
        return [

            function (Validator $validator) {

                $donasi = Donasi::find(
                    $this->donasi_id
                );


                if (!$donasi) {
                    return;
                }


                if (
                    (int) $this->jumlah_porsi
                    > (int) $donasi->jumlah_porsi
                ) {

                    $validator
                        ->errors()
                        ->add(
                            'jumlah_porsi',
                            'Jumlah porsi melebihi batas katalog yaitu '
                            . $donasi->jumlah_porsi
                            . ' porsi.'
                        );
                }


                if (
                    isset($donasi->tanggal_bagi)
                    &&
                    $donasi->tanggal_bagi
                    &&
                    $this->tanggal_ambil
                    &&
                    $this->tanggal_ambil
                        !== $donasi->tanggal_bagi
                ) {

                    $validator
                        ->errors()
                        ->add(
                            'tanggal_ambil',
                            'Tanggal pengambilan harus sama dengan tanggal bagi katalog.'
                        );
                }

            },

        ];
    }


    public function messages(): array
    {
        return [

            'donasi_id.required' =>
                'Katalog wajib dipilih.',

            'donasi_id.exists' =>
                'Katalog tidak ditemukan.',


            'jumlah_porsi.required' =>
                'Jumlah porsi wajib diisi.',

            'jumlah_porsi.integer' =>
                'Jumlah porsi harus berupa angka bulat.',

            'jumlah_porsi.min' =>
                'Jumlah porsi minimal 1.',


            'tanggal_ambil.required' =>
                'Tanggal pengambilan wajib diisi.',

            'tanggal_ambil.date' =>
                'Tanggal pengambilan tidak valid.',


            'catatan.required' =>
                'Keperluan wajib diisi.',


            'foto_bukti.image' =>
                'Bukti harus berupa gambar.',

            'foto_bukti.mimes' =>
                'Format bukti harus JPG, JPEG, atau PNG.',

            'foto_bukti.max' =>
                'Ukuran bukti maksimal 2 MB.',
        ];
    }
}