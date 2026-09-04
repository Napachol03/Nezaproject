<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tbl_nexa_view', 'view_date_timestamp')) {
            Schema::table('tbl_nexa_view', function (Blueprint $table) {
                $table->timestamp('view_date_timestamp')->useCurrent()->after('product_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tbl_nexa_view', 'view_date_timestamp')) {
            Schema::table('tbl_nexa_view', function (Blueprint $table) {
                $table->dropColumn('view_date_timestamp');
            });
        }
    }
};