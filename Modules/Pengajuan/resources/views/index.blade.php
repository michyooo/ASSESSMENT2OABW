@extends('layouts.app')

@section('title', 'Pengajuan - FoodShare')

@section('content')

{{-- =========================================================
     HEADER
========================================================= --}}

<div class="page-header">

    <div>
        <h1>Daftar Pengajuan</h1>

        @if (auth()->user()->role === 'admin')

            <p>
                Kelola seluruh transaksi pengajuan FoodShare.
            </p>

        @else

            <p>
                Kelola dan pantau pengajuan makanan Anda.
            </p>

        @endif
    </div>


    {{-- Hanya PEMOHON boleh membuat pengajuan --}}
    @if (auth()->user()->role === 'pemohon')

        <a
            href="{{ route('pengajuan.create') }}"
            class="btn btn-primary"
        >
            + Buat Pengajuan
        </a>

    @endif

</div>



{{-- =========================================================
     NOTIFIKASI AJAX
========================================================= --}}

<div id="ajaxMessage"></div>



{{-- =========================================================
     TABEL PENGAJUAN
========================================================= --}}

<div class="card">

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>

                    <th>No</th>

                    {{-- Admin melihat pengirim --}}
                    @if (auth()->user()->role === 'admin')

                        <th>Pengirim</th>

                    @endif

                    <th>Katalog</th>

                    <th>Jumlah Porsi</th>

                    <th>Tanggal Ambil</th>

                    <th>Keperluan</th>

                    <th>Status</th>

                    <th>Bukti</th>

                    <th>Aksi</th>

                </tr>

            </thead>


            <tbody id="pengajuanTableBody">

                @forelse ($pengajuans as $item)

                    <tr id="row-{{ $item->id }}">


                        {{-- =========================================
                             NOMOR
                        ========================================== --}}

                        <td>
                            {{ $loop->iteration }}
                        </td>



                        {{-- =========================================
                             PENGIRIM

                             Hanya ditampilkan Admin.
                        ========================================== --}}

                        @if (auth()->user()->role === 'admin')

                            <td>

                                @if ($item->user)

                                    <strong>
                                        {{ $item->user->name }}
                                    </strong>

                                    <br>

                                    <small style="color:#777;">
                                        {{ $item->user->email }}
                                    </small>

                                @else

                                    <span style="color:#999;">
                                        -
                                    </span>

                                @endif

                            </td>

                        @endif



                        {{-- =========================================
                             KATALOG
                        ========================================== --}}

                        <td>

                            @if ($item->donasi)

                                <strong>
                                    {{ $item->donasi->nama }}
                                </strong>

                                <br>

                                <small style="color:#777;">
                                    {{ $item->donasi->kode }}
                                </small>

                            @else

                                <span style="color:#999;">
                                    Katalog tidak ditemukan
                                </span>

                            @endif

                        </td>



                        {{-- =========================================
                             JUMLAH PORSI
                        ========================================== --}}

                        <td>

                            {{ $item->jumlah_porsi }}

                        </td>



                        {{-- =========================================
                             TANGGAL AMBIL
                        ========================================== --}}

                        <td>

                            @if ($item->tanggal_ambil)

                                {{ \Carbon\Carbon::parse($item->tanggal_ambil)->format('d-m-Y') }}

                            @else

                                -

                            @endif

                        </td>



                        {{-- =========================================
                             KEPERLUAN / CATATAN
                        ========================================== --}}

                        <td style="min-width:200px;">

                            {{ $item->catatan ?: '-' }}

                        </td>



                        {{-- =========================================
                             STATUS BADGE
                        ========================================== --}}

                        <td>

                            @if ($item->status === 'Menunggu')

                                <span
                                    id="status-{{ $item->id }}"
                                    class="badge badge-menunggu"
                                >
                                    Menunggu
                                </span>


                            @elseif ($item->status === 'Disetujui')

                                <span
                                    id="status-{{ $item->id }}"
                                    class="badge badge-disetujui"
                                >
                                    Disetujui
                                </span>


                            @elseif ($item->status === 'Ditolak')

                                <span
                                    id="status-{{ $item->id }}"
                                    class="badge badge-ditolak"
                                >
                                    Ditolak
                                </span>


                            @else

                                <span
                                    id="status-{{ $item->id }}"
                                    class="badge"
                                >
                                    {{ $item->status }}
                                </span>

                            @endif

                        </td>



                        {{-- =========================================
                             FOTO BUKTI
                        ========================================== --}}

                        <td>

                            @if ($item->foto_bukti)

                                <a
                                    href="{{ asset('storage/' . $item->foto_bukti) }}"
                                    target="_blank"
                                    class="btn btn-blue"
                                >
                                    Lihat Bukti
                                </a>

                            @else

                                <span style="color:#999;">
                                    Tidak ada
                                </span>

                            @endif

                        </td>



                        {{-- =========================================
                             AKSI
                        ========================================== --}}

                        <td>

                            <div
                                class="table-actions"
                                id="actions-{{ $item->id }}"
                            >


                                {{-- =================================
                                     DETAIL

                                     Admin boleh semua.

                                     Pemohon dari Controller hanya
                                     mendapatkan transaksi miliknya.
                                ================================== --}}

                                <a
                                    href="{{ route('pengajuan.show', $item->id) }}"
                                    class="btn btn-blue"
                                >
                                    Detail
                                </a>



                                {{-- =================================
                                     PEMOHON

                                     Edit dan hapus hanya:
                                     - milik sendiri
                                     - status Menunggu
                                ================================== --}}

                                @if (
                                    auth()->user()->role === 'pemohon'
                                    &&
                                    $item->user_id === auth()->id()
                                    &&
                                    $item->status === 'Menunggu'
                                )

                                    <a
                                        href="{{ route('pengajuan.edit', $item->id) }}"
                                        class="btn btn-warning"
                                    >
                                        Edit
                                    </a>


                                    <button
                                        type="button"
                                        class="btn btn-danger"

                                        onclick="hapusPengajuan(
                                            {{ $item->id }},
                                            this
                                        )"
                                    >
                                        Hapus
                                    </button>

                                @endif



                                {{-- =================================
                                     ADMIN
                                ================================== --}}

                                @if (auth()->user()->role === 'admin')


                                    {{-- Keputusan hanya jika Menunggu --}}

                                    @if ($item->status === 'Menunggu')

                                        <button
                                            type="button"

                                            class="btn btn-success decision-button"

                                            onclick="ubahStatus(
                                                {{ $item->id }},
                                                'approve',
                                                this
                                            )"
                                        >
                                            Setujui
                                        </button>


                                        <button
                                            type="button"

                                            class="btn btn-warning decision-button"

                                            onclick="ubahStatus(
                                                {{ $item->id }},
                                                'reject',
                                                this
                                            )"
                                        >
                                            Tolak
                                        </button>

                                    @endif


                                    {{-- Admin boleh hapus seluruh transaksi --}}

                                    <button
                                        type="button"
                                        class="btn btn-danger"

                                        onclick="hapusPengajuan(
                                            {{ $item->id }},
                                            this
                                        )"
                                    >
                                        Hapus
                                    </button>

                                @endif

                            </div>

                        </td>

                    </tr>


                @empty


                    {{-- =============================================
                         EMPTY STATE
                    ============================================== --}}

                    <tr id="emptyRow">

                        <td
                            colspan="{{ auth()->user()->role === 'admin' ? 9 : 8 }}"
                        >

                            <div class="empty-state">

                                <div class="empty-state-title">

                                    Belum ada pengajuan

                                </div>


                                @if (auth()->user()->role === 'pemohon')

                                    <p>
                                        Anda belum memiliki transaksi pengajuan.
                                    </p>


                                    <a
                                        href="{{ route('pengajuan.create') }}"
                                        class="btn btn-primary"
                                    >
                                        Buat Pengajuan
                                    </a>


                                @else

                                    <p>
                                        Belum ada transaksi pengajuan yang masuk.
                                    </p>

                                @endif

                            </div>

                        </td>

                    </tr>


                @endforelse

            </tbody>

        </table>

    </div>

</div>



{{-- =========================================================
     INFORMASI ROLE
========================================================= --}}

<div
    class="card"
    style="margin-top:20px;"
>

    @if (auth()->user()->role === 'admin')

        <strong>
            Hak akses Admin
        </strong>

        <p style="margin-bottom:0;color:#666;">

            Admin dapat melihat seluruh transaksi,
            memberikan keputusan Setujui atau Tolak
            pada transaksi Menunggu, serta menghapus transaksi.

        </p>


    @else

        <strong>
            Hak akses Pemohon
        </strong>

        <p style="margin-bottom:0;color:#666;">

            Anda hanya dapat melihat transaksi milik sendiri.
            Edit dan hapus hanya tersedia ketika
            transaksi masih berstatus Menunggu.

        </p>

    @endif

</div>

@endsection



{{-- =============================================================
     JAVASCRIPT AJAX
============================================================= --}}

@push('scripts')

<script>

/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/

const csrfToken =
    document
        .querySelector(
            'meta[name="csrf-token"]'
        )
        .content;


/*
|--------------------------------------------------------------------------
| MESSAGE CONTAINER
|--------------------------------------------------------------------------
*/

const ajaxMessage =
    document.getElementById(
        'ajaxMessage'
    );


/*
|--------------------------------------------------------------------------
| TAMPILKAN NOTIFIKASI
|--------------------------------------------------------------------------
*/

function tampilkanPesan(
    message,
    type = 'success'
) {

    const className =
        type === 'success'
            ? 'alert alert-success'
            : 'alert alert-error';


    ajaxMessage.innerHTML =
        '<div class="' + className + '">'
        + message
        + '</div>';


    /*
     * Scroll ke pesan.
     */

    ajaxMessage.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest'
    });


    /*
     * Hilangkan otomatis setelah 5 detik.
     */

    setTimeout(function () {

        ajaxMessage.innerHTML = '';

    }, 5000);
}



/*
|--------------------------------------------------------------------------
| HANDLE HTTP ERROR
|--------------------------------------------------------------------------
|
| Membedakan:
|
| 403 = authorization
| 422 = validation / business rule
|--------------------------------------------------------------------------
*/

function handleErrorResponse(
    response,
    data
) {

    if (response.status === 403) {

        tampilkanPesan(
            data.message
                ?? 'Akses ditolak. Anda tidak memiliki izin untuk melakukan tindakan ini.',
            'error'
        );

        return;
    }


    if (response.status === 422) {

        let message =
            data.message
                ?? 'Data tidak valid.';


        /*
         * Kalau Laravel mengirim errors.
         */

        if (data.errors) {

            const firstError =
                Object
                    .values(data.errors)
                    .flat()[0];


            if (firstError) {

                message =
                    firstError;

            }
        }


        tampilkanPesan(
            message,
            'error'
        );

        return;
    }


    tampilkanPesan(
        data.message
            ?? 'Terjadi kesalahan pada server.',
        'error'
    );
}



/*
|--------------------------------------------------------------------------
| HAPUS PENGAJUAN
|--------------------------------------------------------------------------
*/

async function hapusPengajuan(
    id,
    button
) {

    /*
     * Konfirmasi penghapusan.
     */

    const yakin =
        confirm(
            'Yakin ingin menghapus transaksi ini?'
        );


    if (!yakin) {

        return;

    }


    /*
     * Simpan teks tombol awal.
     */

    const teksAwal =
        button.textContent;


    /*
     * Loading.
     */

    button.disabled =
        true;


    button.classList.add(
        'loading'
    );


    button.innerHTML =
        '<span class="spinner"></span>'
        + 'Menghapus...';


    try {

        const response =
            await fetch(

                '/pengajuan/' + id,

                {
                    method:
                        'DELETE',

                    headers: {

                        'X-CSRF-TOKEN':
                            csrfToken,

                        'Accept':
                            'application/json'

                    }
                }
            );


        /*
         * Response kemungkinan JSON.
         */

        const data =
            await response.json();


        /*
         * Error.
         */

        if (!response.ok) {

            handleErrorResponse(
                response,
                data
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SUKSES
        |--------------------------------------------------------------------------
        |
        | Update DOM tanpa reload.
        |
        */

        const row =
            document.getElementById(
                'row-' + id
            );


        if (row) {

            row.remove();

        }


        tampilkanPesan(
            data.message
                ?? 'Pengajuan berhasil dihapus.',
            'success'
        );


        /*
         * Cek apakah tabel sekarang kosong.
         */

        cekTabelKosong();


    }

    catch (error) {

        tampilkanPesan(
            'Gagal terhubung ke server: '
            + error.message,
            'error'
        );

    }

    finally {

        /*
         * Kalau button masih ada di DOM,
         * pulihkan ke keadaan normal.
         *
         * Kalau delete sukses, row sudah dihapus.
         */

        if (
            document.body.contains(
                button
            )
        ) {

            button.disabled =
                false;


            button.classList.remove(
                'loading'
            );


            button.textContent =
                teksAwal;

        }

    }
}



/*
|--------------------------------------------------------------------------
| APPROVE / REJECT
|--------------------------------------------------------------------------
*/

async function ubahStatus(
    id,
    keputusan,
    button
) {

    /*
     * Tentukan pesan konfirmasi.
     */

    const konfirmasi =
        keputusan === 'approve'
            ? 'Setujui transaksi ini? Keputusan akan bersifat final.'
            : 'Tolak transaksi ini? Keputusan akan bersifat final.';


    if (!confirm(konfirmasi)) {

        return;

    }


    /*
     * Simpan teks awal.
     */

    const teksAwal =
        button.textContent;


    /*
     * Loading.
     */

    button.disabled =
        true;


    button.classList.add(
        'loading'
    );


    button.innerHTML =
        '<span class="spinner"></span>'
        + 'Memproses...';


    /*
     * Disable tombol keputusan lain
     * dalam transaksi yang sama.
     */

    const actionContainer =
        document.getElementById(
            'actions-' + id
        );


    const decisionButtons =
        actionContainer
            ? actionContainer.querySelectorAll(
                '.decision-button'
            )
            : [];


    decisionButtons.forEach(
        function (btn) {

            btn.disabled =
                true;

        }
    );


    try {

        const response =
            await fetch(

                '/pengajuan/'
                + id
                + '/'
                + keputusan,

                {
                    method:
                        'PATCH',

                    headers: {

                        'X-CSRF-TOKEN':
                            csrfToken,

                        'Accept':
                            'application/json',

                        'Content-Type':
                            'application/json'

                    }
                }
            );


        const data =
            await response.json();


        /*
         * Error.
         */

        if (!response.ok) {

            handleErrorResponse(
                response,
                data
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS DOM
        |--------------------------------------------------------------------------
        */

        const statusElement =
            document.getElementById(
                'status-' + id
            );


        if (statusElement) {

            /*
             * Ubah tulisan.
             */

            statusElement.textContent =
                data.status;


            /*
             * Reset class.
             */

            statusElement.className =
                'badge';


            /*
             * Tambah badge sesuai status.
             */

            if (
                data.status
                === 'Disetujui'
            ) {

                statusElement
                    .classList
                    .add(
                        'badge-disetujui'
                    );

            }

            else if (
                data.status
                === 'Ditolak'
            ) {

                statusElement
                    .classList
                    .add(
                        'badge-ditolak'
                    );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | KEPUTUSAN FINAL
        |--------------------------------------------------------------------------
        |
        | Setelah berhasil,
        | hapus tombol Setujui dan Tolak.
        |
        */

        if (actionContainer) {

            actionContainer
                .querySelectorAll(
                    '.decision-button'
                )
                .forEach(
                    function (btn) {

                        btn.remove();

                    }
                );

        }


        /*
         * Success notification.
         */

        tampilkanPesan(
            data.message
                ?? 'Keputusan berhasil disimpan.',
            'success'
        );

    }

    catch (error) {

        tampilkanPesan(
            'Gagal terhubung ke server: '
            + error.message,
            'error'
        );

    }

    finally {

        /*
         * Kalau request gagal,
         * tombol harus aktif kembali.
         */

        if (
            document.body.contains(
                button
            )
        ) {

            button.disabled =
                false;


            button.classList.remove(
                'loading'
            );


            button.textContent =
                teksAwal;

        }


        /*
         * Aktifkan tombol decision lain
         * apabila masih ada.
         *
         * Jika sukses, tombol sudah
         * dihapus dari DOM.
         */

        decisionButtons.forEach(
            function (btn) {

                if (
                    document.body.contains(
                        btn
                    )
                ) {

                    btn.disabled =
                        false;

                }

            }
        );

    }
}



/*
|--------------------------------------------------------------------------
| CEK TABEL KOSONG
|--------------------------------------------------------------------------
|
| Jika transaksi terakhir dihapus melalui AJAX,
| tampilkan empty state tanpa reload.
|--------------------------------------------------------------------------
*/

function cekTabelKosong()
{
    const tbody =
        document.getElementById(
            'pengajuanTableBody'
        );


    /*
     * Cari baris transaksi.
     */

    const rows =
        tbody.querySelectorAll(
            'tr[id^="row-"]'
        );


    /*
     * Masih ada data.
     */

    if (rows.length > 0) {

        return;

    }


    /*
     * Sudah ada empty state?
     */

    if (
        document.getElementById(
            'emptyRow'
        )
    ) {

        return;

    }


    /*
     * Jumlah kolom berbeda
     * antara Admin dan Pemohon.
     */

    const isAdmin =
        @json(
            auth()->user()->role === 'admin'
        );


    const colspan =
        isAdmin
            ? 9
            : 8;


    const message =
        isAdmin

            ? `
                <p>
                    Belum ada transaksi pengajuan
                    yang masuk.
                </p>
              `

            : `
                <p>
                    Anda belum memiliki
                    transaksi pengajuan.
                </p>

                <a
                    href="{{ route('pengajuan.create') }}"
                    class="btn btn-primary"
                >
                    Buat Pengajuan
                </a>
              `;


    tbody.insertAdjacentHTML(
        'beforeend',

        `
        <tr id="emptyRow">

            <td colspan="${colspan}">

                <div class="empty-state">

                    <div class="empty-state-title">
                        Belum ada pengajuan
                    </div>

                    ${message}

                </div>

            </td>

        </tr>
        `
    );
}

</script>

@endpush