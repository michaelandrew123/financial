<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;


class Saving extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'goal_name',
        'target_amount',
        'frequency',
        'status',
    ];
    protected $casts = [
        'created_at' => 'date', 
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
 

}
