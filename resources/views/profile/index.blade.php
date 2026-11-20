@extends('layouts.app')
@section('title', 'Profil - FoodShare')
@section('content')
    <div class="card">
        <h1 style="color:#2e7d32; margin-top:0;">
            Profil Saya
        </h1>
        <p>
            Informasi akun yang sedang aktif.
        </p>
        <hr>
        <table>
            <tr>
                <th style="width:200px;">
                    Nama
                </th>
                <td>
                    {{ auth()->user()->name }}
                </td>
            </tr>
            <tr>
                <th>
                    Email
                </th>
                <td>
                    {{ auth()->user()->email }}
                </td>
            </tr>
            <tr>
                <th>
                    Role
                </th>
                <td>
                    {{ ucfirst(auth()->user()->role) }}
                </td>
            </tr>
        </table>
        <br>
        <a
            href="{{ route('dashboard') }}"
            class="btn btn-primary"
        >
            ← Kembali ke Dashboard
        </a>
    </div>
@endsection