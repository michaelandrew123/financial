<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DashboardService
{
    public function getDashboardData(User $user): array
    {
        $user->load([
            'savings', 
            'companies',
            'expenses',
            'credits',
            'events'
        ]); 

        $savingsTrend = $user->savings()
            ->selectRaw('DATE(created_at) as date, SUM(target_amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('date')
            ->orderBy('date')
        ->get();

        // $recentTransactions = collect()
        // ->merge(
        //     $user->savings()->get()->map(function ($item) {
        //         return [
        //             'date' => $item->created_at,
        //             'type' => 'Savings',
        //             'amount' => $item->target_amount,
        //         ];
        //     })
        // )
        // ->merge(
        //     $user->companies()->get()->map(function ($item) {
        //         return [
        //             'date' => $item->created_at,
        //             'type' => 'Income',
        //             'amount' => $item->gross_salary,
        //         ];
        //     })
        // )
        // ->merge(
        //     $user->expenses()->get()->map(function ($item) {
        //         return [
        //             'date' => $item->created_at,
        //             'type' => 'Expense',
        //             'amount' => -$item->amount,
        //         ];
        //     })
        // )
        // ->merge(
        //     $user->credits()->get()->map(function ($item) {
        //         return [
        //             'date' => $item->created_at,
        //             'type' => 'Credit',
        //             'amount' => -$item->remaining_balance,
        //         ];
        //     })
        // )
        // ->merge(
        //     $user->events()->get()->map(function ($item) {
        //         return [
        //             'date' => $item->created_at,
        //             'type' => 'Event',
        //             'amount' => 0,
        //         ];
        //     })
        // )
        // ->sortByDesc('date')
        // ->take(10)
        // ->values();

        $recentTransactions = DB::table('savings')
            ->where('user_id', $user->id)
            ->select(
                'created_at as date',
                DB::raw("'Savings' as type"),
                'target_amount as amount'
            )

            ->unionAll(
                DB::table('companies')
                    ->where('user_id', $user->id)
                    ->select(
                        'created_at as date',
                        DB::raw("'Income' as type"),
                        'gross_salary as amount'
                    )
            )

            ->unionAll(
                DB::table('expenses')
                    ->where('user_id', $user->id)
                    ->select(
                        'created_at as date',
                        DB::raw("'Expense' as type"),
                        DB::raw('-amount as amount')
                    )
            )

            ->unionAll(
                DB::table('credits')
                    ->where('user_id', $user->id)
                    ->select(
                        'created_at as date',
                        DB::raw("'Credit' as type"),
                        DB::raw('-remaining_balance as amount')
                    )
            )

            ->unionAll(
                DB::table('events')
                    ->where('user_id', $user->id)
                    ->select(
                        'created_at as date',
                        DB::raw("'Event' as type"),
                        DB::raw('0 as amount')
                    )
            );
        
        $recentTransactions = DB::query()
            ->fromSub($recentTransactions, 't')
            ->orderByDesc('date')
            ->paginate(10);


        return [
            'user' => $user, 
            'totalSaved' => $user->savings->sum('target_amount'), 
            'activeGoals' => $user->savings->count(), 
            'thisMonthSaved' => $user->savings
                ->whereBetween('created_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ])
                ->sum('target_amount'), 
            'savings' => $user->savings()
            ->latest() 
            ->paginate(10)
            ->withQueryString(), 
            'savingsTrend' => $savingsTrend, 
            'companies' => $user->companies()->get(), 
            // 'incomeVsExpenses' => [
            //     'income' => $user->companies()
            //         ->whereYear('created_at', now()->year)
            //         ->sum('gross_salary'),
            
            //     'expenses' => $user->expenses()
            //         ->whereYear('created_at', now()->year)
            //         ->sum('amount'),
            // ],
            'incomeVsExpenses' => [
                'income' => $user->companies()->sum('gross_salary'),
                'expenses' => $user->expenses()->sum('amount'),
            ],
            'totalCompanyActiveIncome' => $user->companies->sum('gross_salary'),  
            'expenses' => $user->expenses()->get(), 
            'totalExpensesForCurrentMonth' => $user->companies->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])->sum('amount'),  
            'credits' => $user->credits()->get(), 
            'totalCredits' => $user->credits()->sum('remaining_balance'),  
            'events' => $user->events()->get(), 
            'recentTransactions' => $recentTransactions,
        ];


    }
}