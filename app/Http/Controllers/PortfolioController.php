<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Skill;
use App\Models\Experience;
use App\Models\SchoolExperience;
use App\Models\Seminar;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('portfolio.index');

        // $skills = Skill::orderBy('category')
        // ->orderBy('name')
        // ->get()
        // ->groupBy('category');

        // $experiences = Experience::latest()->get();

        // $schoolExperiences = SchoolExperience::latest()->get();

        // $seminars = Seminar::latest()->get();

        // return view('portfolio.index', compact(
        //     'skills',
        //     'experiences',
        //     'schoolExperiences',
        //     'seminars'
        // ));
    }
}
