<?php

namespace App\Livewire\Admin;

use App\Models\FantasyAnswer;
use App\Models\FantasyQuestion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminAnswers extends Component
{
    use WithPagination;
    
    public $filter = 'pending'; // pending, approved, rejected, all
    public $search = '';
    public $selectedQuestion = '';

    // Nueva propiedad para cuando se usa como modal
    public $preSelectedQuestion = null;
    public $isModal = false;

    protected $queryString = [
        'filter' => ['except' => 'pending'],
        'search' => ['except' => ''],
        'selectedQuestion' => ['except' => '']
    ];

    // Modificar el método mount
    public function mount($preSelectedQuestion = null)
    {
        if ($preSelectedQuestion) {
            $this->selectedQuestion = $preSelectedQuestion;
            $this->preSelectedQuestion = $preSelectedQuestion;
            $this->isModal = true;
            $this->filter = 'pending'; // Mostrar todas por defecto en el modal
        }
    }

    
//feature to fix fusion after closing
//     protected $listeners = ['resetComponent'];

// public function resetComponent()
// {
//     $this->reset(); // o reset(['campo1', 'campo2']) si prefieres
// }

//     // Método para cerrar modal desde el componente hijo
//     public function closeModal()
//     {
//         if ($this->isModal) {
//             // Emitir evento al componente padre para cerrar el modal
//             $this->dispatch('closeAnswersModal');
//         }
//     }

protected $listeners = [
    'reset-answers-component' => 'resetComponent',
    'closeAnswersModal' => 'closeModal'
];

public function resetComponent()
{
    $this->resetExcept(['preSelectedQuestion', 'isModal']);
    $this->resetPage();
}

public function closeModal()
{
    $this->resetComponent();
    $this->dispatch('closeAnswersModal');
}




    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSelectedQuestion()
    {
        $this->resetPage();
    }

    public function approve($answerId)
    {
        try {
            $answer = FantasyAnswer::findOrFail($answerId);
            $answer->update(['status' => FantasyAnswer::STATUS_APPROVED]);
            
            session()->flash('success', 'Respuesta aprobada correctamente.');
            
            // Si está en modo modal, emitir evento para actualizar el componente padre
            if ($this->isModal) {
                $this->dispatch('answerUpdated');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al aprobar la respuesta: ' . $e->getMessage());
        }
    }

    public function reject($answerId)
    {
        try {
            $answer = FantasyAnswer::findOrFail($answerId);
            $answer->update(['status' => FantasyAnswer::STATUS_REJECTED]);
            
            session()->flash('success', 'Respuesta rechazada correctamente.');
            
            // Si está en modo modal, emitir evento para actualizar el componente padre
            if ($this->isModal) {
                $this->dispatch('answerUpdated');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al rechazar la respuesta: ' . $e->getMessage());
        }
    }

    public function softDelete($answerId)
    {
        try {
            $answer = FantasyAnswer::findOrFail($answerId);
            $answer->delete(); // Soft delete
            
            session()->flash('success', 'Respuesta eliminada correctamente.');
            
            // Si está en modo modal, emitir evento para actualizar el componente padre
            if ($this->isModal) {
                $this->dispatch('answerUpdated');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la respuesta: ' . $e->getMessage());
        }
    }

    public function restore($answerId)
    {
        try {
            $answer = FantasyAnswer::withTrashed()->findOrFail($answerId);
            $answer->restore();
            
            session()->flash('success', 'Respuesta restaurada correctamente.');
            
            // Si está en modo modal, emitir evento para actualizar el componente padre
            if ($this->isModal) {
                $this->dispatch('answerUpdated');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al restaurar la respuesta: ' . $e->getMessage());
        }
    }



//     public function closeAnswersModal()
// {
//     $this->reset(['showAnswersModal', 'selectedQuestionForAnswers']);
//     // O cualquier otra limpieza necesaria
// }

    public function render()
    {
        $query = FantasyAnswer::with('question');

        // Si hay una pregunta preseleccionada (modo modal), filtrar por ella
        if ($this->preSelectedQuestion) {
            $query->where('question_id', $this->preSelectedQuestion);
        }

        // Aplicar filtros de estado
        switch ($this->filter) {
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

        // Filtro por pregunta específica
        if ($this->selectedQuestion) {
            $query->where('question_id', $this->selectedQuestion);
        }

        // Búsqueda por texto
        if ($this->search) {
            $query->where('answer', 'like', '%' . $this->search . '%');
        }

        $answers = $query->orderBy('created_at', 'desc')->paginate(10);

        // Obtener todas las preguntas para el filtro (solo si no está en modo modal)
        $questions = $this->isModal ? [] : FantasyQuestion::orderBy('created_at', 'desc')->get();

        // Contar por estados
        $baseQuery = $this->preSelectedQuestion 
            ? FantasyAnswer::where('question_id', $this->preSelectedQuestion)
            : FantasyAnswer::query();

        $counts = [
            'pending' => $baseQuery->clone()->pending()->count(),
            'approved' => $baseQuery->clone()->approved()->count(),
            'rejected' => $baseQuery->clone()->rejected()->count(),
            'deleted' => $baseQuery->clone()->onlyTrashed()->count(),
            'total' => $baseQuery->clone()->withTrashed()->count(),
        ];

        return view('livewire.admin.admin-answers', [
            'answers' => $answers,
            'questions' => $questions,
            'counts' => $counts
        ])->layout($this->isModal ? null : 'layouts.app');
    }
}