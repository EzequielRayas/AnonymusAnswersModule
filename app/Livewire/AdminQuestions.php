<?php

namespace App\Livewire;

use App\Models\FantasyQuestion;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FantasyAnswer;
use Livewire\Attributes\On;

class AdminQuestions extends Component
{
    use WithPagination;

    public $showModal = true; 

    public $questionId;
    // Propiedades para la creación/edición de preguntas
    public $question;
    public $start_date;
    public $end_date;
    public $status = 0; // Default: Inactiva
    
    public $editQuestion;
    public $editStartDate;
    public $editEndDate;
    public $editStatus;
    
    // Propiedades para la visibilidad de modales
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showAnswersModal = false;

    public $selectedQuestionForAnswers = null;
    public $selectedQuestionId;
    public $selectedQuestionAnswers;
    
    // Propiedades para mensajes de estado
    public $successMessage;
    public $errorMessage;
    
    // Propiedades para filtros y búsqueda
    public $filter = 'pending'; // all, active, inactive, deleted
    public $search = '';

    // NUEVAS PROPIEDADES PARA MANEJO DE RESPUESTAS EN EL MODAL
    public $answersFilter = 'pending'; // pending, approved, rejected, all, deleted
    public $answersSearch = '';
    public $answersPage = 1;

    protected $queryString = [
        'filter' => ['except' => 'pending'],
        'search' => ['except' => ''],
        'answersPage' => ['except' => 1],
    ];

    // Agregar listener para cerrar modal desde componente hijo
    protected $listeners = [
        'closeAnswersModal' => 'closeAnswersModal',
        'answerUpdated' => '$refresh'
    ];

    // Reglas de validación básicas
    protected function baseRules()
    {
        return [
            'question' => 'required|string|min:10|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|boolean'
        ];
    }

    // Validación personalizada para fechas superpuestas
    protected function overlappingDatesRule($excludeId = null)
    {
        return function ($attribute, $value, $fail) use ($excludeId) {
            $query = FantasyQuestion::where(function($q) {
                $q->whereBetween('start_date', [$this->start_date, $this->end_date])
                  ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                  ->orWhere(function($q) {
                      $q->where('start_date', '<=', $this->start_date)
                        ->where('end_date', '>=', $this->end_date);
                  });
            });

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if ($query->exists()) {
                $fail('Error! El periodo seleccionado se superpone con una pregunta existente. Por favor, elige otras fechas.');
            }
        };
    }

    // Validación para creación
    public function rulesForCreate()
    {
        $rules = $this->baseRules();
          $rules['start_date'] = [
        'required',
        'date',
        $this->overlappingDatesRule()
    ];
        return $rules;
    }

    // Validación para edición
    public function rulesForEdit()
    {
        $rules = [
            'editQuestion' => 'required|string|min:10|max:255',
            'editStartDate' => [
                'required',
                'date',
                $this->overlappingDatesRule($this->selectedQuestionId)
            ],
            'editEndDate' => 'required|date|after:editStartDate',
            'editStatus' => 'required|boolean'
        ];
        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    //  MÉTODOS PARA MANEJO DE FILTROS DE RESPUESTAS
    public function updatingAnswersSearch()
    {
        $this->answersPage = 1;
    }

    public function updatingAnswersFilter()
    {
        $this->answersPage = 1;
    }

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->question = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->status = 0;
        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function store()
    {
        $this->validate($this->rulesForCreate());

        try {
            FantasyQuestion::create([
                'question' => $this->question,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'status' => $this->status,
                'user_id' => auth()->id()
            ]);

            $this->closeCreateModal();
            $this->successMessage = 'Pregunta creada exitosamente';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al crear la pregunta: ' . $e->getMessage();
        }
    }

    public function edit($id)
    {
        $question = FantasyQuestion::findOrFail($id);
        
        $this->selectedQuestionId = $id;
        $this->editQuestion = $question->question;
        $this->editStartDate = $question->start_date->format('Y-m-d\TH:i');
        $this->editEndDate = $question->end_date->format('Y-m-d\TH:i');
        $this->editStatus = $question->status;
        
        $this->showEditModal = true;
    }

    public function update()
    {
        // Asignamos temporalmente las propiedades de edición a las propiedades principales para la validación
        $this->question = $this->editQuestion;
        $this->start_date = $this->editStartDate;
        $this->end_date = $this->editEndDate;
        $this->status = $this->editStatus;

        $this->validate($this->rulesForEdit());

        try {
            $question = FantasyQuestion::findOrFail($this->selectedQuestionId);
            
            $question->update([
                'question' => $this->editQuestion,
                'start_date' => $this->editStartDate,
                'end_date' => $this->editEndDate,
                'status' => $this->editStatus
            ]);

            $this->showEditModal = false;
            $this->successMessage = 'Pregunta actualizada exitosamente';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al actualizar la pregunta: ' . $e->getMessage();
        }
    }

    public function confirmDelete($id)
    {
        $this->selectedQuestionId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        try {
            FantasyQuestion::findOrFail($this->selectedQuestionId)->delete();
            
            $this->showDeleteModal = false;
            $this->successMessage = 'Pregunta eliminada exitosamente (soft delete).';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al eliminar la pregunta: ' . $e->getMessage();
        }
    }

    public function forceDelete($id)
    {
        try {
            FantasyQuestion::withTrashed()->findOrFail($id)->forceDelete();
            session()->flash('success', 'Pregunta eliminada permanentemente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar permanentemente la pregunta: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            FantasyQuestion::withTrashed()->findOrFail($id)->restore();
            session()->flash('success', 'Pregunta restaurada correctamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al restaurar la pregunta: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $question = FantasyQuestion::findOrFail($id);
            $question->update(['status' => !$question->status]);
            
            $this->successMessage = 'Estado actualizado exitosamente';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al actualizar el estado: ' . $e->getMessage();
        }
    }

    // MÉTODO PRINCIPAL PARA ABRIR EL MODAL DE RESPUESTAS
    public function viewAnswers($id)
    {
        $this->selectedQuestionForAnswers = $id;
        $this->showAnswersModal = true;
        
        // Resetear filtros de respuestas
        $this->answersFilter = 'pending';
        $this->answersSearch = '';
        $this->answersPage = 1;
    }

    // MANEJO DE RESPUESTAS LOCAS 
    public function approveAnswer($answerId)
    {
        try {
            $answer = FantasyAnswer::findOrFail($answerId);
            $answer->update(['status' => FantasyAnswer::STATUS_APPROVED]);
            
            $this->successMessage = 'Respuesta aprobada correctamente.';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al aprobar la respuesta: ' . $e->getMessage();
        }
    }

    public function rejectAnswer($answerId)
    {
        try {
            $answer = FantasyAnswer::findOrFail($answerId);
            $answer->update(['status' => FantasyAnswer::STATUS_REJECTED]);
            
            $this->successMessage = 'Respuesta rechazada correctamente.';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al rechazar la respuesta: ' . $e->getMessage();
        }
    }

    public function softDeleteAnswer($answerId)
    {
        try {
            $answer = FantasyAnswer::findOrFail($answerId);
            $answer->delete(); // Soft delete
            
            $this->successMessage = 'Respuesta eliminada correctamente.';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al eliminar la respuesta: ' . $e->getMessage();
        }
    }

    public function restoreAnswer($answerId)
    {
        try {
            $answer = FantasyAnswer::withTrashed()->findOrFail($answerId);
            $answer->restore();
            
            $this->successMessage = 'Respuesta restaurada correctamente.';
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al restaurar la respuesta: ' . $e->getMessage();
        }
    }

    // Método mejorado para cerrar modal
    public function closeAnswersModal()
    {
        $this->showAnswersModal = false;
        $this->selectedQuestionForAnswers = null;
        $this->selectedQuestionAnswers = null;
        
        // Resetear filtros de respuestas
        $this->answersFilter = 'pending';
        $this->answersSearch = '';
        $this->answersPage = 1;
    }

    public function clearMessages()
    {
        $this->successMessage = null;
        $this->errorMessage = null;
    }

    // MÉTODO PARA OBTENER RESPUESTAS FILTRADAS
    private function getFilteredAnswers()
    {
        if (!$this->selectedQuestionForAnswers) {
            return collect();
        }

        $query = FantasyAnswer::where('question_id', $this->selectedQuestionForAnswers);

        // Aplicar filtros de estado
        switch ($this->answersFilter) {
            case 'pending':
                $query->pending();
                break;
            case 'approved':
                $query->approved();
                break;
            case 'rejected':
                $query->rejected();
                break;
            case 'deleted':
                $query->onlyTrashed();
                break;
            case 'all':
                $query->withTrashed();
                break;
        }

        // Búsqueda por texto
        if ($this->answersSearch) {
            $query->where('answer', 'like', '%' . $this->answersSearch . '%');
        }

        return $query->orderBy('created_at', 'desc')
                    ->paginate(50, ['*'], 'answersPage', $this->answersPage);
    }

    // MÉTODO PARA CONTAR RESPUESTAS POR ESTADO
    private function getAnswersCounts()
    {
        if (!$this->selectedQuestionForAnswers) {
            return [
                'pending' => 0,
                'approved' => 0,
                'rejected' => 0,
                'deleted' => 0,
                'total' => 0,
            ];
        }

        $baseQuery = FantasyAnswer::where('question_id', $this->selectedQuestionForAnswers);

        return [
            'pending' => $baseQuery->clone()->pending()->count(),
            'approved' => $baseQuery->clone()->approved()->count(),
            'rejected' => $baseQuery->clone()->rejected()->count(),
            'deleted' => $baseQuery->clone()->onlyTrashed()->count(),
            'total' => $baseQuery->clone()->withTrashed()->count(),
        ];
    }

    public function render()
    {
        $query = FantasyQuestion::with('user')->withCount('answers');

        // Aplicar filtros de estado
        switch ($this->filter) {
            case 'active':
                $query->active();
                break;
            case 'inactive':
                $query->inactive();
                break;
            case 'deleted':
                $query->onlyTrashed();
                break;
            case 'all':
                $query->withTrashed();
                break;
        }

        // Búsqueda por texto en la pregunta
        if ($this->search) {
            $query->where('question', 'like', '%' . $this->search . '%');
        }

        $questions = $query->orderBy('created_at', 'desc')->paginate(10);

        // Contar preguntas por estado
        $counts = [ 
            'active' => FantasyQuestion::active()->count(),
            'inactive' => FantasyQuestion::inactive()->count(),
            'deleted' => FantasyQuestion::onlyTrashed()->count(),
            'total' => FantasyQuestion::withTrashed()->count(),
        ]; 

        // Obtener respuestas filtradas y conteos para el modal
        $filteredAnswers = $this->getFilteredAnswers();
        $answersCounts = $this->getAnswersCounts();
        
        return view('livewire.admin-questions', [ 
            'questions' => $questions,
            'counts' => $counts,
            'filteredAnswers' => $filteredAnswers,
            'answersCounts' => $answersCounts,
        ])->layout('layouts.app');
    }
}