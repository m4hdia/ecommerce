<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'session_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getCartCount()
    {
        if (app()->runningInConsole() || !app()->bound('session')) {
            return 0;
        }

        if (! Schema::hasTable((new self())->getTable())) {
            return 0;
        }

        if (!session()->isStarted()) {
            session()->start();
        }

        if (auth()->check()) {
            return static::where('user_id', auth()->id())->count();
        } else {
            return static::where('session_id', session()->getId())->count();
        }
    }
}