@extends('layouts.app')

@section('title', 'Buat Pengajuan - FoodShare')

@section('content')

<div
    class="card"
    style="
        max-width: 800px;
        margin: 0 auto;
    "
>

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div style="margin-bottom: 25px;">

        <h1
            style="
                color: #2e7d32;
                margin-top: 0;
                margin-bottom: 8px;
            "
        >
            Buat Pengajuan
        </h1>

        <p
            style="
                color: #666;
                margin: 0;
            "
        >
            Isi data pengajuan makanan di bawah ini.
        </p>

    </div>


    <hr style="margin-bottom: 25px;">


    {{-- =====================================================
         PESAN GLOBAL AJAX
    ====================================================== --}}

    <div id="pesan"></div>


    {{-- =====================================================
         FORM PENGAJUAN
    ====================================================== --}}

    <form
        id="formPengajuan"
        enctype="multipart/form-data"
    >


        {{-- =================================================
             PILIH KATALOG
        ================================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="donasi_id"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                    color: #333;
                "
            >
                Pilih Katalog
                <span style="color: red;">*</span>
            </label>


            <select
                name="donasi_id"
                id="donasi_id"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    background-color: white;
                    font-size: 14px;
                "
            >

                <option value="">
                    -- Pilih Katalog Makanan --
                </option>


                @forelse ($donasis as $donasi)

                    <option
                        value="{{ $donasi->id }}"
                        data-porsi="{{ $donasi->jumlah_porsi }}"
                        data-tanggal="{{ $donasi->tanggal_bagi ?? '' }}"
                    >

                        {{ $donasi->kode }}
                        -
                        {{ $donasi->nama }}
                        -
                        Maks. {{ $donasi->jumlah_porsi }} porsi
                        -
                        {{ $donasi->lokasi_pengambilan }}

                        @if ($donasi->tanggal_bagi)
                            -
                            {{ $donasi->tanggal_bagi }}
                        @endif

                    </option>

                @empty

                    <option
                        value=""
                        disabled
                    >
                        Belum ada katalog tersedia
                    </option>

                @endforelse

            </select>


            {{-- Error per-field --}}
            <div
                id="error-donasi_id"
                class="field-error"
                style="
                    color: #c62828;
                    font-size: 13px;
                    margin-top: 6px;
                "
            ></div>


            <small
                style="
                    display: block;
                    color: #777;
                    margin-top: 5px;
                "
            >
                Pilih katalog makanan yang ingin diajukan.
            </small>

        </div>



        {{-- =================================================
             INFORMASI KATALOG
        ================================================== --}}

        <div
            id="infoKatalog"
            style="
                display: none;
                background-color: #e3f2fd;
                color: #0d47a1;
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 20px;
            "
        >

            <strong>
                Informasi Katalog
            </strong>

            <br><br>

            Batas porsi:

            <strong id="infoPorsi">
                -
            </strong>

            <br>

            Tanggal bagi:

            <strong id="infoTanggal">
                -
            </strong>

        </div>



        {{-- =================================================
             JUMLAH PORSI
        ================================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="jumlah_porsi"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                    color: #333;
                "
            >
                Jumlah Porsi
                <span style="color: red;">*</span>
            </label>


            <input
                type="number"
                name="jumlah_porsi"
                id="jumlah_porsi"

                min="1"

                placeholder="Masukkan jumlah porsi"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    font-size: 14px;
                "
            >


            <div
                id="error-jumlah_porsi"
                class="field-error"
                style="
                    color: #c62828;
                    font-size: 13px;
                    margin-top: 6px;
                "
            ></div>


            <small
                style="
                    display: block;
                    color: #777;
                    margin-top: 5px;
                "
            >
                Minimal 1 dan tidak boleh melebihi batas porsi katalog.
            </small>

        </div>



        {{-- =================================================
             TANGGAL AMBIL
        ================================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="tanggal_ambil"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                    color: #333;
                "
            >
                Tanggal Pengambilan
                <span style="color: red;">*</span>
            </label>


            <input
                type="date"
                name="tanggal_ambil"
                id="tanggal_ambil"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    font-size: 14px;
                "
            >


            <div
                id="error-tanggal_ambil"
                class="field-error"
                style="
                    color: #c62828;
                    font-size: 13px;
                    margin-top: 6px;
                "
            ></div>


            <small
                style="
                    display: block;
                    color: #777;
                    margin-top: 5px;
                "
            >
                Tanggal pengambilan harus sesuai dengan tanggal bagi katalog.
            </small>

        </div>



        {{-- =================================================
             KEPERLUAN / CATATAN
        ================================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="catatan"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                    color: #333;
                "
            >
                Keperluan
                <span style="color: red;">*</span>
            </label>


            <textarea
                name="catatan"
                id="catatan"

                rows="4"

                maxlength="1000"

                placeholder="Contoh: Untuk konsumsi kegiatan mahasiswa..."

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    font-size: 14px;
                    resize: vertical;
                "
            ></textarea>


            <div
                id="error-catatan"
                class="field-error"
                style="
                    color: #c62828;
                    font-size: 13px;
                    margin-top: 6px;
                "
            ></div>


            <small
                style="
                    display: block;
                    color: #777;
                    margin-top: 5px;
                "
            >
                Keperluan wajib diisi, maksimal 1000 karakter.
            </small>

        </div>



        {{-- =================================================
             FOTO BUKTI
        ================================================== --}}

        <div style="margin-bottom: 25px;">

            <label
                for="foto_bukti"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                    color: #333;
                "
            >
                Foto Bukti
            </label>


            <input
                type="file"

                name="foto_bukti"
                id="foto_bukti"

                accept=".jpg,.jpeg,.png,image/jpeg,image/png"

                style="
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    background-color: white;
                "
            >


            <div
                id="error-foto_bukti"
                class="field-error"
                style="
                    color: #c62828;
                    font-size: 13px;
                    margin-top: 6px;
                "
            ></div>


            <small
                style="
                    display: block;
                    color: #777;
                    margin-top: 5px;
                "
            >
                Opsional. Format JPG, JPEG, atau PNG. Maksimal 2 MB.
            </small>

        </div>



        {{-- =================================================
             INFORMASI USER DAN STATUS
        ================================================== --}}

        <div
            style="
                background-color: #e8f5e9;
                color: #1b5e20;
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 25px;
            "
        >

            <strong>
                Pengirim:
            </strong>

            {{ auth()->user()->name }}

            <br>


            <strong>
                Email:
            </strong>

            {{ auth()->user()->email }}

            <br>


            <strong>
                Status awal:
            </strong>

            Menunggu

        </div>


        {{--
        ==========================================================
        PENTING

        Tidak ada input:

        <input name="user_id">

        dan tidak ada:

        <input name="status">

        Karena:

        user_id = akun dari session/server
        status  = Menunggu dari server

        Jadi manipulasi payload pengguna tidak digunakan.
        ==========================================================
        --}}



        {{-- =================================================
             BUTTON
        ================================================== --}}

        <div
            style="
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            "
        >

            <button
                type="submit"
                id="btnSimpan"
                class="btn btn-primary"
            >
                Simpan Pengajuan
            </button>


            <a
                href="{{ route('pengajuan.index') }}"
                class="btn btn-blue"
            >
                Kembali
            </a>

        </div>

    </form>

</div>

@endsection



{{-- =========================================================
     JAVASCRIPT AJAX
========================================================= --}}

@push('scripts')

<script>

/*
|--------------------------------------------------------------------------
| ELEMENT
|--------------------------------------------------------------------------
*/

const form =
    document.getElementById(
        'formPengajuan'
    );


const pesan =
    document.getElementById(
        'pesan'
    );


const btnSimpan =
    document.getElementById(
        'btnSimpan'
    );


const katalogSelect =
    document.getElementById(
        'donasi_id'
    );


const jumlahPorsiInput =
    document.getElementById(
        'jumlah_porsi'
    );


const tanggalInput =
    document.getElementById(
        'tanggal_ambil'
    );


const infoKatalog =
    document.getElementById(
        'infoKatalog'
    );


const infoPorsi =
    document.getElementById(
        'infoPorsi'
    );


const infoTanggal =
    document.getElementById(
        'infoTanggal'
    );



/*
|--------------------------------------------------------------------------
| INFORMASI KATALOG
|--------------------------------------------------------------------------
|
| Ini hanya membantu pengguna.
|
| Validasi keamanan tetap dilakukan
| oleh StorePengajuanRequest di server.
|
*/

katalogSelect.addEventListener(
    'change',
    function ()
    {
        const option =
            katalogSelect.options[
                katalogSelect.selectedIndex
            ];


        if (!option.value) {

            infoKatalog.style.display =
                'none';


            jumlahPorsiInput.removeAttribute(
                'max'
            );


            return;
        }


        const batasPorsi =
            option.dataset.porsi;


        const tanggalBagi =
            option.dataset.tanggal;


        /*
         * Tampilkan batas porsi.
         */

        infoPorsi.textContent =
            batasPorsi
            ? batasPorsi + ' porsi'
            : '-';


        /*
         * Tampilkan tanggal bagi.
         */

        infoTanggal.textContent =
            tanggalBagi
            ? tanggalBagi
            : '-';


        /*
         * HTML client-side validation.
         *
         * Ini bukan pengganti validasi server.
         */

        if (batasPorsi) {

            jumlahPorsiInput.setAttribute(
                'max',
                batasPorsi
     