@extends('layouts.app')
 
 
@section('title', 'Dashboard Pemohon - FoodShare')
 
 
@section('content')
 
 
    <h1 style="color:#2e7d32;">
        Dashboard Pemohon
    </h1>
 
 
    <p>
 
        Selamat datang,
 
        <strong>
            {{ auth()->user()->name }}
        </strong>
 
    </p>
 
 
    <br>
 
 
    <div class="card">
 
        <h3>
            Jumlah Transaksi Saya
        </h3>
 
 
        <h1 style="color:#1565c0;">
 
            {{ $jumlahTransaksi }}
 
        </h1>
 
 
        <p>
            Total pengajuan milik akun Anda.
        </p>
 
    </div>
 
 
    <br>
 
 
    <div class="card">
 
        <h2>
            Daftar Transaksi Saya
        </h2>
 
 
        <table>
 
            <thead>
 
                <tr>
 
                    <th>
                        No
                    </th>
 
                    <th>
                        Kebutuhan
                    </th>
 
                    <th>
                        Jumlah Porsi
                    </th>
 
                    <th>
                        Status
                    </th>
 
                </tr>
 
            </thead>
 
 
            <tbody>
 
                @forelse ($transaksi as $item)
 
                    <tr>
 
                        <td>
                            {{ $loop->iteration }}
                        </td>
 
                        <td>
                            {{ $item->kebutuhan ?? '-' }}
                        </td>
 
                        <td>
                            {{ $item->jumlah_porsi }}
                        </td>
 
                        <td>
                            {{ $item->status }}
                        </td>
 
                    </tr>
 
 
                @empty
 
                    <tr>
 
                        <td
                            colspan="4"
                            style="text-align:center;"
                        >
 
                            Belum ada transaksi.
 
                        </td>
 
                    </tr>
 
                @endforelse
 
            </tbody>
 
        </table>
 
    </div>
 
 
@endsection