<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotQuery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question',
        'response',
        'matched_type',
        'matched_id',
        'is_unanswered',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_unanswered' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

