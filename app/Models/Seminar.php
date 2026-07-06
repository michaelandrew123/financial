<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Seminar extends Model
{
    use HasFactory; 

    protected $fillable = [
        'title',
        'organizer',
        'start_date'
    ];
    
    protected $casts = [
        'start_date' => 'date', 
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
}
