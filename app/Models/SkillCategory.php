<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillCategory extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'name',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class, 'skill_category_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
}
