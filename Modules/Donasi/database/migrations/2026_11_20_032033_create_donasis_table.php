<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
 
            $table->string('kode')->unique();
 
            $table->string('nama');
 
            $table->text('deskripsi')->nullable();
 
            $table->unsignedInteger('jumlah_porsi');
 
            $table->string('lokasi_pengambilan');
 
            $table->string('status')
                ->default('Tersedia');
 
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};