@extends('layouts.app')
 
@section('title', 'Katalog - FoodShare')
 
@section('content')
 
<div class="card">
 
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    ">
 
        <div>
            <h1 style="color:#2e7d32; margin:0;">
                Katalog Donasi
            </h1>
 
            <p>
                Daftar katalog makanan FoodShare.
            </p>
        </div>
 
        @if(auth()->user()->role === 'admin')
 
            <a
                href="{{ route('donasi.create') }}"
                class="btn btn-primary"
            >
                + Tambah Katalog
            </a>
 
        @endif
 
    </div>
 
 
    {{-- PENCARIAN DAN FILTER --}}
 
    <form
        action="{{ route('donasi.index') }}"
        method="GET"
        style="
            display:flex;
            gap:10px;
            margin-bottom:25px;
            flex-wrap:wrap;
        "
    >
 
        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Cari kode atau nama..."
            style="
                padding:10px;
                border:1px solid #ccc;
                border-radius:5px;
                min-width:250px;
            "
        >
 
 
        <select
            name="lokasi"
            style="
                padding:10px;
                border:1px solid #ccc;
                border-radius:5px;
                min-width:200px;
            "
        >
 
            <option value="">
                Semua Lokasi
            </option>
 
            @foreach(($daftarLokasi ?? []) as $itemLokasi)
 
                <option
                    value="{{ $itemLokasi }}"
                    {{ ($lokasi ?? '') === $itemLokasi ? 'selected' : '' }}
                >
                    {{ $itemLokasi }}
                </option>
 
            @endforeach
 
        </select>
 
 
        <button
            type="submit"
            class="btn btn-blue"
        >
            Cari / Filter
        </button>
 
 
        <a
            href="{{ route('donasi.index') }}"
            class="btn btn-primary"
        >
            Reset
        </a>
 
    </form>
 
 
    {{-- TABEL KATALOG --}}
 
    <div style="overflow-x:auto;">
 
        <table>
 
            <thead>
 
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jumlah Porsi</th>
                    <th>Lokasi</th>
                    <th>Status</th>
 
                    @if(auth()->user()->role === 'admin')
                        <th>Aksi</th>
                    @endif
                </tr>
 
            </thead>
 
            <tbody>
 
                @forelse(($donasis ?? []) as $donasi)
 
                    <tr>
 
                        <td>
                            {{ $loop->iteration }}
                        </td>
 
                        <td>
                            {{ $donasi->kode }}
                        </td>
 
                        <td>
                            <strong>
                                {{ $donasi->nama }}
                            </strong>
 
                            @if($donasi->deskripsi)
                                <br>
                                <small>
                                    {{ $donasi->deskripsi }}
                                </small>
                            @endif
                        </td>
 
                        <td>
                            {{ $donasi->jumlah_porsi }}
                        </td>
 
                        <td>
                            {{ $donasi->lokasi_pengambilan }}
                        </td>
 
                        <td>
                            {{ $donasi->status }}
                        </td>
 
 
                        @if(auth()->user()->role === 'admin')
 
                            <td>
 
                                <div style="
                                    display:flex;
                                    gap:5px;
                                ">
 
                                    <a
                                        href="{{ route('donasi.edit', $donasi->id) }}"
                                        style="
                                            background:#f9a825;
                                            color:white;
                                            padding:8px 12px;
                                            border-radius:5px;
                                            text-decoration:none;
                                        "
                                    >
                                        Edit
                                    </a>
 
 
                                    <form
                                        action="{{ route('donasi.destroy', $donasi->id) }}"
                                        method="POST"
                                    >
 
                                        @csrf
                                        @method('DELETE')
 
                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus katalog ini?')"
                                        >
                                            Hapus
                                        </button>
 
                                    </form>
 
                                </div>
 
                            </td>
 
                        @endif
 
                    </tr>
 
                @empty
 
                    <tr>
 
                        <td
                            colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}"
                            style="text-align:center; padding:30px;"
                        >
                            Belum ada data katalog.
                        </td>
 
                    </tr>
 
                @endforelse
 
            </tbody>
 
        </table>
 
    </div>
 
</div>
 
@endsection