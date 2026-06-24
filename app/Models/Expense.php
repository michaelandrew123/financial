<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_name',
        'amount',
        'period',
        'notes',
    ];

    protected $casts = [
        'period'=>'date',
        'created_at'=>'date'
    ];
     
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
