<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'shipping_name')) {
                    $table->string('shipping_name')->after('user_id');
                }
                if (!Schema::hasColumn('orders', 'shipping_email')) {
                    $table->string('shipping_email')->after('shipping_name');
                }
                if (!Schema::hasColumn('orders', 'shipping_phone')) {
                    $table->string('shipping_phone')->nullable()->after('shipping_email');
                }
                if (!Schema::hasColumn('orders', 'shipping_address')) {
                    $table->text('shipping_address')->after('shipping_phone');
                }
                if (!Schema::hasColumn('orders', 'total_price')) {
                    $table->decimal('total_price', 10, 2)->after('shipping_address');
                }
                if (!Schema::hasColumn('orders', 'status')) {
                    $table->string('status')->default('pending')->after('total_price');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $columns = ['shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address', 'total_price', 'status'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('orders', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
