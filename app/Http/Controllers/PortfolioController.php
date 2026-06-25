<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Skill;
use App\Models\Experience;
use App\Models\SchoolExperience;
use App\Models\Seminar;
use Illuminate\View\View;
use App\Services\PortfolioService;  
class PortfolioController extends Controller
{
    protected $portfolioService; 

    public function __construct(PortfolioService $portfolioService){
        $this->portfolioService = $portfolioService;
    } 
 
    public function index(Request $request): View
    { 
        // if (auth()->user()->isAdmin()) {
           
        // }
        $data = $this->portfolioService->getPortfolioData($request->user());
   
        return view('portfolio.index', [
            'user' => $data['user']
        ]);
 
    }

}
