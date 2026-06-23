<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index() : View
    { 
 
        $user = auth()->user();  
        return view('events.index', [
            'user'=>$user,
            'events'=>$user->events()->latest()->get()
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'event_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);
    
        auth()->user()->events()->create($validated);
         
        return redirect()
            ->back()
            ->with('success', 'Events added successfully!');
    }

}
