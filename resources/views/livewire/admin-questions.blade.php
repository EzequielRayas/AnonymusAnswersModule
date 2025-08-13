<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Panel de Administración de Preguntas
                    </h2>
                    <div class="text-sm text-gray-600">
                        Total: {{ $counts['total'] }} preguntas
                    </div>
                </div>
            </div>

            <!-- Mensajes de estado -->
            @if($successMessage)
                <div x-data="{ show: true }" 
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => { show = false; $wire.clearMessages(); }, 5000)"
                     class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-6 mt-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-light">{{ $successMessage }}</span>
                    </div>
                </div>
            @endif

            @if($errorMessage)
                <div x-data="{ show: true }" 
                     x-show="show"
                     x-transition
                     x-init="setTimeout(() => { show = false; $wire.clearMessages(); }, 5000)"
                     class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-6 mt-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-light">{{ $errorMessage }}</span>
                    </div>
                </div>
            @endif

            <!-- Botón para crear nueva pregunta -->
            <div class="px-6 py-4 bg-blue-50 flex justify-center">
                <button wire:click="openCreateModal"
                        class="flex items-center px-6 py-3 backdrop-blur-sm bg-white/80 text-blue-600 border border-white/20 rounded-xl shadow-xs hover:shadow-sm transition-all duration-300 hover:bg-blue-600 hover:text-white hover:border-blue-600/10">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span class="font-medium">Nueva Pregunta</span>
                </button>
            </div>

            <!-- Filtros y controles -->
            <div class="px-6 py-4 bg-gray-50 border-b">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Filtro por estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select wire:model.live="filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all">Todas ({{ $counts['total'] }})</option>
                            <option value="active">Activas ({{ $counts['active'] }})</option>
                            <option value="inactive">Inactivas ({{ $counts['inactive'] }})</option>
                            <option value="deleted">Eliminadas ({{ $counts['deleted'] }})</option>
                        </select>
                    </div>

                    <!-- Búsqueda -->
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar pregunta</label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Buscar por contenido de pregunta..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                    </div>
                </div>
            </div>

            <!-- Tabla de preguntas -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pregunta
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Creada por
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fechas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Respuestas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($questions as $question)
                            <tr>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-900">
                                    <div class="max-w-xs">
                                        {{ $question->question }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $question->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($question->status_color === 'green') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $question->status_text }}
                                    </span>
                                    @if($question->trashed())
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Eliminada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>Inicio: {{ \Carbon\Carbon::parse($question->start_date)->format('d/m/Y') }}</div>
                                    <div>Fin: {{ \Carbon\Carbon::parse($question->end_date)->format('d/m/Y') }}</div>
                                </td>
                                
                                <!-- Botón de respuestas -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button wire:click="viewAnswers({{ $question->id }})" 
                                            class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm hover:bg-blue-100 transition-colors duration-200 font-light">
                                        {{ $question->answers_count }} respuesta{{ $question->answers_count !== 1 ? 's' : '' }}
                                    </button>
                                </td>

                                <!-- Acciones de preguntas -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($question->trashed())
                                            <!-- Restaurar -->
                                            <button 
                                                wire:click="restore({{ $question->id }})"
                                                wire:confirm="¿Estás seguro de restaurar esta pregunta?"
                                                class="text-green-600 hover:text-green-900">
                                                Restaurar
                                            </button>
                                            <!-- Eliminar permanentemente -->
                                            <button 
                                                wire:click="forceDelete({{ $question->id }})"
                                                wire:confirm="¡Cuidado! ¿Estás seguro de ELIMINAR PERMANENTEMENTE esta pregunta? Esto no se puede deshacer."
                                                class="text-red-600 hover:text-red-900">
                                                Borrar Def.
                                            </button>
                                        @else
                                            <!-- Editar -->
                                            <button wire:click="edit({{ $question->id }})" 
                                                    class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-md transition-colors duration-200" title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <!-- Cambiar Estado -->
                                            {{-- <button wire:click="toggleStatus({{ $question->id }})" 
                                                    wire:confirm="¿Estás seguro de cambiar el estado de esta pregunta?"
                                                    class="p-2 
                                                        @if($question->status_color === 'green') text-green-600 hover:text-green-900 hover:bg-green-50
                                                        @else text-gray-600 hover:text-gray-900 hover:bg-gray-50 @endif
                                                        rounded-md transition-colors duration-200" title="Cambiar Estado">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($question->status)
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    @endif
                                                </svg>
                                            </button>  --}}
                                            <!-- Eliminar -->
                                            <button wire:click="confirmDelete({{ $question->id }})" 
                                                    class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-md transition-colors duration-200" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    No se encontraron preguntas con los filtros aplicados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($questions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $questions->links() }}
                </div>
            @endif

        </div>
    </div>

    <!-- MODAL DE RESPUESTAS INTEGRADO -->
    @if($showAnswersModal && $selectedQuestionForAnswers)
        <div class="fixed inset-0 overflow-y-auto z-50" 
             x-data="{ modalOpen: @entangle('showAnswersModal').live }"
             x-show="modalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             wire:key="answers-modal-{{ $selectedQuestionForAnswers }}">
            
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo oscuro -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                     @click="modalOpen = false; $wire.closeAnswersModal()"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                </div>
                
                <!-- Contenido del modal -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl sm:w-full max-h-[90vh] overflow-y-auto"
                     @click.stop
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <!-- Header del modal -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 bg-gray-50 sticky top-0 z-10">
                        <h3 class="text-lg font-medium text-gray-900">
                            Panel de Respuestas - Pregunta #{{ $selectedQuestionForAnswers }}
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-600">
                                Total: {{ $answersCounts['total'] }} respuestas
                            </div>
                            <button @click="modalOpen = false; $wire.closeAnswersModal()"
                                    class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition-colors duration-200 p-2 hover:bg-gray-200 rounded-full">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Filtros para respuestas -->
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Filtro por estado -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                <select wire:model.live="answersFilter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="pending">Pendientes ({{ $answersCounts['pending'] }})</option>
                                    <option value="approved">Aprobadas ({{ $answersCounts['approved'] }})</option>
                                    <option value="rejected">Rechazadas ({{ $answersCounts['rejected'] }})</option>
                                    <option value="deleted">Eliminadas ({{ $answersCounts['deleted'] }})</option>
                                    <option value="all">Todas ({{ $answersCounts['total'] }})</option>
                                </select>
                            </div>

                            <!-- Búsqueda -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar respuesta</label>
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.300ms="answersSearch" 
                                    placeholder="Buscar por contenido de respuesta..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de respuestas -->
                    <div class="bg-white">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full max-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-1/2 max-w-md px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Respuesta
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
                                <tbody class="max-w-full bg-white divide-y divide-gray-200">
                                    @forelse($filteredAnswers as $answer)
                                        <tr>
                                            <td class="w-1/2 max-w-md break-words px-6 py-4 whitespace-normal text-sm text-gray-900">
                                                <div class="max-w-xs">
                                                    {{ $answer->answer }}
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
                                                            wire:click="restoreAnswer({{ $answer->id }})"
                                                            wire:confirm="¿Estás seguro de restaurar esta respuesta?"
                                                            class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded hover:bg-green-200 transition-colors">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                            </svg>
                                                            Restaurar
                                                        </button>
                                                    @else
                                                        @if($answer->status !== \App\Models\FantasyAnswer::STATUS_APPROVED)
                                                            <!-- Aprobar -->
                                                            <button 
                                                                wire:click="approveAnswer({{ $answer->id }})"
                                                                class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded hover:bg-green-200 transition-colors">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                                </svg>
                                                                Aprobar
                                                            </button>
                                                        @endif

                                                        @if($answer->status !== \App\Models\FantasyAnswer::STATUS_REJECTED)
                                                            <!-- Rechazar -->
                                                            <button 
                                                                wire:click="rejectAnswer({{ $answer->id }})"
                                                                class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded hover:bg-red-200 transition-colors">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                </svg>
                                                                Rechazar
                                                            </button>
                                                        @endif

                                                        
                                                              @if($answersFilter !== 'pending')
                                                        <!-- Eliminar -->
                                                        <button 
                                                            wire:click="softDeleteAnswer({{ $answer->id }})"
                                                            wire:confirm="¿Estás seguro de eliminar esta respuesta?"
                                                            class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded hover:bg-gray-200 transition-colors">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Eliminar
                                                        </button>
                                                        @endif
                                                        

                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                                <svg class="w-8 h-8 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                No se encontraron respuestas.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación para respuestas -->
                        @if($filteredAnswers->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $filteredAnswers->links() }}
                            </div>
                        @endif
                    </div>

                                <!-- Paginación -->
            {{-- @if($answers->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $answers->links() }}
                </div>
            @endif --}}

                    {{-- <div wire:key="answers-pagination-{{ $filteredAnswers->currentPage() }}">
    {{ $filteredAnswers->links() }}
</div> --}}

                    <!-- Footer del modal -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 sticky bottom-0">
                        <div class="flex justify-end">
                            <button @click="modalOpen = false; $wire.closeAnswersModal()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cerrar Panel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modales para gestión de preguntas -->
    <!-- CREATE MODAL -->
    <x-dialog-modal wire:model="showCreateModal">
        <x-slot name="title">
            Crear Nueva Pregunta Fantasy
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="question" value="Pregunta" />
                <x-input id="question" type="text" class="mt-1 block w-full" wire:model.defer="question" />
                <x-input-error for="question" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="start_date" value="Fecha de Inicio" />
                <x-input id="start_date" type="date" class="mt-1 block w-full" wire:model.defer="start_date" />
                <x-input-error for="start_date" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="end_date" value="Fecha de Fin" />
                <x-input id="end_date" type="date" class="mt-1 block w-full" wire:model.defer="end_date" />
                <x-input-error for="end_date" class="mt-2" />
            </div>
            {{-- <div class="mt-4">
                <x-label for="status" value="Estado" />
                <input id="status" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.defer="status" /> Activa
                <x-input-error for="status" class="mt-2" />
            </div> --}}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeCreateModal" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
            <x-button class="ml-3" wire:click="store" wire:loading.attr="disabled">
                Guardar Pregunta
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- EDIT MODAL -->
    <x-dialog-modal wire:model="showEditModal">
        <x-slot name="title">
            Editar Pregunta Fantasy
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="editQuestion" value="Pregunta" />
                <x-input id="editQuestion" type="text" class="mt-1 block w-full" wire:model.defer="editQuestion" />
                <x-input-error for="editQuestion" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="editStartDate" value="Fecha de Inicio" />
                <x-input id="editStartDate" type="date" class="mt-1 block w-full" wire:model.defer="editStartDate" />
                <x-input-error for="editStartDate" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="editEndDate" value="Fecha de Fin" />
                <x-input id="editEndDate" type="date" class="mt-1 block w-full" wire:model.defer="editEndDate" />
                <x-input-error for="editEndDate" class="mt-2" />
            </div>
            {{-- <div class="mt-4">
                <x-label for="editStatus" value="Estado" />
                <input id="editStatus" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" wire:model.defer="editStatus" /> Activa
                <x-input-error for="editStatus" class="mt-2" />
            </div> --}}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
            <x-button class="ml-3" wire:click="update" wire:loading.attr="disabled">
                Actualizar Pregunta
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- DELETE CONFIRMATION MODAL -->
    <x-dialog-modal wire:model="showDeleteModal">
        <x-slot name="title">
            Eliminar Pregunta
        </x-slot>

        <x-slot name="content">
            ¿Estás seguro de que deseas eliminar esta pregunta? Esto la marcará como eliminada, pero podrás restaurarla.
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
            <x-danger-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                Eliminar
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Script para cerrar modal con ESC -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && @this.showAnswersModal) {
                    @this.closeAnswersModal();
                }
            });
        });

        //Script para paginacion
        document.addEventListener('livewire:init', () => {
    // Interceptar clicks en la paginación del modal
    Livewire.hook('morph.updated', ({ el }) => {
        if (el.classList && el.classList.contains('pagination')) {
            el.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const page = url.searchParams.get('page');
                    if (page) {
                        @this.set('answers_page', page);
                    }
                });
            });
        }
    });
});
    </script>

</div>