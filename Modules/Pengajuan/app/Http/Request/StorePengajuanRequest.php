<?php

namespace Modules\Pengajuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Modules\Donasi\Models\Donasi;

class StorePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()
            && $this->user()->role === 'pemohon';
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


            /*
             * Project kita menggunakan catatan.
             * Field ini dipakai sebagai keperluan.
             */
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


    /*
    |--------------------------------------------------------------------------
    | VALIDASI LINTAS FIELD
    |--------------------------------------------------------------------------
    |
    | Periksa nilai Pengajuan terhadap
    | katalog yang dipilih.
    |
    */

    public function after(): array
    {
        return [

            function (Validator $validator) {

                /*
                 * Jangan lanjut kalau ID katalog
                 * belum valid.
                 */

                if (!$this->donasi_id) {
                    return;
                }


                $donasi = Donasi::find(
                    $this->donasi_id
                );


                if (!$donasi) {
                    return;
                }


                /*
                 * KATALOG HARUS TERSEDIA
                 */

                if ($donasi->status !== 'Tersedia') {

                    $validator
                        ->errors()
                        ->add(
                            'donasi_id',
                            'Katalog yang dipilih sudah tidak tersedia.'
                        );
                }


                /*
                 * JUMLAH PORSI TIDAK BOLEH
                 * MELEBIHI BATAS KATALOG
                 */

                if (
                    $this->jumlah_porsi
                    &&
                    (int) $this->jumlah_porsi
                        > (int) $donasi->jumlah_porsi
                ) {

                    $validator
                        ->errors()
                        ->add(
                            'jumlah_porsi',
                            'Jumlah porsi tidak boleh melebihi batas porsi katalog yaitu '
                            . $donasi->jumlah_porsi
                            . ' porsi.'
                        );
                }


                /*
                 * Kalau tabel donasis kamu SUDAH
                 * mempunyai tanggal_bagi,
                 * aktifkan bagian berikut.
                 */

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
                'Katalog yang dipilih tidak ditemukan.',


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

            'catatan.max' =>
                'Keperluan maksimal 1000 karakter.',


            'foto_bukti.image' =>
                'Bukti harus berupa gambar.',

            'foto_bukti.mimes' =>
                'Bukti hanya boleh berupa JPG, JPEG, atau PNG.',

            'foto_bukti.max' =>
                'Ukuran bukti maksimal 2 MB.',

        ];
    }
}