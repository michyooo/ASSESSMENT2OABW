@extends('layouts.app')
 
 
@section('title', 'Dashboard Admin - FoodShare')
 
 
@section('content')
 
 
    <h1 style="color:#2e7d32;">
        Dashboard Admin
    </h1>
 
 
    <p>
        Selamat datang,
 
        <strong>
            {{ auth()->user()->name }}
        </strong>
    </p>
 
 
    <hr>
 
 
    <div
        style="
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:20px;
            margin-top:25px;
        "
    >
 
 
        {{-- JUMLAH KATALOG --}}
 
        <div class="card">
 
            <h3>
                Jumlah Katalog
            </h3>
 
            <h1 style="color:#2e7d32;">
 
                {{ $jumlahKatalog }}
 
            </h1>
 
            <p>
                Total katalog makanan.
            </p>
 
        </div>
 
 
 
        {{-- MENUNGGU --}}
 
        <div class="card">
 
            <h3>
                Transaksi Menunggu
            </h3>
 
            <h1 style="color:#f9a825;">
 
                {{ $transaksiMenunggu }}
 
            </h1>
 
            <p>
                Transaksi yang perlu diproses.
            </p>
 
        </div>
 
 
 
        {{-- PORSI DISETUJUI --}}
 
        <div class="card">
 
            <h3>
                Total Porsi Disetujui
            </h3>
 
            <h1 style="color:#1565c0;">
 
                {{ $totalPorsiDisetujui }}
 
            </h1>
 
            <p>
                Total porsi transaksi Disetujui.
            </p>
 
        </div>
 
 
    </div>
 
 
@endsection