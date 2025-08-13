<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Panel de Administración y Moderación de Respuestas Fantasy
                    </h2>
                    <div class="text-sm text-gray-600">
                        Total: {{ $counts['total'] }} respuestas
                    </div>
  <!-- Botón para cerrar modal cuando está en modo modal -->
                        {{-- @if($isModal)
                            <button wire:click="closeModal" 
                                    class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cerrar
                            </button>
                        @endif --}}

                </div>
                
            </div>




                @if(!$isModal)
            <div class="px-6 py-4 bg-blue-50 flex justify-center">
    <!-- Botón para ir a preguntas -->
    <a href="{{ route('admin.questions') }}"
       class="flex items-center px-6 py-3 backdrop-blur-sm bg-white/80 text-indigo-600 border border-white/20 rounded-xl shadow-xs hover:shadow-sm transition-all duration-300 hover:bg-indigo-600 hover:text-white hover:border-indigo-600/10">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <span class="font-medium">Panel de Preguntas</span>
    </a>
</div>
@endif
            <!-- Mensajes de estado -->
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-6 mt-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-6 mt-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filtros y controles -->
            <div class="px-6 py-4 bg-gray-50 border-b">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    
                    <!-- Filtro por estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select wire:model.live="filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending">Pendientes ({{ $counts['pending'] }})</option>
                            <option value="approved">Aprobadas ({{ $counts['approved'] }})</option>
                            <option value="rejected">Rechazadas ({{ $counts['rejected'] }})</option>
                            <option value="deleted">Eliminadas ({{ $counts['deleted'] }})</option>
                            <option value="all">Todas ({{ $counts['total'] }})</option>
                        </select>
                    </div>

                    <!-- Filtro por pregunta -->
                    @if(!$isModal)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pregunta</label>
                        <select wire:model.live="selectedQuestion" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todas las preguntas</option>
                            @foreach($questions->take(10) as $question)
                                <option value="{{ $question->id }}">{{ Str::limit($question->question, 50) }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <!-- Búsqueda -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar respuesta</label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Buscar por contenido de respuesta..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>
                </div>
            </div>

            <!-- Tabla de respuestas -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Respuesta
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pregunta
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($answers as $answer)
                            <tr>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-900">
                                    <div class="max-w-xs">
                                        {{ $answer->answer }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    <div class="max-w-xs">
                                        {{ Str::limit($answer->question->question ?? 'N/A', 60) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($answer->status_color === 'green') bg-green-100 text-green-800
                                        @elseif($answer->status_color === 'yellow') bg-yellow-100 text-yellow-800
                                        @elseif($answer->status_color === 'red') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $answer->status_text }}
                                    </span>
                                    @if($answer->trashed())
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Eliminada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $answer->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($answer->trashed())
                                            <!-- Restaurar -->
                                            <button 
                                                wire:click="restore({{ $answer->id }})"
                                                wire:confirm="¿Estás seguro de restaurar esta respuesta?"
                                                class="text-green-600 hover:text-green-900">
                                                Restaurar
                                            </button>
                                        @else
                                            @if($answer->status !== \App\Models\FantasyAnswer::STATUS_APPROVED)
                                                <!-- Aprobar -->
                                                <button 
                                                    wire:click="approve({{ $answer->id }})"
                                                    class="text-green-600 hover:text-green-900">
                                                    Aprobar
                                                </button>
                                            @endif

                                            @if($answer->status !== \App\Models\FantasyAnswer::STATUS_REJECTED)
                                                <!-- Rechazar -->
                                                <button 
                                                    wire:click="reject({{ $answer->id }})"
                                                    class="text-red-600 hover:text-red-900">
                                                    Rechazar
                                                </button>
                                            @endif

                                            <!-- Eliminar -->
                                            <button 
                                                wire:click="softDelete({{ $answer->id }})"
                                                wire:confirm="¿Estás seguro de eliminar esta respuesta?"
                                                class="text-gray-600 hover:text-gray-900">
                                                Eliminar
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No se encontraron respuestas con los filtros aplicados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($answers->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $answers->links() }}
                </div>
            @endif

        </div>
    </div>
</div>