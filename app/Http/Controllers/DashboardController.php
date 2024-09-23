<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    function Dashboard():View{
        return view('pages.dashboard.dashboard-page');
    }
}
