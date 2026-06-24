<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Saving;
class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 

    // public function index(): View
    // { 
    //     $user = auth()->user(); 
    //     return view('saving.index', [
    //         'user' => $user,
    //         'savings' => $user->savings()->latest()->get(),
    //     ]);
    // }
    // public function index() : View
    // { 
 
    //     $user = auth()->user();    
    //     $totalSaved = $user->savings->sum('target_amount');

    //     $activeTransaction = $user->savings->count();
    //     $thisMonthSaved = $user->savings
    //         ->whereBetween('created_at', [
    //             now()->startOfMonth(),
    //             now()->endOfMonth(),
    //         ])
    //         ->sum('target_amount');
    //     $savings = $user->savings()
    //         ->latest()
    //         ->paginate(10)
    //         ->withQueryString();
    //     // $savings = $user->savings()->latest()->paginate(10);

 
    //     return view('saving.index', compact(
    //         'user',
    //         'totalSaved',
    //         'activeTransaction',
    //         'thisMonthSaved',
    //         'savings'
    //     ));
    // }

    public function index(): View
    {
        $user = auth()->user();

        $savingsQuery = $user->savings();

        $totalSaved = $savingsQuery->sum('target_amount');

        $activeTransaction = $savingsQuery->count();

        $thisMonthSaved = $savingsQuery
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->sum('target_amount');

        $savings = $user->savings()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('saving.index', compact(
            'user',
            'totalSaved',
            'activeTransaction',
            'thisMonthSaved',
            'savings'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'saving.add';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'goal_name' => 'required|string|max:255',
            'target_amount' => 'required|numeric',
            'frequency' => 'required|in:weekly,monthly,yearly',
        ]);
    
        auth()->user()->savings()->create([
            'goal_name' => $request->goal_name,
            'target_amount' => $request->target_amount,
            'frequency' => $request->frequency,
            'status' => Saving::STATUS_ACTIVE,
        ]);
    

        return redirect()->back()->with('success', 'Saving added successfully!');
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
