<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('comments', 'body')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->text('body')->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('comments', 'body')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->dropColumn('body');
            });
        }
    }
};
