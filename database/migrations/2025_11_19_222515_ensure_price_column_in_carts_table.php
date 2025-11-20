<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('carts')) {
            $columnExists = Schema::hasColumn('carts', 'price');
            
            if (!$columnExists) {
                Schema::table('carts', function (Blueprint $table) {
                    $table->decimal('price', 10, 2)->after('quantity');
                });

                // Update existing cart items with product prices
                if (Schema::hasTable('products')) {
                    DB::statement('UPDATE carts c 
                        INNER JOIN products p ON c.product_id = p.id 
                        SET c.price = p.price 
                        WHERE c.price IS NULL OR c.price = 0');
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                if (Schema::hasColumn('carts', 'price')) {
                    $table->dropColumn('price');
                }
            });
        }
    }
};
