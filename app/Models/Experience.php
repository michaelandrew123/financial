<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Experience extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'position',
        'company',
        'location', 
        'description',
        'company',
        'still_in_role',
        'start_date',
        'end_date',
    ];
 
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'still_in_role' => 'boolean', 
    ];
    public function details()
    {
        return $this->hasMany(ExperienceDetail::class);
    }
    
  
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
