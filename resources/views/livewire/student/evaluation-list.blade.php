<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Mes Évaluations</h1>
                <p class="mt-2 text-gray-600">
                    Voici la liste des évaluations que vous devez compléter. Votre avis est important et confidentiel.
                </p>

                <div class="mt-6 space-y-4">
                    @forelse($evaluations as $participant)
                        <div class="block p-6 rounded-lg border {{ $participant->statut === 'completee' ? 'bg-gray-50 border-gray-200' : 'bg-white border-blue-300 shadow-md' }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-semibold">{{ $participant->evaluation->titre }}</h2>
                                    <p class="text-sm text-gray-500">Cours : {{ $participant->evaluation->cour->nom }}</p>
                                    <p class="text-sm text-gray-500">À compléter avant le : {{ $participant->evaluation->date_expiration->format('d/m/Y') }}</p>
                                </div>
                                <div class="mt-2 sm:mt-0">
                                    @if($participant->statut === 'en attente')
                                        <a href="#" {{-- Le lien pointera vers la page du formulaire d'évaluation --}}
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Commencer
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-4 py-2 bg-green-100 border border-green-300 rounded-md font-semibold text-xs text-green-800 uppercase tracking-widest">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Terminé
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-8 border-2 border-dashed rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900">Aucune évaluation pour le moment !</h3>
                            <p class="mt-1 text-sm text-gray-500">Revenez plus tard pour voir si de nouvelles évaluations sont disponibles.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>