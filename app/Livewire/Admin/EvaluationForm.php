<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\Cour;
use Illuminate\Support\Facades\DB;

class EvaluationForm extends Component
{
    public Evaluation $evaluation;
    public $allQuestions = [];
    public $allCourses = [];
    public $selectedQuestions = []; // Stockera les IDs des questions choisies

    protected $rules = [
        'evaluation.titre' => 'required|string|max:255',
        'evaluation.description' => 'nullable|string',
        'evaluation.cour_id' => 'required|exists:cours,id',
        'evaluation.date_expiration' => 'required|date|after_or_equal:today',
        'selectedQuestions' => 'required|array|min:1',
    ];

    public function mount(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation->id ? $evaluation : new Evaluation(['date_expiration' => now()->addMonth()]);
        $this->allQuestions = Question::orderBy('categorie')->get();
        $this->allCourses = Cour::orderBy('nom')->get();

        if ($this->evaluation->id) {
            $this->selectedQuestions = $this->evaluation->questions()->pluck('id')->toArray();
        }
    }

    public function toggleQuestion($questionId)
    {
        if (in_array($questionId, $this->selectedQuestions)) {
            $this->selectedQuestions = array_diff($this->selectedQuestions, [$questionId]);
        } else {
            $this->selectedQuestions[] = $questionId;
        }
    }

    public function save($publish = false)
{
    $this->validate();

    $this->evaluation->statut = $publish ? 'actif' : 'brouillon';

    DB::transaction(function () use ($publish) {
        $this->evaluation->save();
        $this->evaluation->questions()->sync($this->selectedQuestions);

        // Si on publie, on peuple la table des participants
        if ($publish && $this->evaluation->wasRecentlyCreated) {
            $students = $this->evaluation->cour->students;
            foreach ($students as $student) {
                // Créer l'entrée pour chaque étudiant inscrit au cours
                \App\Models\EvaluationParticipant::create([
                    'evaluation_id' => $this->evaluation->id,
                    'user_id' => $student->id,
                    'statut' => 'en attente',
                ]);
            }
            // Ici, vous pourriez aussi dispatcher un Job pour envoyer des notifications par email
        }
    });

    session()->flash('message', 'Évaluation enregistrée avec succès.');
    return redirect()->route('admin.evaluations.index');
}

    public function render()
    {
        return view('livewire.admin.evaluation-form');
    }
}