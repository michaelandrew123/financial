<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\View\View;
use App\Services\PortfolioService;
use App\Models\Seminar;
use App\Models\Experience;
class AdminController extends Controller
{
    public function index(): View
    {
        // if (auth()->user()->isAdmin()) { 
        // }
        $user = auth()->user();
        $seminars = $user->seminar()->latest()->orderByDesc('created_at')->paginate(10); 
      
        return view('admin.dashboard', [
            'seminars'=>$seminars 
        ]);
 
    }

    
    public function seminarStore(Request $request){

        $validated = $request->validate([ 
            'title' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'], 
            'start_date' => ['nullable', 'date'],
        ]); 
        auth()->user()->seminar()->create($validated); 
        return redirect()->back()->with('success', 'Seminar added successfully!');
    }
    // string $id

    public function seminarDestroy($id){ 

        Seminar::findOrFail($id)->delete();
        return back()->with('success', 'Seminar deleted successfully!');
    }

    public function workExperienceStore(Request $request){
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255', 
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'still_in_role' => 'nullable|boolean',
            'end_date' => 'nullable|required_if:still_in_role,0|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);
        
        if (($validated['still_in_role'] ?? false) === true) {
            $validated['end_date'] = null;
        }
    
        
        auth()->user()->experience()->create($validated);
        return redirect()->back()->with('success', 'Seminar added successfully!');

    }

}
