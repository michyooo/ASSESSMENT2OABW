@extends('layouts.app')

@section('title', 'Tambah Katalog - FoodShare')

@section('content')

<div
    class="card"
    style="
        max-width: 800px;
        margin: 0 auto;
    "
>

    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">

        <h1
            style="
                color: #2e7d32;
                margin-top: 0;
                margin-bottom: 8px;
            "
        >
            Tambah Katalog Donasi
        </h1>

        <p
            style="
                color: #666;
                margin: 0;
            "
        >
            Masukkan informasi katalog makanan yang akan tersedia di FoodShare.
        </p>

    </div>


    <hr style="margin-bottom: 25px;">


    {{-- ========================================
         PESAN ERROR UMUM
    ========================================= --}}

    @if ($errors->any())

        <div class="alert-error">

            <strong>
                Data belum valid.
            </strong>

            <p style="margin-bottom: 0;">
                Silakan periksa kembali field yang memiliki pesan kesalahan.
            </p>

        </div>

    @endif


    {{-- ========================================
         FORM
    ========================================= --}}

    <form
        action="{{ route('donasi.store') }}"
        method="POST"
        id="formDonasi"
    >

        @csrf


        {{-- ====================================
             KODE
        ===================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="kode"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                "
            >
                Kode Katalog
                <span style="color:red;">*</span>
            </label>


            <input
                type="text"
                name="kode"
                id="kode"

                value="{{ old('kode') }}"

                placeholder="Contoh: DON-006"

                maxlength="50"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid
                        {{ $errors->has('kode') ? '#c62828' : '#ccc' }};
                    border-radius: 6px;
                    font-size: 14px;
                "
            >


            @error('kode')

                <div
                    style="
                        color: #c62828;
                        font-size: 13px;
                        margin-top: 6px;
                    "
                >
                    {{ $message }}
                </div>

            @enderror


            <small
                style="
                    display: block;
                    color: #777;
                    margin-top: 5px;
                "
            >
                Kode harus unik dan tidak boleh sama dengan katalog lainnya.
            </small>

        </div>


        {{-- ====================================
             NAMA
        ===================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="nama"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                "
            >
                Nama Katalog
                <span style="color:red;">*</span>
            </label>


            <input
                type="text"
                name="nama"
                id="nama"

                value="{{ old('nama') }}"

                placeholder="Contoh: Nasi Kotak"

                maxlength="255"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid
                        {{ $errors->has('nama') ? '#c62828' : '#ccc' }};
                    border-radius: 6px;
                    font-size: 14px;
                "
            >


            @error('nama')

                <div
                    style="
                        color: #c62828;
                        font-size: 13px;
                        margin-top: 6px;
                    "
                >
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- ====================================
             DESKRIPSI
        ===================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="deskripsi"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                "
            >
                Deskripsi
            </label>


            <textarea
                name="deskripsi"
                id="deskripsi"

                rows="4"

                maxlength="1000"

                placeholder="Masukkan deskripsi makanan..."

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid
                        {{ $errors->has('deskripsi') ? '#c62828' : '#ccc' }};
                    border-radius: 6px;
                    font-size: 14px;
                    resize: vertical;
                "
            >{{ old('deskripsi') }}</textarea>


            @error('deskripsi')

                <div
                    style="
                        color: #c62828;
                        font-size: 13px;
                        margin-top: 6px;
                    "
                >
                    {{ $message }}
                </div>

            @enderror


            <small style="color:#777;">
                Opsional, maksimal 1000 karakter.
            </small>

        </div>


        {{-- ====================================
             BATAS / JUMLAH PORSI
        ===================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="jumlah_porsi"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                "
            >
                Batas Porsi
                <span style="color:red;">*</span>
            </label>


            <input
                type="number"
                name="jumlah_porsi"
                id="jumlah_porsi"

                value="{{ old('jumlah_porsi') }}"

                min="1"

                placeholder="Contoh: 20"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid
                        {{ $errors->has('jumlah_porsi') ? '#c62828' : '#ccc' }};
                    border-radius: 6px;
                    font-size: 14px;
                "
            >


            @error('jumlah_porsi')

                <div
                    style="
                        color: #c62828;
                        font-size: 13px;
                        margin-top: 6px;
                    "
                >
                    {{ $message }}
                </div>

            @enderror


            <small
                style="
                    display:block;
                    color:#777;
                    margin-top:5px;
                "
            >
                Batas porsi harus berupa bilangan bulat minimal 1.
            </small>

        </div>


        {{-- ====================================
             LOKASI PENGAMBILAN
        ===================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="lokasi_pengambilan"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                "
            >
                Lokasi Pengambilan
                <span style="color:red;">*</span>
            </label>


            <input
                type="text"
                name="lokasi_pengambilan"
                id="lokasi_pengambilan"

                value="{{ old('lokasi_pengambilan') }}"

                placeholder="Contoh: Sukapura"

                maxlength="255"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid
                        {{ $errors->has('lokasi_pengambilan') ? '#c62828' : '#ccc' }};
                    border-radius: 6px;
                    font-size: 14px;
                "
            >


            @error('lokasi_pengambilan')

                <div
                    style="
                        color: #c62828;
                        font-size: 13px;
                        margin-top: 6px;
                    "
                >
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- ====================================
             TANGGAL BAGI
        ===================================== --}}

        <div style="margin-bottom: 20px;">

            <label
                for="tanggal_bagi"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                "
            >
                Tanggal Bagi
                <span style="color:red;">*</span>
            </label>


            <input
                type="date"
                name="tanggal_bagi"
                id="tanggal_bagi"

                value="{{ old('tanggal_bagi') }}"

                min="{{ now()->format('Y-m-d') }}"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid
                        {{ $errors->has('tanggal_bagi') ? '#c62828' : '#ccc' }};
                    border-radius: 6px;
                    font-size: 14px;
                "
            >


            @error('tanggal_bagi')

                <div
                    style="
                        color: #c62828;
                        font-size: 13px;
                        margin-top: 6px;
                    "
                >
                    {{ $message }}
                </div>

            @enderror


            <small
                style="
                    display:block;
                    color:#777;
                    margin-top:5px;
                "
            >
                Pemohon nantinya harus memilih tanggal pengambilan yang sesuai dengan tanggal bagi ini.
            </small>

        </div>


        {{-- ====================================
             STATUS KATALOG
        ===================================== --}}

        <div style="margin-bottom: 25px;">

            <label
                for="status"
                style="
                    display: block;
                    margin-bottom: 7px;
                    font-weight: bold;
                "
            >
                Status Katalog
                <span style="color:red;">*</span>
            </label>


            <select
                name="status"
                id="status"

                style="
                    width: 100%;
                    padding: 11px;
                    border: 1px solid
                        {{ $errors->has('status') ? '#c62828' : '#ccc' }};
                    border-radius: 6px;
                    background: white;
                    font-size: 14px;
                "
            >

                <option value="">
                    -- Pilih Status --
                </option>


                <option
                    value="Tersedia"

                    {{ old('status', 'Tersedia') === 'Tersedia'
                        ? 'selected'
                        : '' }}
                >
                    Tersedia
                </option>


                <option
                    value="Tidak Tersedia"

                    {{ old('status') === 'Tidak Tersedia'
                        ? 'selected'
                        : '' }}
                >
                    Tidak Tersedia
                </option>

            </select>


            @error('status')

                <div
                    style="
                        color: #c62828;
                        font-size: 13px;
                        margin-top: 6px;
                    "
                >
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- ====================================
             INFORMASI
        ===================================== --}}

        <div
            style="
                background: #e8f5e9;
                color: #1b5e20;

                padding: 15px;

                border-radius: 6px;

                margin-bottom: 25px;
            "
        >

            <strong>
                Informasi
            </strong>

            <br><br>

            Katalog baru akan disimpan oleh akun:

            <strong>
                {{ auth()->user()->name }}
            </strong>

            <br>

            Hanya Admin yang dapat menambah,
            mengedit, dan menghapus katalog.

        </div>


        {{-- ====================================
             BUTTON
        ===================================== --}}

        <div
            style="
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            "
        >

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Katalog
            </button>


            <a
                href="{{ route('donasi.index') }}"
                class="btn btn-blue"
            >
                Kembali
            </a>

        </div>


    </form>

</div>

@endsection