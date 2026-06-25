<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'location',
        'start_date',
        'end_date',
    ];

    public function details()
    {
        return $this->hasMany(ExperienceDetail::class);
    }
    
}
