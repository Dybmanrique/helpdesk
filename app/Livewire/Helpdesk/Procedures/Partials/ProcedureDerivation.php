<?php

namespace App\Livewire\Helpdesk\Procedures\Partials;

use Livewire\Component;

class ProcedureDerivation extends Component
{
    public $derivation;
    public $derivationStyles;
    public $derivationIcon;
    public $borderStyles;
    public $iconStyles;
    public $badgeStyles;

    public function mount($derivation)
    {
        $this->derivation = $derivation;
        if ($this->derivation['iteration'] < $this->derivation['totalDerivations'] || $this->derivation['totalDerivations'] === 1) {
            // estilos del borde
            $this->borderStyles = 'border-l-green-500';
            // estilos del icono
            $icon = $this->getDerivationIcon($this->derivation['state']) ?? 'fa-regular fa-circle-check fa-lg';
            $this->iconStyles = $icon . ' text-green-600 dark:text-green-400';
            // estilos del badge
            $this->badgeStyles = 'text-green-700 dark:text-green-500 border-green-700 dark:border-green-500';
        } else {
            $derivationStyles = $this->getDerivationStyles($this->derivation['state']);
            // estilos del borde
            $this->borderStyles = $derivationStyles['border'];
            // estilos del icono
            $icon = $this->getDerivationIcon($this->derivation['state']) ?? 'fa-regular fa-clock fa-lg';
            $iconStyle = $derivationStyles['icon'];
            $this->iconStyles = $icon . ' ' . $iconStyle;
            // estilos del badge
            $this->badgeStyles = $derivationStyles['badge'];
        }
    }

    public function render()
    {
        return view('livewire.helpdesk.procedures.partials.procedure-derivation');
    }

    public function getDerivationStyles($lastActionName)
    {
        return match ($lastActionName) {
            'Derivar' => [
                'border' => 'border-l-yellow-500',
                'icon' => 'text-yellow-600 dark:text-yellow-400',
                'badge' => 'text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-gray-800 border-yellow-600 dark:border-yellow-400',
            ],
            'Anular' => [
                'border' => 'border-l-red-500',
                'icon' => 'red-600 dark:text-red-400',
                'badge' => 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-gray-800 border-red-600 dark:border-red-400',
            ],
            'Concluir' => [
                'border' => 'border-l-green-500',
                'icon' => 'text-green-600 dark:text-green-400',
                'badge' => 'text-green-600 dark:text-green-400 bg-green-100 dark:bg-gray-800 border-green-600 dark:border-green-400',
            ],
            'Archivar' => [
                'border' => 'border-l-gray-500',
                'icon' => 'text-gray-600 dark:text-gray-400',
                'badge' => 'text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 border-gray-600 dark:border-gray-400',
            ],
            'Comentar' => [
                'border' => 'border-l-blue-500',
                'icon' => 'text-blue-600 dark:text-blue-400',
                'badge' => 'text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-gray-800 border border-blue-600 dark:border-blue-400',
            ],
            default => [
                'border' => 'border-l-blue-500',
                'icon' => 'text-blue-600 dark:text-blue-400',
                'badge' => 'text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-gray-800 border border-blue-600 dark:border-blue-400',
            ],
        };
    }

    public function getDerivationIcon($lastActionName)
    {
        return match ($lastActionName) {
            'Derivar' => 'fa-regular fa-circle-right fa-lg',
            'Anular' => 'fa-solid fa-ban fa-lg',
            'Concluir' => 'fa-regular fa-circle-check fa-lg',
            'Archivar' => 'fa-regular fa-circle-stop fa-lg',
            'Comentar' => 'fa-regular fa-comment fa-lg',
            default => null
        };
    }
}
