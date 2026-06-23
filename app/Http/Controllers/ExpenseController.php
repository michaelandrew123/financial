<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\View\View;
class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    { 
 
        $user = auth()->user();  
        return view('expenses.index', [
            'user'=>$user,
            'expenses'=>$user->expenses()->latest()->orderByDesc('date')->paginate(10)
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
        //
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
