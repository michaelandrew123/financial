<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicklerItem extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'tickler_id',
        'items',
        'approved_by_name', 
        'approved_by_signature_path', 
        'signature_path',
    ];
    
    protected $casts = [
        'items' => 'array',
        'created_at' => 'date'
    ];
    
    public function tickler() : BelongsTo {
        return $this->belongsTo(Tickler::class);
    } 
}
