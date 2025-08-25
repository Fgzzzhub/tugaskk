<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom hanya jika belum ada
        if (!Schema::hasColumn('menfesses', 'user_id')) {
            Schema::table('menfesses', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->index('user_id', 'menfesses_user_id_index');
            });
        }

        // (Opsional) Foreign key DILEWATKAN di sini.
        // Alasannya: di hosting gratis kita sudah pasang FK via file schema SQL,
        // dan MySQL tidak punya "IF NOT EXISTS" untuk FK. Jadi biarkan schema SQL yang mengatur FK.
    }

    public function down(): void
    {
        if (Schema::hasColumn('menfesses', 'user_id')) {
            Schema::table('menfesses', function (Blueprint $table) {
                // drop FK & index bila ada — aman kalau gagal
                try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
                try { $table->dropIndex('menfesses_user_id_index'); } catch (\Throwable $e) {}

                $table->dropColumn('user_id');
            });
        }
    }
};
