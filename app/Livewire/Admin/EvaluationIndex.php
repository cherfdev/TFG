<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Evaluation;

class EvaluationIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $evaluations = Evaluation::with('cour')->latest()->paginate(10);

        return view('livewire.admin.evaluation-index', [
            'evaluations' => $evaluations
        ]);
    }
}