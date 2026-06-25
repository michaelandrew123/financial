<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'department',
        'location',
        'event',
        'start_date',
        'end_date',
    ];

    public function details()
    {
        return $this->hasMany(SchoolExperienceDetail::class);
    }
}
