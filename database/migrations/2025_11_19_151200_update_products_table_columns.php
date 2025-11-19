<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('price');
            }

            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('image')->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('category_id');
            }
        });

        if (Schema::hasColumn('products', 'quantity')) {
            DB::statement('UPDATE products SET stock = quantity');

            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }

        if (Schema::hasColumn('products', 'category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('category');
            });
        }

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('featured')->default(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'quantity')) {
                $table->integer('quantity')->default(0)->after('price');
            }

            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->after('quantity');
            }

            if (Schema::hasColumn('products', 'stock')) {
                DB::statement('UPDATE products SET quantity = stock');
                $table->dropColumn('stock');
            }

            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};

