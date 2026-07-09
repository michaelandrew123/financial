<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_category_id',
        'name',
        'skill_level',
        'experience_years',
        'experience_months',
    ];

    public function skillCategory(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class, 'id');
    } 
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
}
