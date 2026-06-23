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
        return view('credits.index', [
            'user'=>$user,
            'credits'=>$user->credits()->latest()->get()
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
