<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tickler extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id',
        'company',
        'department',
        'description',
        'address',
        'position'
    ];
     
    protected $casts = [
        'created_at' => 'date'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'id');
    }
         
    public function items(): HasMany
    {
        return $this->hasMany(TicklerItem::class, 'tickler_id');
    } 
 
}
