<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolExperienceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_experience_id',
        'description',
    ];

    public function schoolExperience()
    {
        return $this->belongsTo(SchoolExperience::class);
    }
}
