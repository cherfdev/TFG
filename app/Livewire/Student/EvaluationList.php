<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\EvaluationParticipant;

class EvaluationList extends Component
{
    public function render()
    {
        $userId = Auth::id();

        $evaluations = EvaluationParticipant::where('user_id', $userId)
            ->with(['evaluation.cour']) // Eager load les relations pour optimiser
            ->whereHas('evaluation', function ($query) {
                $query->where('statut', 'actif')
                      ->where('date_expiration', '>=', now());
            })
            ->orderBy('statut', 'asc') // Affiche "en attente" en premier
            ->get();

        return view('livewire.student.evaluation-list', [
            'evaluations' => $evaluations
        ]); // Utilise le layout principal de l'application
    }
}