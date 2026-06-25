<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\View\View;
use App\Services\PortfolioService;
class AdminController extends Controller
{
    public function index(): View
    {


        // if (auth()->user()->isAdmin()) {
            
        // }

        
        return view('admin.dashboard');
 
    }

    
    public function seminar(){
        return view('admin.dashboard');
    }
}
