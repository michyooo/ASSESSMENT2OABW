<?php
 
namespace Modules\Pengajuan\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Pengajuan extends Model
{
    use HasFactory;
 
    protected $table = 'pengajuans';
 
    protected $fillable = [
        'user_id',
        'donasi_id',
        'jumlah_porsi',
        'tanggal_ambil',
        'catatan',
        'foto_bukti',
        'status',
    ];
 
 
    /*
    |--------------------------------------------------------------------------
    | Relasi ke User
    |--------------------------------------------------------------------------
    */
 
    public function user()
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'user_id'
        );
    }
 
 
    /*
    |--------------------------------------------------------------------------
    | Relasi ke Katalog Donasi
    |--------------------------------------------------------------------------
    */
 
    public function donasi()
  {
        return $this->belongsTo(
            \Modules\Donasi\Models\Donasi::class,
            'donasi_id'
        );
    }
}