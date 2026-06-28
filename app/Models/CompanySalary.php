<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CompanySalary extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id', 
        'gross_salary',
        'frequency',
        'effective_date', 
        'is_current', 
    ]; 
    protected $casts = [
        'effective_date' => 'date', 
        'is_current' => 'boolean', 
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
