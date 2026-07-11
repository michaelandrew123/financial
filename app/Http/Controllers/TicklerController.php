<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; 
use App\Models\TicklerCompany;
use App\Models\TicklerTemplate;
use App\Models\Tickler;
class TicklerController extends Controller
{ 
    public function index()
    {
 

        return view('tickler.index',[
            'ticklers' => auth()->user()
                ->tickler()
                ->latest()
                ->paginate(10),
    
            'companies' => auth()->user()
                ->tickler_companies,
    
            'templates' => auth()->user()
                ->tickler_templates,
        ]);
    }

    public function create()
    {
        return view('tickler.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        auth()->user()->tickler()->create($validated);

        return redirect()->route('tickler.index')
            ->with('success', 'Tickler created successfully.');
    }

    public function show(Tickler $tickler)
    {
        return view('tickler.show', compact('tickler'));
    }

    public function edit(Tickler $tickler)
    {
        return view('tickler.edit', compact('tickler'));
    }

    public function update(Request $request, Tickler $tickler)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $tickler->update($validated);

        return redirect()->route('tickler.index')
            ->with('success', 'Tickler updated successfully.');
    }

    public function destroy(Tickler $tickler)
    {
        // Optional: Ensure users can only delete their own ticklers
        abort_if($tickler->user_id !== auth()->id(), 403);

        $tickler->delete();

        return redirect()
            ->route('tickler.index')
            ->with('success', 'Tickler deleted successfully.');
    }
}
