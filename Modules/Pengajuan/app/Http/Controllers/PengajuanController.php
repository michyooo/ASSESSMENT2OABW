<?php

namespace Modules\Pengajuan\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Modules\Donasi\Models\Donasi;
use Modules\Pengajuan\Models\Pengajuan;

use Modules\Pengajuan\Http\Requests\StorePengajuanRequest;
use Modules\Pengajuan\Http\Requests\UpdatePengajuanRequest;
use Modules\Pengajuan\Http\Requests\KeputusanPengajuanRequest;

class PengajuanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    |
    | Admin:
    | - Melihat seluruh transaksi
    |
    | Pemohon:
    | - Hanya melihat transaksi miliknya sendiri
    |
    */

    public function index(Request $request)
    {
        $user = $request->user();


        if ($user->role === 'admin') {

            $pengajuans = Pengajuan::with([
                'user',
                'donasi'
            ])
            ->latest()
            ->get();

        } else {

            $pengajuans = Pengajuan::with([
                'donasi'
            ])
            ->where(
                'user_id',
                $user->id
            )
            ->latest()
            ->get();
        }


        return view(
            'pengajuan::index',
            compact('pengajuans')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    |
    | Hanya Pemohon.
    | Pilihan katalog diambil dari database.
    |
    */

    public function create(Request $request)
    {
        if ($request->user()->role !== 'pemohon') {

            abort(
                403,
                'Hanya pemohon yang dapat membuat pengajuan.'
            );
        }


        $donasis = Donasi::where(
            'status',
            'Tersedia'
        )
        ->orderBy('nama')
        ->get();


        return view(
            'pengajuan::create',
            compact('donasis')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    |
    | Validasi dilakukan melalui:
    |
    | StorePengajuanRequest
    |
    | user_id dan status TIDAK boleh berasal
    | dari input pengguna.
    |
    */

    public function store(
        StorePengajuanRequest $request
    ) {
        /*
         * Ambil hanya data yang sudah lolos validasi.
         */
        $validated = $request->validated();


        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO
        |--------------------------------------------------------------------------
        */

        $fotoPath = null;


        if ($request->hasFile('foto_bukti')) {

            $fotoPath = $request
                ->file('foto_bukti')
                ->store(
                    'bukti-pengajuan',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | user_id dari session login.
        | status selalu Menunggu dari server.
        |
        */

        $pengajuan = Pengajuan::create([

            'user_id' =>
                $request->user()->id,

            'donasi_id' =>
                $validated['donasi_id'],

            'jumlah_porsi' =>
                $validated['jumlah_porsi'],

            'tanggal_ambil' =>
                $validated['tanggal_ambil'],

            'catatan' =>
                $validated['catatan'],

            'foto_bukti' =>
                $fotoPath,

            'status' =>
                'Menunggu',

        ]);


        /*
         * Load relasi supaya response AJAX
         * mempunyai data user dan katalog.
         */

        $pengajuan->load([
            'user',
            'donasi'
        ]);


        return response()->json([

            'message' =>
                'Pengajuan berhasil disimpan.',

            'data' =>
                $pengajuan,

            'foto_url' =>
                $pengajuan->foto_bukti
                    ? Storage::url(
                        $pengajuan->foto_bukti
                    )
                    : null,

        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW / DETAIL
    |--------------------------------------------------------------------------
    |
    | Admin:
    | - Semua transaksi
    |
    | Pemohon:
    | - Hanya miliknya
    |
    */

    public function show(
        Request $request,
        $id
    ) {
        $pengajuan = Pengajuan::with([
            'user',
            'donasi'
        ])
        ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | CEK KEPEMILIKAN
        |--------------------------------------------------------------------------
        */

        if (
            $request->user()->role !== 'admin'
            &&
            $pengajuan->user_id
                !== $request->user()->id
        ) {

            abort(
                403,
                'Anda tidak memiliki akses ke transaksi ini.'
            );
        }


        /*
         * Jika dipanggil melalui AJAX.
         */

        if ($request->expectsJson()) {

            return response()->json([

                'data' =>
                    $pengajuan,

                'foto_url' =>
                    $pengajuan->foto_bukti
                        ? Storage::url(
                            $pengajuan->foto_bukti
                        )
                        : null,

            ]);
        }


        /*
         * Jika dibuka melalui browser biasa.
         */

        return view(
            'pengajuan::show',
            compact('pengajuan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    |
    | Hanya:
    |
    | - Pemohon
    | - Pemilik transaksi
    | - Status masih Menunggu
    |
    */

    public function edit(
        Request $request,
        $id
    ) {
        $pengajuan =
            Pengajuan::findOrFail($id);


        /*
         * Harus Pemohon.
         */

        if (
            $request->user()->role
            !== 'pemohon'
        ) {

            abort(
                403,
                'Admin tidak dapat mengubah isi transaksi.'
            );
        }


        /*
         * Harus pemilik transaksi.
         */

        if (
            $pengajuan->user_id
            !== $request->user()->id
        ) {

            abort(
                403,
                'Transaksi bukan milik Anda.'
            );
        }


        /*
         * Hanya transaksi Menunggu
         * yang bisa diedit.
         */

        if (
            $pengajuan->status
            !== 'Menunggu'
        ) {

            abort(
                403,
                'Transaksi yang sudah diproses tidak dapat diubah.'
            );
        }


        /*
         * Ambil katalog.
         */

        $donasis = Donasi::orderBy(
            'nama'
        )->get();


        return view(
            'pengajuan::edit',
            compact(
                'pengajuan',
                'donasis'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    |
    | Authorization + validation utama dilakukan
    | oleh UpdatePengajuanRequest.
    |
    */

    public function update(
        UpdatePengajuanRequest $request,
        $id
    ) {
        $pengajuan =
            Pengajuan::findOrFail($id);


        /*
         * Semua data di sini sudah lolos validasi.
         */

        $validated =
            $request->validated();


        /*
        |--------------------------------------------------------------------------
        | FOTO LAMA
        |--------------------------------------------------------------------------
        |
        | Jika pengguna tidak upload foto baru,
        | foto lama dipertahankan.
        |
        */

        $fotoPath =
            $pengajuan->foto_bukti;


        /*
        |--------------------------------------------------------------------------
        | FOTO BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_bukti')) {

            /*
             * Simpan foto baru terlebih dahulu.
             */

            $fotoBaru = $request
                ->file('foto_bukti')
                ->store(
                    'bukti-pengajuan',
                    'public'
                );


            /*
             * Baru hapus foto lama.
             */

            if (
                $pengajuan->foto_bukti
                &&
                Storage::disk('public')->exists(
                    $pengajuan->foto_bukti
                )
            ) {

                Storage::disk(
                    'public'
                )->delete(
                    $pengajuan->foto_bukti
                );
            }


            $fotoPath =
                $fotoBaru;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | user_id tidak diubah.
        | status tidak diambil dari request.
        |
        */

        $pengajuan->update([

            'donasi_id' =>
                $validated['donasi_id'],

            'jumlah_porsi' =>
                $validated['jumlah_porsi'],

            'tanggal_ambil' =>
                $validated['tanggal_ambil'],

            'catatan' =>
                $validated['catatan'],

            'foto_bukti' =>
                $fotoPath,

        ]);


        $pengajuan->load([
            'user',
            'donasi'
        ]);


        return response()->json([

            'message' =>
                'Pengajuan berhasil diperbarui.',

            'data' =>
                $pengajuan,

            'foto_url' =>
                $pengajuan->foto_bukti
                    ? Storage::url(
                        $pengajuan->foto_bukti
                    )
                    : null,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    |
    | Admin:
    | - Boleh menghapus semua transaksi
    |
    | Pemohon:
    | - Hanya transaksi sendiri
    | - Hanya status Menunggu
    |
    */

    public function destroy(
        Request $request,
        $id
    ) {
        $pengajuan =
            Pengajuan::findOrFail($id);


        $user =
            $request->user();


        /*
        |--------------------------------------------------------------------------
        | JIKA BUKAN ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'admin') {

            /*
             * Pemohon hanya boleh menghapus
             * transaksi sendiri.
             */

            if (
                $pengajuan->user_id
                !== $user->id
            ) {

                abort(
                    403,
                    'Anda tidak dapat menghapus transaksi milik pengguna lain.'
                );
            }


            /*
             * Transaksi harus masih Menunggu.
             */

            if (
                $pengajuan->status
                !== 'Menunggu'
            ) {

                abort(
                    403,
                    'Transaksi yang sudah diproses tidak dapat dihapus.'
                );
            }
        }


        /*
         * Simpan path foto sebelum transaksi dihapus.
         */

        $fotoPath =
            $pengajuan->foto_bukti;


        /*
         * Hapus transaksi dari database.
         */

        $pengajuan->delete();


        /*
         * Hapus foto dari public storage
         * karena tidak digunakan lagi.
         */

        if (
            $fotoPath
            &&
            Storage::disk(
                'public'
            )->exists(
                $fotoPath
            )
        ) {

            Storage::disk(
                'public'
            )->delete(
                $fotoPath
            );
        }


        return response()->json([

            'message' =>
                'Pengajuan berhasil dihapus.'

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    |
    | Keputusan hanya Admin.
    |
    | KeputusanPengajuanRequest memastikan:
    |
    | - User adalah Admin
    | - Transaksi masih Menunggu
    |
    */

    public function approve(
        KeputusanPengajuanRequest $request,
        $id
    ) {
        $pengajuan =
            Pengajuan::findOrFail($id);


        /*
         * Tidak ada perubahan isi transaksi.
         * Admin hanya menetapkan keputusan.
         */

        $pengajuan->update([

            'status' =>
                'Disetujui'

        ]);


        return response()->json([

            'message' =>
                'Pengajuan berhasil disetujui.',

            'status' =>
                'Disetujui',

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(
        KeputusanPengajuanRequest $request,
        $id
    ) {
        $pengajuan =
            Pengajuan::findOrFail($id);


        $pengajuan->update([

            'status' =>
                'Ditolak'

        ]);


        return response()->json([

            'message' =>
                'Pengajuan berhasil ditolak.',

            'status' =>
                'Ditolak',

        ]);
    }
}