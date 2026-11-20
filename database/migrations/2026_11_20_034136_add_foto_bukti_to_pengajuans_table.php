<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {

            $table->text('catatan')
                ->nullable();

            $table->string('foto_bukti')
                ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {

            $table->dropColumn([
                'catatan',
                'foto_bukti'
            ]);

        });
    }
};