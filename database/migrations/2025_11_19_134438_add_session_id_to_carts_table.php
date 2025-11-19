<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('carts')) {
            return;
        }

        Schema::table('carts', function (Blueprint $table) {
            if (! Schema::hasColumn('carts', 'session_id')) {
                $table->string('session_id')->nullable()->after('user_id')->index();
            }
        });

        if (Schema::hasColumn('carts', 'user_id')) {
            DB::statement('ALTER TABLE carts MODIFY `user_id` BIGINT UNSIGNED NULL');
        }
    }

    public function down()
    {
        if (! Schema::hasTable('carts')) {
            return;
        }

        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'session_id')) {
                $table->dropColumn('session_id');
            }
        });

        if (Schema::hasColumn('carts', 'user_id')) {
            DB::statement('ALTER TABLE carts MODIFY `user_id` BIGINT UNSIGNED NOT NULL');
        }
    }
};