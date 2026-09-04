<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('tbl_nexa_admin', 'is_login_allowed')) {
            Schema::table('tbl_nexa_admin', function (Blueprint $table) {
                $table->boolean('is_login_allowed')->default(false)->after('status');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('tbl_nexa_admin', 'is_login_allowed')) {
            Schema::table('tbl_nexa_admin', function (Blueprint $table) {
                $table->dropColumn('is_login_allowed');
            });
        }
    }
};