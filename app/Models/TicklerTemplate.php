<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicklerTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'items',
    ];


    protected $casts = [
        'items' => 'array',
        'created_at' => 'date',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
