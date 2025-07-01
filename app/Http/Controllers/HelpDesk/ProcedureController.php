<?php

namespace App\Http\Controllers\HelpDesk;

use App\Http\Controllers\Controller;
use App\Models\LegalPerson;
use App\Models\Procedure;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    public function create()
    {
        return view('helpdesk.procedures.create');
    }

    public function consult()
    {
        return view('helpdesk.procedures.consult');
    }
}
