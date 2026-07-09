<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TicklerController extends Controller
{
    

    public function index(): View 
    { 
        return view('tickler.index', [
            'item' => 'item'
        ]);
    }  
}
