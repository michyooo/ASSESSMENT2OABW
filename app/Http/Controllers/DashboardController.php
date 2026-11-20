<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Support\Facades\Auth;
use Modules\Donasi\Models\Donasi;
use Modules\Pengajuan\Models\Pengajuan;
 
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
 
        if ($user->role === 'admin') {
 
            // Semua nilai langsung dihitung dari database MySQL
            $jumlahKatalog = Donasi::count();
 
            $transaksiMenunggu = Pengajuan::where(
                'status',
                'Menunggu'
            )->count();
 
            $totalPorsiDisetujui = Pengajuan::where(
                'status',
                'Disetujui'
            )->sum('jumlah_porsi');
 
            return view('dashboard.admin', compact(
                'jumlahKatalog',
                'transaksiMenunggu',
                'totalPorsiDisetujui'
            ));
        }
 
        // Hanya mengambil transaksi milik user yang login
        $transaksi = Pengajuan::where(
            'user_id',
            $user->id
        )->latest()->get();
 
        $jumlahTransaksi = $transaksi->count();
 
        return view('dashboard.pemohon', compact(
            'transaksi',
            'jumlahTransaksi'
        ));
    }
}