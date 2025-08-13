<?php

namespace App\Livewire;

use App\Models\FantasyQuestion;
use App\Models\FantasyAnswer;
use App\Models\FantasyAnswersMetric;
use App\Helpers\CookieManager;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class Fantasy extends Component
{
    use WithPagination;

    /** @var FantasyQuestion|null */
    public ?FantasyQuestion $latestQuestion = null;
   
    /** @var array */
    public array $newAnswers = [];
   
    /** @var int|null */
    public ?int $activeQuestionId = null;
   
    /** @var bool */
    public bool $showSuccess = false;

    /** @var array */
    public array $likedAnswers = [];

    public function mount(): void
    {
        $this->loadLatestQuestion();
        $this->likedAnswers = CookieManager::getLikedAnswers();
    }

    public function loadLatestQuestion(): void
    {
        $currentDate = Carbon::now();
        $this->latestQuestion = FantasyQuestion::where('start_date', '<=', $currentDate)
                                ->where('end_date', '>=', $currentDate)
                                ->orderBy('start_date', 'asc')
                                ->first();
    }

    public function addAnswer($questionId): void
    {
        $this->validate([
            'newAnswers.'.$questionId => 'required|string|max:250',
        ]);

        try {
            FantasyAnswer::create([
                'question_id' => $questionId,
                'answer' => $this->newAnswers[$questionId],
                'status' => FantasyAnswer::STATUS_PENDING,
            ]);
           
            $this->newAnswers[$questionId] = '';
            $this->showSuccess = true;
            $this->activeQuestionId = null;
           
            session()->flash('success', 'Tu respuesta ha sido enviada y está pendiente de moderación. Aparecerá en la página una vez sea aprobada.');
           
            $this->resetPage();
            $this->loadLatestQuestion();
           
            $this->dispatch('success-message');
           
        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar la respuesta: '.$e->getMessage());
        }
    }

    public function setActiveQuestion(?int $questionId): void
    {
        $this->activeQuestionId = $questionId === $this->activeQuestionId ? null : $questionId;
       
        if ($this->activeQuestionId) {
            $this->showSuccess = false;
        }
    }

    /**
     * Alterna el estado de like para una respuesta
     *
     * @param int $answerId
     * @return void
     */
    // public function toggleLike($answerId)
    // {
    //     try {
    //         $hasLiked = CookieManager::hasLikedAnswer($answerId);
            
    //         if ($hasLiked) {
    //             $this->removeLike($answerId);
    //         } else {
    //             $this->addLike($answerId);
    //         }

    //         // Actualizar la lista local
    //         $this->likedAnswers = CookieManager::getLikedAnswers();
            
    //         // Dispatch event para actualizar la UI
    //         $this->dispatch('likeToggled', [
    //             'answerId' => $answerId,
    //             'isLiked' => !$hasLiked
    //         ]);
            
    //     } catch (\Exception $e) {
    //         session()->flash('error', 'Error al procesar el like: ' . $e->getMessage());
    //     }
    // }

    public function toggleLike($answerId)
{
    try {
        $hasLiked = in_array($answerId, $this->likedAnswers);
        
        if ($hasLiked) {
            $this->likedAnswers = CookieManager::removeLike($answerId);
        } else {
            $this->likedAnswers = CookieManager::addLike($answerId);
        }

        // Actualizar métricas en la base de datos
        $this->updateAnswerMetrics($answerId, !$hasLiked);
        
        // Emitir evento para actualizar UI
        $this->dispatch('likeUpdated', [
            'answerId' => $answerId,
            'isLiked' => !$hasLiked,
            'likedAnswers' => $this->likedAnswers
        ]);
        
    } catch (\Exception $e) {
        $this->dispatch('errorOccurred', message: 'Error al procesar el like: ' . $e->getMessage());
    }
}

//nueva funcion
/**
 * Actualiza las métricas de la respuesta
 *
 * @param int $answerId
 * @param bool $increment
 * @return void
 */
private function updateAnswerMetrics($answerId, $increment)
{
    $metric = FantasyAnswersMetric::firstOrCreate(
        [
            'answers_id' => $answerId,
            'date_metric' => Carbon::now()->toDateString(),
        ],
        ['likes' => 0]
    );
    
    if ($increment) {
        $metric->increment('likes');
    } elseif ($metric->likes > 0) {
        $metric->decrement('likes');
    }
}

    /**
     * Agrega un like a una respuesta
     *
     * @param int $answerId
     * @return void
     */
    private function addLike($answerId)
    {
        CookieManager::addLike($answerId);

        // Actualizar o crear métrica
        $metric = FantasyAnswersMetric::firstOrCreate(
            [
                'answers_id' => $answerId,
                'date_metric' => Carbon::now()->toDateString(),
            ],
            [
                'likes' => 0
            ]
        );
        
        $metric->increment('likes');
    }

    /**
     * Remueve un like de una respuesta
     *
     * @param int $answerId
     * @return void
     */
    private function removeLike($answerId)
    {
        CookieManager::removeLike($answerId);
        
        // Actualizar métrica
        $metric = FantasyAnswersMetric::where('answers_id', $answerId)
            ->where('date_metric', Carbon::now()->toDateString())
            ->first();
        
        if ($metric && $metric->likes > 0) {
            $metric->decrement('likes');
        }
    }

    public function render()
    {
        $answers = collect();
        $totalAnswers = 0;
        $paginatedAnswers = null;
       
        if ($this->latestQuestion) {
            $paginatedAnswers = FantasyAnswer::where('question_id', $this->latestQuestion->id)
                ->approved()
                ->orderBy('created_at', 'desc')
                ->paginate(10);
                
            // Agregar métricas y estado de like
            $answersWithMetrics = collect($paginatedAnswers->items())->map(function ($answer) {
                $totalLikes = FantasyAnswersMetric::where('answers_id', $answer->id)
                    ->sum('likes');
                
                $answer->total_likes = $totalLikes;
                $answer->is_liked = in_array($answer->id, $this->likedAnswers);
                
                return $answer;
            });
           
            $answers = $answersWithMetrics;
            $totalAnswers = FantasyAnswer::where('question_id', $this->latestQuestion->id)
                ->approved()
                ->count();
        }

        return view('livewire.fantasy', [
            'answers' => $answers,
            'totalAnswers' => $totalAnswers,
            'paginatedAnswers' => $paginatedAnswers
        ])->layout('layouts.fantasy');
    }
}