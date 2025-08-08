<?php

namespace App\Http\Controllers\HelpDesk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    public function create()
    {
        return view('helpdesk.procedures.create');
    }

    public function consult($ticket = null)
    {
        return view('helpdesk.procedures.consult', compact('ticket'));
    }
}
