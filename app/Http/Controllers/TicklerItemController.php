<?php

namespace App\Http\Controllers;
use App\Models\Tickler;
use App\Models\TicklerItem;
use Illuminate\Http\Request;

class TicklerItemController extends Controller
{
    public function index(Tickler $tickler)
    {
        $items = $tickler->items()->orderBy('created_at')->get();

        return view('tickler-items.index', compact('tickler', 'items'));
    }

    public function create(Tickler $tickler)
    {
        return view('tickler-items.create', compact('tickler'));
    }

    // public function store(Request $request, Tickler $tickler)
    // {
    //     $validated = $request->validate([
    //         'sort' => 'nullable|integer',
    //         'item' => 'required|string|max:255',
    //         'name' => 'nullable|string|max:255',
    //         'approved_by_name' => 'nullable|string|max:255',
    //         'approved_by_signature' => 'nullable|string|max:255',
    //         'signature' => 'nullable|string|max:255',
    //     ]);

    //     $tickler->items()->create($validated);

    //     return redirect()
    //         ->route('tickler.items.index', $tickler)
    //         ->with('success', 'Item created.');
    // }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'tickler_id' => 'required|exists:ticklers,id',
            'items' => 'required|array|min:1',
            'items.*' => 'required|string|max:255', 
            'approved_by_name' => 'nullable|string|max:255',
            'approved_by_signature' => 'nullable|string|max:255',
            'signature' => 'nullable|string|max:255',
        ]);
        

        // $exists = TicklerItem::where('tickler_id', $validated['tickler_id'])
        // ->whereDate('created_at', Carbon::today())
        // ->exists();

        // if ($exists) {
        //     return back()
        //         ->withInput()
        //         ->withErrors([
        //             'tickler_id' => 'A tickler item has already been created for today.'
        //         ]);
        // }
 
        TicklerItem::create($validated);
        
        return redirect()
            ->route('tickler.index')
            ->with('success', 'Tickler item created successfully.'); 
    }
  
    public function show(Tickler $tickler, TicklerItem $item)
    {
        return view('tickler-items.show', compact('tickler', 'item'));
    }

    public function edit(Tickler $tickler, TicklerItem $item)
    {
        return view('tickler-items.edit', compact('tickler', 'item'));
    }

    public function update(Request $request, Tickler $tickler, TicklerItem $item)
    {
        $validated = $request->validate([
            'sort' => 'nullable|integer',
            'item' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'approved_by_name' => 'nullable|string|max:255',
            'approved_by_signature' => 'nullable|string|max:255',
            'signature' => 'nullable|string|max:255',
        ]);

        $item->update($validated);

        return redirect()
            ->route('tickler.items.index', $tickler)
            ->with('success', 'Item updated.');
    }

    public function destroy(Tickler $tickler, TicklerItem $item)
    {
        $item->delete();

        return redirect()
            ->route('tickler.items.index', $tickler)
            ->with('success', 'Item deleted.');
    }
}
