<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Question;
use App\Models\Type;

class ManageQuestions extends Component
{
    use WithPagination;

    // Pour la pagination avec Bootstrap/Tailwind
    protected $paginationTheme = 'bootstrap';

    // Propriétés pour les filtres
    public $search = '';
    public $categoryFilter = '';
    public $typeFilter = '';

    // Propriétés pour la modal
    public $isModalOpen = false;
    public $questionId;
    public $intitule, $categorie, $obligatoire = false, $type_id;

    // Règles de validation
    protected $rules = [
        'intitule' => 'required|string|min:5',
        'categorie' => 'nullable|string|max:255',
        'type_id' => 'required|exists:types,id',
        'obligatoire' => 'required|boolean',
    ];

    public function render()
    {
        $questions = Question::with('type')
            ->where('intitule', 'like', '%'.$this->search.'%')
            ->when($this->categoryFilter, function ($query) {
                $query->where('categorie', $this->categoryFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type_id', $this->typeFilter);
            })
            ->latest() // Trie par date de création, les plus récentes en premier
            ->paginate(10);

        $types = Type::all();
        // Récupère les catégories uniques qui existent réellement en base de données
        $categories = Question::select('categorie')->whereNotNull('categorie')->distinct()->pluck('categorie');

        return view('livewire.admin.manage-questions', [
            'questions' => $questions,
            'types' => $types,
            'categories' => $categories,
        ]); // Spécifie le layout à utiliser
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $this->questionId = $id;
        $this->intitule = $question->intitule;
        $this->categorie = $question->categorie;
        $this->type_id = $question->type_id;
        $this->obligatoire = (bool)$question->obligatoire;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        Question::updateOrCreate(['id' => $this->questionId], [
            'intitule' => $this->intitule,
            'categorie' => $this->categorie,
            'type_id' => $this->type_id,
            'obligatoire' => $this->obligatoire,
        ]);

        session()->flash('message',
            $this->questionId ? 'Question mise à jour avec succès.' : 'Question créée avec succès.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        // Pour plus de sécurité, on vérifie si la question n'est pas déjà utilisée
        // dans une évaluation avant de la supprimer. Pour l'instant, suppression directe.
        Question::find($id)->delete();
        session()->flash('message', 'Question supprimée avec succès.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->reset(['questionId', 'intitule', 'categorie', 'type_id', 'obligatoire']);
    }

    // Cette fonction est appelée à chaque fois que la propriété $search est mise à jour
    public function updatingSearch()
    {
        $this->resetPage(); // Réinitialise la pagination quand on fait une recherche
    }
}