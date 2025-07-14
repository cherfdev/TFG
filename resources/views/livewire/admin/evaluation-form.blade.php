<div>
    <form wire:submit.prevent="save(false)">
        <div class="p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-md">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $evaluation->id ? 'Modifier l\'Évaluation' : 'Créer une Évaluation' }}</h1>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Colonne de gauche: Configuration --}}
                <div class="space-y-6">
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700">Titre de l'évaluation</label>
                        <input type="text" id="titre" wire:model.defer="evaluation.titre" class="mt-1 block w-full form-input">
                        @error('evaluation.titre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="cour_id" class="block text-sm font-medium text-gray-700">Cours concerné</label>
                        <select id="cour_id" wire:model.defer="evaluation.cour_id" class="mt-1 block w-full form-select">
                            <option value="">Choisir un cours</option>
                            @foreach($allCourses as $cour)
                                <option value="{{ $cour->id }}">{{ $cour->nom }}</option>
                            @endforeach
                        </select>
                        @error('evaluation.cour_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="date_expiration" class="block text-sm font-medium text-gray-700">Date d'expiration</label>
                        <input type="date" id="date_expiration" wire:model.defer="evaluation.date_expiration" class="mt-1 block w-full form-input">
                        @error('evaluation.date_expiration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description / Consignes</label>
                        <textarea id="description" wire:model.defer="evaluation.description" rows="4" class="mt-1 block w-full form-textarea"></textarea>
                    </div>
                </div>

                {{-- Colonne de droite: Sélection des questions --}}
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700">Choisissez les questions</label>
                    @error('selectedQuestions') <div class="text-red-500 text-xs mb-2">{{ $message }}</div> @enderror
                    <div class="h-96 overflow-y-auto border border-gray-200 rounded-md p-4 space-y-2">
                        @forelse($allQuestions->groupBy('categorie') as $category => $questions)
                            <div class="py-2">
                                <h3 class="font-bold text-gray-600">{{ $category ?: 'Non catégorisé' }}</h3>
                                @foreach($questions as $question)
                                    <label for="question-{{$question->id}}" class="flex items-center space-x-3 p-2 rounded-md hover:bg-gray-50">
                                        <input type="checkbox" id="question-{{$question->id}}" value="{{ $question->id }}" wire:model="selectedQuestions" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        <span>{{ $question->intitule }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @empty
                            <p class="text-gray-500">Aucune question dans la banque. <a href="{{ route('admin.questions.index') }}" class="text-blue-500">Ajoutez-en une.</a></p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="mt-8 pt-5 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.evaluations.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Annuler</a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
                        Enregistrer en brouillon
                    </button>
                    <button type="button" wire:click.prevent="save(true)" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Publier l'évaluation
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>