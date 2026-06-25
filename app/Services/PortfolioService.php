<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class PortfolioService
{

     
    public function getPortfolioData(User $user): array
    {
        $user->load([
            'savings', 
            'companies',
            'expenses',
            'credits',
            'events'
        ]); 
 

        return [
            'user' => $user,
        ];


    }
}