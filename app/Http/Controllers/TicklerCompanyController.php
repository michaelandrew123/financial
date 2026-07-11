<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicklerCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index(): View
    {
       
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
 
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
