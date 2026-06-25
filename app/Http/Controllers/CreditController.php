<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Credit;


class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
    */
  
    public function index() : View
    { 
 
        $user = auth()->user(); 
        
        $previousMonth = $user->credits()
        ->whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])
        ->sum('original_amount');
 
        $activeTransaction = $user->credits()->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();


        $currentMonth = $user->credits()->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->sum('remaining_balance');


        return view('credits.index', [
            'user'=>$user,
            'currentMonth'=> $currentMonth,
            'previousMonth' => $previousMonth,
            'activeTransaction' => $activeTransaction,
            'credits'=>$user->credits()->latest()->orderByDesc('created_at')->paginate(10)
        ]);
 
    }


    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'original_amount' => ['required', 'numeric', 'min:0'],
            'monthly_payment' => ['required', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,paid,overdue,restructured,cancelled'],
        ]);
    
        $validated['remaining_balance'] = $validated['original_amount'];
    
        auth()->user()->credits()->create($validated);
    
        return redirect()->back()->with('success', 'Credit added successfully!');
    }


    public function update(Request $request, Credit $credit)
    {
 
        // $this->authorize('update', $credit);
    
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'original_amount' => ['required', 'numeric'],
            'monthly_payment' => ['required', 'numeric'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required'],
        ]);
    
        $credit->update($validated);
    
        return back()->with('success', 'Credit updated successfully!');
    }

}
