<?php

namespace Modules\Pengajuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Pengajuan\Models\Pengajuan;

class KeputusanPengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pengajuan = Pengajuan::find(
            $this->route('id')
        );


        if (!$this->user()) {
            return false;
        }


        /*
         * Harus admin.
         */
        if ($this->user()->role !== 'admin') {
            return false;
        }


        /*
         * Transaksi harus ada.
         */
        if (!$pengajuan) {
            return false;
        }


        /*
         * Hanya transaksi Menunggu
         * yang boleh mendapatkan keputusan.
         *
         * Artinya keputusan FINAL hanya sekali.
         */
        return $pengajuan->status === 'Menunggu';
    }


    public function rules(): array
    {
        /*
         * Keputusan sebenarnya berasal
         * dari endpoint approve/reject,
         * jadi tidak membutuhkan input user.
         */

        return [];
    }
}