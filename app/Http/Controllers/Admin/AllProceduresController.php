<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AllProceduresController extends Controller
{
    public function index()
    {
        return view('admin.all-procedures.index');
    }

    public function data(Request $request)
    {
        $search = $request->get('search')['value'] ?? '';

        $query = Procedure::query()
            ->with([
                'document_type:id,name',
                'category:id,name',
                'priority:id,name',
                'state:id,name',
                'applicant' // relación polimórfica
            ])
            ->select('id', 'ticket', 'expedient_number', 'reason', 'description', 'document_type_id', 'procedure_category_id', 'procedure_priority_id', 'procedure_state_id', 'applicant_id', 'applicant_type');

        // Si hay un término de búsqueda
        if (!empty($search)) {
            // Buscar en campos directos de la tabla procedures
            $query->where(function ($q) use ($search) {
                $q->where('expedient_number', 'like', "%{$search}%")
                    ->orWhere('reason', 'like', "%{$search}%")
                    ->orWhere('ticket', 'like', "%{$search}%");

                // Buscar en las relaciones polimórficas

                // 1. Buscar en personas
                $personIds = \App\Models\Person::where('name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('second_last_name', 'like', "%{$search}%")
                    ->orWhere('identity_number', 'like', "%{$search}%")
                    ->pluck('id')
                    ->toArray();

                if (!empty($personIds)) {
                    $q->orWhere(function ($subQ) use ($personIds) {
                        $subQ->where('applicant_type', \App\Models\Person::class)
                            ->whereIn('applicant_id', $personIds);
                    });
                }

                // 2. Buscar personas asociadas a representantes legales
                $personIdsFromLR = \App\Models\Person::where('name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('second_last_name', 'like', "%{$search}%")
                    ->orWhere('identity_number', 'like', "%{$search}%")
                    ->pluck('id')
                    ->toArray();

                $lrIds = \App\Models\LegalRepresentative::whereIn('person_id', $personIdsFromLR)
                    ->pluck('id')
                    ->toArray();

                if (!empty($lrIds)) {
                    $q->orWhere(function ($subQ) use ($lrIds) {
                        $subQ->where('applicant_type', \App\Models\LegalRepresentative::class)
                            ->whereIn('applicant_id', $lrIds);
                    });
                }

                // 3. Buscar personas asociadas a usuarios
                $personIdsFromUser = \App\Models\Person::where('name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('second_last_name', 'like', "%{$search}%")
                    ->orWhere('identity_number', 'like', "%{$search}%")
                    ->pluck('id')
                    ->toArray();

                $userIds = \App\Models\User::whereIn('person_id', $personIdsFromUser)
                    ->pluck('id')
                    ->toArray();

                if (!empty($userIds)) {
                    $q->orWhere(function ($subQ) use ($userIds) {
                        $subQ->where('applicant_type', \App\Models\User::class)
                            ->whereIn('applicant_id', $userIds);
                    });
                }
            });
        }

        $datatable = DataTables::of($query);

        // Añadir columnas calculadas (mantén tu código existente)
        $datatable->addColumn('applicant_name', function ($row) {
            if ($row->applicant_type === \App\Models\Person::class) {
                return $row->applicant->name . ' ' . $row->applicant->last_name . ' ' . $row->applicant->second_last_name;
            }

            if ($row->applicant_type === \App\Models\LegalRepresentative::class) {
                return $row->applicant->person->name . ' ' . $row->applicant->person->last_name  . ' ' . $row->applicant->person->second_last_name;
            }

            if ($row->applicant_type === \App\Models\User::class) {
                return $row->applicant->person->name . ' ' . $row->applicant->person->last_name . ' ' . $row->applicant->person->second_last_name;
            }

            return '—';
        });

        $datatable->addColumn('applicant_identity', function ($row) {
            if ($row->applicant_type === \App\Models\Person::class) {
                return $row->applicant->identity_number;
            }

            if ($row->applicant_type === \App\Models\LegalRepresentative::class) {
                return $row->applicant->person->identity_number;
            }

            if ($row->applicant_type === \App\Models\User::class) {
                return $row->applicant->person->identity_number;
            }

            return '—';
        });

        $datatable->addColumn('document_type_name', function ($row) {
            return $row->document_type ? $row->document_type->name : '—';
        });

        $datatable->addColumn('category_name', function ($row) {
            return $row->category ? $row->category->name : '—';
        });

        $datatable->addColumn('priority_name', function ($row) {
            return $row->priority ? $row->priority->name : '—';
        });

        $datatable->addColumn('state_name', function ($row) {
            return $row->state ? $row->state->name : '—';
        });

        $datatable->addColumn('actions', function ($row) {
            return ''; // Las acciones se renderizan en el frontend
        });

        // Especificar solo las columnas que queremos en la respuesta
        return $datatable->only([
            'id',
            'ticket',
            'expedient_number',
            'reason',
            'description',
            'document_type_name',
            'category_name',
            'priority_name',
            'state_name',
            'applicant_name',
            'applicant_identity',
            'actions'
        ])
            ->rawColumns(['actions'])
            ->make(true);
    }
}
