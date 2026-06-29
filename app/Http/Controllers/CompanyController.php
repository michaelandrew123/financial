<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Company;
use Carbon\Carbon;
use App\Models\CompanySalary;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index(): View
    {
        $user = auth()->user();
    
        $companies = $user->companies()
            ->with('salaries')
            ->orderByDesc('created_at')
            ->get();
    
        foreach ($companies as $company) {
    
            foreach ($company->salaries as $salary) {
    
                $start = Carbon::parse($salary->effective_date);
    
                // Find the current pay period
                while (true) {
    
                    $next = match ($salary->frequency) {
                        'weekly'   => $start->copy()->addWeek(),
                        'biweekly' => $start->copy()->addWeeks(2),
                        'monthly'  => $start->copy()->addMonth(),
                    };
    
                    if ($next->gt(now())) {
                        break;
                    }
    
                    $start = $next;
                }
    
                $end = match ($salary->frequency) {
                    'weekly'   => $start->copy()->addWeek(),
                    'biweekly' => $start->copy()->addWeeks(2),
                    'monthly'  => $start->copy()->addMonth(),
                };
    
                $totalExpenses = $user->expenses()
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('amount');
    
                // Append computed values
                $salary->total_expenses = $totalExpenses;
                $salary->remaining_balance = $salary->gross_salary - $totalExpenses;
                $salary->pay_period_start = $start->format('M d, Y');
                $salary->pay_period_end = $end->format('M d, Y');
            }
    
            // Sort salaries newest first
            $company->setRelation(
                'salaries',
                $company->salaries
                    ->sortByDesc('created_at')
                    ->values()
            );
        }
    
        return view('companies.index', [
            'user' => $user,
            'companies' => $companies,
        ]);
    }


    // public function index(): View
    // {
    //     $x = auth()->user();
  
    //     return view('companies.index', [
    //         'user' => $user,
    //         'companies' => $user->companies()
    //             ->with([
    //                 'salaries' => fn ($query) =>  $query->orderBy('created_at', 'desc') 
    //             ])
    //             ->orderBy('created_at', 'desc')
    //             ->get(),

 
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'gross_salary' => ['required', 'numeric', 'min:0'],
            'frequency' => ['required', 'in:weekly,biweekly,monthly'], 
            'effective_date' => ['nullable', 'date'],
        ]);
    
        auth()->user()->companies()->create($validated);
    
        return redirect()
            ->back()
            ->with('success', 'Company added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
  
    public function update(Request $request, Company $company)
    { 
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'gross_salary' => ['required', 'numeric', 'min:0'],
            'frequency' => ['required', 'in:weekly,biweekly,monthly'], 
            'effective_date' => ['nullable', 'date'],
            'is_active' => ['required', 'boolean'], 
        ]);
    
        $company->update($validated);
    
        return back()->with('success', 'Company updated successfully!');
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
