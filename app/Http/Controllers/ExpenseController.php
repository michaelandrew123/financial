<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\View\View;
use App\Models\CompanySalary;
class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    { 
 
        $user = auth()->user();  

        $previousMonthExpenses = $user->expenses()
        ->whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])
        ->sum('amount');
        $activeTransaction = $user->expenses()->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();

        return view('expenses.index', [
            'user'=>$user,
            'thisMonthExpenses'=>$user->expenses()->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])->sum('amount'),
            'previousMonthExpenses' => $previousMonthExpenses,
            'activeTransaction' => $activeTransaction,
            'expenses' => $user->expenses()->latest()->orderByDesc('created_at')->paginate(10),
 
            'companySalaries'=>CompanySalary::whereHas('company', function($query) use ($user){
                $query->where('user_id', $user->id);
            })->with('company')->latest()->get(),

        ]);
    }


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
            'company_salary_id' => [
                'required',
                'exists:company_salaries,id',
            ],
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'], 
            'period' => ['nullable', 'date', 'after_or_equal:today'], 
            'notes' => ['required', 'string', 'max:2000'],
        ]); 
        // Ensure the selected salary belongs to the authenticated user
        $salary = CompanySalary::whereHas('company', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($validated['company_salary_id']);
   
        auth()->user()->expenses()->create($validated);
     
        return redirect()->back()->with('success', 'Credit added successfully!');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
