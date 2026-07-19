<?php

namespace App\Http\Controllers;
use App\Models\Tickler;
use App\Models\TicklerItem;
use App\Models\TicklerTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class TicklerItemController extends Controller
{
    public function index(Tickler $tickler)
    {
        $items = $tickler->items()->orderBy('created_at', 'asc')->get();

        
        $templates = TicklerTemplate::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();


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
            // 'approved_by_signature' => 'nullable|string|max:255',
            // 'signature' => 'nullable|string|max:255', 
            'approved_by_signature'=>'nullable|string', 
            'signature'=>'nullable|string',
        ]); 
        $validated['approved_by_signature_path'] = $this->saveSignature(
            $request->approved_by_signature
        );
        
        $validated['signature_path'] = $this->saveSignature(
            $request->signature
        );
        
        unset($validated['approved_by_signature']);
        unset($validated['signature']);
        
        TicklerItem::create($validated);
        
        return redirect()
            ->route('tickler.index')
            ->with('success', 'Tickler item created successfully.'); 
    }
  
    private function saveSignature(?string $base64)
    {
        if (!$base64) {
            return null;
        }

        $base64 = preg_replace(
            '#^data:image/\w+;base64,#i',
            '',
            $base64
        );

        $image = base64_decode($base64);

        $name = 'signatures/'.Str::uuid().'.png';

        Storage::disk('public')->put(
            $name,
            $image
        );

        return $name;
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
