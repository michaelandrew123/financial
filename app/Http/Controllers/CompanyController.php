<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 

    public function index(): View
    {
        $user = auth()->user();

        return view('companies.index', [
            'user' => $user,
            'companies' => $user->companies()
                ->with([
                    'salaries' => fn ($query) =>  $query->orderBy('created_at', 'desc')
                    // $query->latest('effective_date')
                ])
                ->orderBy('created_at', 'desc')
                ->get(),
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
