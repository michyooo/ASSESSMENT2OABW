<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Modules\Donasi\Models\Donasi;
 
class DonasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
 
            [
                'kode' => 'DON-001',
                'nama' => 'Nasi Kotak',
                'deskripsi' => 'Paket nasi dan lauk.',
                'jumlah_porsi' => 20,
                'lokasi_pengambilan' => 'Sukapura',
                'status' => 'Tersedia',
            ],
 
            [
                'kode' => 'DON-002',
                'nama' => 'Roti',
                'deskripsi' => 'Paket roti siap konsumsi.',
                'jumlah_porsi' => 15,
                'lokasi_pengambilan' => 'Sukabirus',
                'status' => 'Tersedia',
            ],
 
            [
                'kode' => 'DON-003',
                'nama' => 'Paket Makan Siang',
                'deskripsi' => 'Nasi, lauk, dan sayuran.',
                'jumlah_porsi' => 30,
                'lokasi_pengambilan' => 'Sukapura',
                'status' => 'Tersedia',
            ],
 
            [
                'kode' => 'DON-004',
                'nama' => 'Paket Sembako',
                'deskripsi' => 'Paket kebutuhan pangan.',
                'jumlah_porsi' => 10,
                'lokasi_pengambilan' => 'Dayeuhkolot',
                'status' => 'Tersedia',
            ],
 
            [
                'kode' => 'DON-005',
                'nama' => 'Snack Box',
                'deskripsi' => 'Paket makanan ringan.',
                'jumlah_porsi' => 25,
                'lokasi_pengambilan' => 'Bojongsoang',
                'status' => 'Tersedia',
            ],
 
        ];
 
 
        foreach ($data as $item) {
 
            Donasi::updateOrCreate(
                [
                    'kode' => $item['kode']
                ],
                $item
            );
 
        }
    }
}