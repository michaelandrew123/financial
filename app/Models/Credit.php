<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'original_amount',
        'remaining_balance',
        'monthly_payment',
        'start_date',
        'end_date',
        'status',
    ]; 

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
