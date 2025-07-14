<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\EvaluationForm;
use App\Livewire\Admin\EvaluationIndex;
use App\Livewire\Admin\ManageQuestions;
use App\Livewire\Student\EvaluationList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified'])->group(function () {
    // La route /dashboard générée par Breeze pointe ici.
    Route::get('/dashboard', EvaluationList::class)->name('dashboard');

    // ... autres routes pour les utilisateurs connectés
});

Route::middleware(['auth', 'verified']) // 'verified' est une bonne pratique si vous utilisez la vérification d'email
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // La syntaxe correcte pour pointer vers un composant Livewire
    Route::get('/questions', ManageQuestions::class)->name('questions.index');

    // Vous pouvez ajouter d'autres routes admin ici
    // Route::get('/dashboard', ...)->name('dashboard');

    Route::get('/evaluations', EvaluationIndex::class)->name('evaluations.index');
Route::get('/evaluations/create', EvaluationForm::class)->name('evaluations.create');
Route::get('/evaluations/{evaluation}/edit', EvaluationForm::class)->name('evaluations.edit');

});

require __DIR__.'/auth.php';
