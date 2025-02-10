<?php

namespace App\Http\Controllers\HelpDesk;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Models\IdentityType;
use App\Models\LegalPerson;
use App\Models\ProcedureCategory;
use App\Models\ProcedurePriority;
use Illuminate\Support\Facades\Auth;

class ProcedureController extends Controller
{
    public function create()
    {
        $identity_types = IdentityType::all();
        $priorities = ProcedurePriority::all();
        $categories = ProcedureCategory::all();
        $document_types = DocumentType::all();
        $user = Auth::user();
        $legal_person = LegalPerson::where('person_id', $user->person_id)->first();
        if ($legal_person) {
            $identity_number = $legal_person->ruc;
        } else {
            $identity_number = $user->person->identity_number;
        }
        return view('helpdesk.procedures.create', compact('identity_types', 'priorities', 'categories', 'document_types', 'user', 'identity_number'));
    }
    public function search()
    {
        return view('helpdesk.procedures.search');
    }
}
