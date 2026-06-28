<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'email',
        'gross_salary',
        'frequency',
        'effective_date',
        'is_active',
    ];

    protected $casts = [
        'effective_date' => 'date', 
        'is_active' => 'boolean',
    ];
    public function salaries() : HasMany
    {
        return $this->hasMany(CompanySalary::class);
    }public function currentSalary()
    {
        return $this->hasOne(CompanySalary::class)
            ->where('is_current', true);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
