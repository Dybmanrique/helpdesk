<?php

namespace App\Livewire\Helpdesk;

use App\Models\Procedure;
use App\Models\ProcedureState;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination, WithoutUrlPagination;
    public $pendingProcedures = 0;
    public $rejectedProcedures = 0;
    public $archivedProcedures = 0;
    public $closedProcedures = 0;
    public $perPage = 10;
    public $sortCreatedDateDirection = "desc";
    public $procedureState = "";
    public $startDate;
    public $endDate;
    public $search = "";
    public $procedureId;
    public $stateBadgeStyles = [
        'Pendiente' => 'text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-gray-800',
        'Rechazado' => 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-gray-800',
        'Concluido' => 'text-green-600 dark:text-green-400 bg-green-100 dark:bg-gray-800',
        'Archivado' => 'text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800',
    ];

    #[Computed]
    public function procedures()
    {
        return Procedure::select('id', 'expedient_number', 'reason', 'created_at', 'procedure_state_id')
            ->with('state:id,name')
            ->whereHas('applicant', function ($query) {
                $query->where('id', Auth::id())->where('applicant_type', User::class);
            })
            ->where(function ($query) {
                // filtrar con el campo de búsqueda por núm. expediente o asunto
                $query->where('expedient_number', 'like', "%{$this->search}%")
                    ->orWhere('reason', 'like', "%{$this->search}%");
            })
            ->where(function ($query) {
                // filtrar por fecha de inicio y/o fecha de fin
                if ($this->startDate && $this->endDate) {
                    $query->whereDate('created_at', '>=', $this->startDate)
                        ->whereDate('created_at', '<=', $this->endDate);
                } elseif ($this->startDate) {
                    $query->whereDate('created_at', '>=', $this->startDate);
                } elseif ($this->endDate) {
                    $query->whereDate('created_at', '<=', $this->endDate);
                }
            })
            ->when($this->procedureState, function ($query) {
                // filtrar por estado de trámite
                $query->where('procedure_state_id', $this->procedureState);
            })
            ->orderBy('created_at', $this->sortCreatedDateDirection)
            ->paginate($this->perPage);
    }

    public function updatedProcedureState()
    {
        $this->resetPage();
    }
    public function updatedStartDate()
    {
        $this->resetPage();
    }
    public function updatedEndDate()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        // seleccionar los estados de los trámites que se contarán
        $statesToCount = ProcedureState::whereIn('name', ['Pendiente', 'Rechazado', 'Archivado', 'Concluido'])
            ->pluck('name', 'id');
        // contar los trámites por estado entre los trámites registrados por el usuario
        $proceduresByStates = Procedure::selectRaw('procedure_state_id, COUNT(*) as total')
            ->whereHas('applicant', function ($query) {
                $query->where('id', Auth::id())->where('applicant_type', User::class);
            })
            ->whereIn('procedure_state_id', $statesToCount->keys())
            ->whereYear('created_at', now()->year)
            ->groupBy('procedure_state_id')
            ->get();
        // asigno el total contado a la variable respectiva
        foreach ($proceduresByStates as $proceduresByState) {
            $stateName = $statesToCount[$proceduresByState->procedure_state_id] ?? null;
            if ($stateName === 'Pendiente') {
                $this->pendingProcedures = $proceduresByState->total;
            } elseif ($stateName === 'Rechazado') {
                $this->rejectedProcedures = $proceduresByState->total;
            } elseif ($stateName === 'Archivado') {
                $this->archivedProcedures = $proceduresByState->total;
            } elseif ($stateName === 'Concluido') {
                $this->closedProcedures = $proceduresByState->total;
            }
        }
    }

    public function render()
    {
        $procedureStates = ProcedureState::select('id', 'name')->get();
        return view('livewire.helpdesk.dashboard', ['procedureStates' => $procedureStates]);
    }

    public function changeSortDirection()
    {
        // cambiar el orden en que se muestran los trámites según la fecha de creación
        $this->sortCreatedDateDirection = $this->sortCreatedDateDirection === 'desc' ? 'asc' : 'desc';
        // reinicio la paginación
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['procedureState', 'startDate', 'endDate']);
    }

    public function getProcedureInformation($procedureId)
    {
        // asigno el id del trámite a una variable para enviarlo al componente que cargará la información en el modal
        $this->procedureId = $procedureId;
        $this->dispatch('open-modal', name: 'procedure-information-modal');
    }
}
