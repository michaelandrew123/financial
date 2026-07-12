<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicklerTemplate;

class TicklerTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index(TicklerTemplate $ticklerTemplate)
    {
       
        $items = auth()->user()->tickler_templates()->orderBy('created_at')->get();
     
        return view('tickler.template.index', compact('items'));
    }

 

    /**
     * Show the form for creating a new resource.
     */
    public function create(TicklerTemplate $ticklerTemplate)
    {
       
        return view('tickler-template.create', compact('ticklerTemplate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*' => 'required|string|max:255',
        ]);
    
    
        TicklerTemplate::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'items' => $validated['items'],
        ]);
    
    
        return redirect()
            ->route('tickler-template.index')
            ->with('success','Template created successfully.');
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
  
    public function update(Request $request, TicklerTemplate $ticklerTemplate)
    {
    
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*' => 'required|string|max:255',
        ]);
    
    
        $ticklerTemplate->update([
            'title' => $validated['title'],
            'items' => $validated['items'],
        ]);
    
    
        return redirect()
            ->route('tickler-template.index')
            ->with('success','Template updated successfully.');
    
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicklerTemplate $ticklerTemplate)
    {
        $ticklerTemplate->delete();
    
    
        return redirect()
            ->route('tickler-template.index')
            ->with('success','Template deleted successfully.');
    }
}
