<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
 
            $table->id();
 
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
 
            $table->string('kebutuhan');
 
            $table->unsignedInteger('jumlah_porsi')
                ->default(1);
 
            $table->string('status')
                ->default('Menunggu');
 
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};