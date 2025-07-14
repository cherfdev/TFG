<div>
    <div class="p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-md">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Gestion des Évaluations</h1>
                <p class="mt-1 text-sm text-gray-500">Créez, planifiez et suivez les campagnes d'évaluation.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.evaluations.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Nouvelle Évaluation
                </a>
            </div>
        </div>

        {{-- Tableau des évaluations --}}
        <div class="mt-6 flex flex-col">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expire le</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($evaluations as $evaluation)
                            <tr>
                                <td class="px-6 py-4">{{ $evaluation->titre }}</td>
                                <td class="px-6 py-4">{{ $evaluation->cour->nom ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span @class([
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        'bg-yellow-100 text-yellow-800' => $evaluation->statut === 'brouillon',
                                        'bg-green-100 text-green-800' => $evaluation->statut === 'actif',
                                        'bg-gray-100 text-gray-800' => $evaluation->statut === 'termine',
                                    ])>
                                        {{ ucfirst($evaluation->statut) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $evaluation->date_expiration->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('admin.evaluations.edit', $evaluation) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-4 text-center">Aucune évaluation pour le moment.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $evaluations->links() }}</div>
        </div>
    </div>
</div>