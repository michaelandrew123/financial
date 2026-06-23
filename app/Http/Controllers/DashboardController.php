<?php

namespace App\Http\Controllers;
 
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
 
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $data = $this->dashboardService
            ->getDashboardData($request->user());
        

        return view('dashboard', [
            'user' => $data['user'],

            'savings' => $data['savings'],
            'totalSaved' => $data['totalSaved'],
            'companies' => $data['companies'],

            'savingsTrend' => $data['savingsTrend'],
            'incomeVsExpenses' => $data['incomeVsExpenses'],

            'totalCompanyActiveIncome' => $data['totalCompanyActiveIncome'],
            'totalExpensesForCurrentMonth' => $data['totalExpensesForCurrentMonth'], 

            'credits' => $data['credits'],
            'totalCredits' => $data['totalCredits'],
            
            'events' => $data['events'],
            'recentTransactions' => $data['recentTransactions']
        ]);


        // return view('dashboard', compact('user'));
    } 
}
