<?php

namespace App\Http\Controllers\HelpDesk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpdeskDashboardController extends Controller
{
    public function dashboard()
    {
        return view('helpdesk.dashboard');
    }
}
