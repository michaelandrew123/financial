<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySalary;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
class CompanySalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
 
        // CompanySalary::create($validated);
        $validated = $request->validate([
            'company_id'     => ['required', 'exists:companies,id'],
            'gross_salary'   => ['required', 'numeric', 'min:0'],
            'frequency'      => ['required', 'in:weekly,biweekly,monthly'],
            'effective_date' => ['nullable', 'date'],
        ]); 

        DB::transaction(function () use ($validated) {

            $company = Company::findOrFail($validated['company_id']);
        
            // if ($company->currentSalary) {
            //     $company->currentSalary->update([
            //         'is_current' => false,
            //     ]);
            // }
            $company->salaries()
            ->where('is_current', true)
            ->update([
                'is_current' => false,
            ]);

            $company->salaries()->create([
                'gross_salary'   => $validated['gross_salary'],
                'frequency'      => $validated['frequency'],
                'effective_date' => $validated['effective_date'],
                'is_current'     => true,
            ]);
        });
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
