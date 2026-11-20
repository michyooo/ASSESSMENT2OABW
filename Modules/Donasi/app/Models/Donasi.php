<?php
 
namespace Modules\Donasi\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Donasi extends Model
{
    use HasFactory;
 
    protected $table = 'donasis';
 
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'jumlah_porsi',
        'lokasi_pengambilan',
        'status',
    ];
 
    public function pengajuans()
{
    return $this->hasMany(
        \Modules\Pengajuan\Models\Pengajuan::class,
        'donasi_id'
    );
}
}