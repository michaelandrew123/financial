<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\View\View;
use App\Services\PortfolioService;
use App\Models\Seminar;
use App\Models\Experience;
use App\Models\SkillCategory;
class AdminController extends Controller
{
    public function index(): View
    {
        // if (auth()->user()->isAdmin()) { 
        // }
        $user = auth()->user();
        $seminars = $user->seminar()->latest()->orderByDesc('created_at')->paginate(10); 
        
        $skillCategories = SkillCategory::latest()->get();
        
        return view('admin.dashboard', [
            'seminars'=>$seminars,
            'skillCategories' => $skillCategories
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

    public function schoolExperienceStore(Request $request){
        $validated = $request->validate([ 
            'company' => 'required|string|max:255',
            'department' => 'required|string|max:255', 
            'location' => 'required|string|max:255',
            'event' => 'required|string|max:255',
            'start_date' => 'required|date', 
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);
 

        auth()->user()->schoolExperience()->create($validated);
        return redirect()->back()->with('success', 'School Experience added successfully!');
    }


    public function skillCategory(Request $request){

        $validated = $request->validate([ 
            'name' => 'required|string|max:255'
        ]); 

        auth()->user()->schoolExperience()->create($validated);
        return redirect()->back()->with('success', 'School Experience added successfully!');
    }


    public function skill(Request $request){

        $validated = $request->validate([ 
            'company_id'     => ['required', 'exists:companies,id'],
            'name' => 'required|string|max:255'
        ]); 

        auth()->user()->skill()->create($validated);
        return redirect()->back()->with('success', 'School Experience added successfully!');
    }
}
