<div>
    <div class="p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-md">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Banque de Questions</h1>
                <p class="mt-1 text-sm text-gray-500">Gérez toutes les questions utilisables dans les évaluations.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button wire:click="create()" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Ajouter une question
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="mt-6 grid grid-cols-1 gap-y-4 md:grid-cols-3 md:gap-x-4">
            <input wire:model.debounce.500ms="search" type="text" placeholder="Rechercher par intitulé..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <select wire:model="categoryFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    @if($cat) <option value="{{ $cat }}">{{ $cat }}</option> @endif
                @endforeach
            </select>
            <select wire:model="typeFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Tous les types</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ ucfirst($type->nom) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-6 flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intitulé</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obligatoire</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($questions as $question)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-900">{{ Str::limit($question->intitule, 60) }}</div></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $question->categorie ?? 'N/A' }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($question->type->nom) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $question->obligatoire ? 'Oui' : 'Non' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="edit({{ $question->id }})" class="text-indigo-600 hover:text-indigo-900">Modifier</button>
                                            <button wire:click="delete({{ $question->id }})" wire:confirm="Êtes-vous sûr de vouloir supprimer cette question ?" class="text-red-600 hover:text-red-900 ml-4">Supprimer</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune question ne correspond à votre recherche.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $questions->links() }}
        </div>
    </div>

    {{-- Modal --}}
    @if($isModalOpen)
        @include('livewire.admin.question-modal')
    @endif
</div>
