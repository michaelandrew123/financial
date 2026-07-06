<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_category_id',
        'name',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class);
    } 
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
}
