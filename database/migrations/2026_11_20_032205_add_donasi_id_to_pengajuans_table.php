<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->foreignId('donasi_id')
                ->nullable()
                ->constrained('donasis')
                ->restrictOnDelete();
        });
    }
 
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropForeign(['donasi_id']);
            $table->dropColumn('donasi_id');
        });
    }
};