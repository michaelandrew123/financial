<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'company_salary_id',
        'title',
        'amount',
        'period',
        'notes',
    ];

    protected $casts = [
        'period'=>'date',
        'created_at'=>'date'
    ];
     
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function companySalary(): BelongsTo
    {
        return $this->belongsTo(CompanySalary::class, 'company_salary_id');
    }
}
