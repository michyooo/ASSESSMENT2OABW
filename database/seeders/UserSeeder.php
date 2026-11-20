<?php
 
namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
 
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@foodshare.test'],
            [
                'name' => 'Admin FoodShare',
                'password' => Hash::make('Admin12345!'),
                'role' => 'admin',
            ]
        );
 
        User::updateOrCreate(
            ['email' => 'pemohon1@foodshare.test'],
            [
                'name' => 'Pemohon Satu',
                'password' => Hash::make('Pemohon123!'),
                'role' => 'pemohon',
            ]
        );
 
        User::updateOrCreate(
            ['email' => 'pemohon2@foodshare.test'],
            [
                'name' => 'Pemohon Dua',
                'password' => Hash::make('Pemohon123!'),
                'role' => 'pemohon',
            ]
        );
    }
}