<div>
    <style>
        /* Import fonts */

        @import url('https://fonts.bunny.net/css?family=Inter:400,500,600|Poppins:400,500,600,700&display=swap');

/* Base styles */
        * {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        
        @keyframes fadeInUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        @keyframes pulse-soft {
            0%, 100% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(1.02); opacity: 1; }
        }

        /* Background */
        /* body {
            background: linear-gradient(135deg, #72BCFC 0%, #4A90E2 25%, #357ABD 50%, #2E6BA8 75%, #1E4A73 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        } */

        body {
    background: linear-gradient(135deg, 

        /* #AEEBFF,  
        #7AC8F5, 
        #4BA3E2, 
        #2E74C9, 
        #1C64F2 */

        /* morados chidos */
        /* #7038C6, 
        #574BDF,  
        #3C6EE8,  
        #2898F5, 
        #AEEBFF  */

        /* #701633,         
        #3d1533 */

        /* tintos oscuros acorde a web */
      /* #701633,
      #6b1d40,
      #511937,
      #3d1533 */

    #701633 0%,         
  #7a1e45 15%,         
  #6e1c42 35%,        
  #5b173b 55%,      
  #3d1533 75%,         
  #511937 90%,         
  #701633 100%    

        /* #3C6EE8,   
        #7AC8F5,   
        #AEEBFF    */

    );
    background-size: 400% 400%;
    animation: gradientFlow 20s ease infinite;
    min-height: 100vh;
    margin: 0;
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
    color: white;
}

/* Animación del fondo degradado */ 

@keyframes gradientFlow {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}


        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
            radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 40% 60%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* Glass effect for cards */
        /* .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            box-shadow: 
                0 4px 16px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.4),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            
        } */
         .glass-card {
    background: rgba(255, 255, 255, 0.08); /* más transparente */
    backdrop-filter: blur(28px); /* desenfoque un poco mayor, más suave */
    -webkit-backdrop-filter: blur(28px);
    border: 1px solid rgba(255, 255, 255, 0.15); /* borde más sutil */
    border-radius: 28px;
    box-shadow: 
        0 6px 20px rgba(255, 255, 255, 0.1),
        inset 0 1px 2px rgba(255, 255, 255, 0.3),
        inset 0 -1px 2px rgba(255, 255, 255, 0.07);
    position: relative;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    color: #fff; 
}

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: inherit;
            opacity: 0.6;
            pointer-events: none;
        }

        .glass-card:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 
                /* 0 20px 40px rgba(31, 38, 135, 0.5), */
                0 8px 24px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.2);
        }

        /* Main question card */
        .main-question-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(25px);
            border: 2px solid rgba(255, 255, 255, 0.4);
            box-shadow: 
                /* 0 16px 40px rgba(31, 38, 135, 0.4), */
                0 8px 20px rgba(255, 255, 255, 0.15),
                inset 0 2px 0 rgba(255, 255, 255, 0.5),
                inset 0 -2px 0 rgba(255, 255, 255, 0.1);
        }

        /* Answer cards positioning */
        .answers-container {
            position: relative;
            width: 100%;
            height: 500px;
        }

        .answer-card {
            position: absolute;
            width: 240px;
            min-height: 120px;
            animation: fadeInUp 0.6s ease-out forwards;
            z-index: 10;
        }

        .answer-card .content {
            position: relative;
            z-index: 2;
            padding: 1.5rem;
        }

        /* Heart icon improvements */
        .heart-container {
            position: absolute;
            bottom: 12px;
            right: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 3;
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 10px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .heart-container:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }

        .heart-icon {
            width: 20px;
            height: 20px;
            transition: all 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        .heart-icon.liked {
            color: #ff4757;
            transform: scale(1.1);
        }

        .heart-icon:not(.liked):hover {
            color: #ff4757;
            transform: scale(1.05);
        }

        /* Button styles */
        /* .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 500;
            padding: 12px 24px;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
        } */

        /* .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        } */



.btn-primary {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: white;
    font-weight: 500;
    padding: 12px 24px;
    border-radius: 12px;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 0 4px 12px rgba(100, 30, 60, 0.25);
    position: relative;
    overflow: hidden;
}

/* Efecto de rafaga de luz ultra suave */
.btn-primary::before {
    content: '';
    position: absolute;
    top: -20%;
    left: -100%;
    width: 40%;
    height: 140%;
    background: linear-gradient(
        90deg,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0) 100%
    );
    transform: rotate(25deg);
    transition: all 0.7s ease-out;
    opacity: 0;
}

.btn-primary:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
    box-shadow: 
        0 6px 16px rgba(120, 40, 70, 0.35),
        0 0 12px rgba(255, 255, 255, 0.2);
}

.btn-primary:hover::before {
    left: 120%;
    opacity: 0.8;
    transition-delay: 0.15s;
}

/* Efecto de resplandor sutil al hacer hover */
.btn-primary::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(
        circle at center,
        rgba(255, 255, 255, 0.05) 0%,
        rgba(255, 255, 255, 0) 70%
    );
    opacity: 0;
    transition: opacity 0.4s ease;
}

.btn-primary:hover::after {
    opacity: 1;
}


        /* Input styles */
        .glass-input {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .glass-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        /* Success/Error notifications */
        .notification {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }

        /* Responsive animations */
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-pulse-soft { animation: pulse-soft 3s ease-in-out infinite; }
        
        /* Pagination styles */
        .pagination-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 8px 20px;
        }

        /* Typography improvements */


        /* .title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            color: white;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            padding-top: 0px;
            padding-bottom: 40px;


        }

        .title1{

            padding-top: 50px;
            font-size: 35px;
        } */



        .subtitle {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: white;
        }

        .body-text {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: white;
        }

        .caption {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.8);
        }
    </style>

    <div class="min-h-screen p-4 md:p-8 relative" style="z-index: 1;">
        @if($showSuccess)
            <div x-data="{ show: true }" 
                 x-show="show"
                 x-transition
                 x-init="setTimeout(() => show = false, 3000)"
                 class="fixed top-4 right-4 z-50">
                <div class="notification animate-pulse-soft">
                    <div class="flex items-center space-x-2 p-4">
                        <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-white body-text">Respuesta enviada a revisión!</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="fixed top-4 right-4 z-50">
                <div class="notification">
                    <div class="flex items-center space-x-2 p-4">
                        <svg class="w-5 h-5 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-white body-text">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif



        
        <div class="relative w-full max-w-7xl mx-auto">



            {{-- <!-- Title Desktop Version-->
            <h1 class="text-3xl md:text-5xl text-center mb-5 font-sans text-white title1">
                No juzgamos, solo leemos.
            </h1>
            <h1 class="text-3xl md:text-5xl text-center mb-12 title">
                ¿Nos cuentas? 💌
            </h1> --}}



            <style>
    /* Typography improvements */
    .title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        color: white;
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        padding-top: 0px;
        padding-bottom: 40px;
        font-size: 2.5rem; /* Tamaño base para desktop/tablet */
    }

    .title1 {
        padding-top: 50px;
        font-size: 1.8rem; /* Tamaño base para desktop/tablet */
    }

    /* Mobile styles */
    @media (max-width: 640px) {
        .title1 {
            font-size: 1.3rem; /* Más pequeño en móvil */
        }
        .title {
            font-size: 2rem; /* Mantiene tamaño similar en móvil */
        }
    }

    /* Tablet styles - hereda los tamaños de desktop */
    @media (min-width: 641px) and (max-width: 1023px) {
        /* No necesitamos cambios, hereda los estilos de desktop */
    }

    /* Desktop styles */
    @media (min-width: 1024px) {
        .title {
            font-size: 3rem; /* Tamaño grande para desktop */
        }
                .title1 {
            font-size: 2rem; /* Tamaño grande para desktop */
        }
    }
</style>


<!-- Title Versions -->

<div class="text-center">
    <!-- Desktop/Tablet Version -->
    <div class="hidden sm:block">
        <h1 class="mb-5 font-sans text-white title1">
            No juzgamos, solo leemos.
        </h1>
        <h1 class="mb-12 title">
            ¿Nos cuentas? 💌
        </h1>
    </div>
    
    <!-- Mobile Version -->
    <div class="block sm:hidden">
        <h1 class="mb-5 font-sans text-white title1">
            No juzgamos, solo leemos.
        </h1>
        <h1 class="mb-12 title">
            ¿Nos cuentas? 💌
        </h1>
    </div>
</div>




            @if($latestQuestion)
            
<!-- Desktop Layout -->
                <div class="hidden md:block">
                    <!-- Main Question Card -->
                    <div class="flex justify-center mb-16">
                        <div class="glass-card main-question-card animate-float p-8 max-w-md">
                            <div class="text-center relative z-2">
                                <h2 class="text-2xl subtitle mb-6 leading-relaxed">
                                    {{ $latestQuestion->question }}
                                </h2>
                                <button wire:click="setActiveQuestion({{ $latestQuestion->id }})" 
                                        class="btn-primary">
                                    {{ $activeQuestionId === $latestQuestion->id ? 'Cancelar' : 'Responder' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- Answer Form -->
                    @if($activeQuestionId === $latestQuestion->id)
                        <div class="flex justify-center mb-8">
                            <div class="glass-card p-6 max-w-md w-full">
                                <form wire:submit.prevent="addAnswer({{ $latestQuestion->id }})" class="space-y-4 relative z-2">
                                    <input type="text" 
                                           wire:model="newAnswers.{{ $latestQuestion->id }}"
                                           placeholder="Cuentanos tu anecdota..." 
                                           class="glass-input body-text"
                                           required>
                                    <button type="submit" class="btn-primary w-full">
                                        Enviar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif --}}

                    <!-- Answer Form -->
@if($activeQuestionId === $latestQuestion->id)
    <div class="flex justify-center mb-8">
        <div class="glass-card p-6 max-w-md w-full">
            <form wire:submit.prevent="addAnswer({{ $latestQuestion->id }})" class="space-y-4 relative z-2">
                <textarea 
                    wire:model="newAnswers.{{ $latestQuestion->id }}"
                    placeholder="Cuentanos tu anécdota..." 
                    rows="3"  
                    class="glass-input body-text w-full min-h-[6rem] resize-none"
                    required></textarea>
                <button type="submit" class="btn-primary w-full mt-4">
                    Enviar
                </button>
            </form>
        </div>
    </div>
@endif


{{-- <!-- Answers Container -->
@if(count($answers) > 0)
    <div
    class="answers-container relative w-full min-h-[500px] py-8">
        @php
            $totalAnswers = count($answers);
            $positions = [];
            
            // Configuración de posicionamiento
            $maxCardsPerRow = 5;
            $horizontalSpacing = 22;
            $verticalSpacing = 53;
            $startY = 7;
            
            for ($i = 0; $i < $totalAnswers; $i++) {
                $row = floor($i / $maxCardsPerRow);
                $cardsInThisRow = min($maxCardsPerRow, $totalAnswers - ($row * $maxCardsPerRow));
                $centerOffset = ($cardsInThisRow - 1) * $horizontalSpacing / 2;
                $x = 40 - $centerOffset + ($i % $maxCardsPerRow) * $horizontalSpacing;
                $y = $startY + ($row * $verticalSpacing);
                
                $positions[] = [
                    'x' => $x,
                    'y' => $y,
                    'rotation' => rand(-5, 5),
                    'delay' => $i * 0.08,
                    'zIndex' => $i
                ];
            }
        @endphp

        @foreach($answers as $index => $answer)
            @php
                $pos = $positions[$index] ?? [
                    'x' => 50,
                    'y' => 30,
                    'rotation' => 0,
                    'delay' => $index * 0.08,
                    'zIndex' => $index
                ];
            @endphp
            
            <div class="answer-card glass-card absolute w-56 mx-2 my-2 hover:!z-50"
                 style="left: {{ $pos['x'] }}%; top: {{ $pos['y'] }}%; 
                        transform: translate(-50%, -50%) rotate({{ $pos['rotation'] }}deg);
                        animation-delay: {{ $pos['delay'] }}s;
                        z-index: {{ $pos['zIndex'] }};
                        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <div class="content p-4">
                    <p class="body-text text-sm mb-3 leading-relaxed">
                        {{ $answer->answer }}
                    </p>
                    <span class="caption text-xs text-gray-300">
                        {{ $answer->created_at->diffForHumans() }}
                    </span>
                </div>
                
                <div class="heart-container absolute bottom-3 right-3 flex items-center" wire:click="toggleLike({{ $answer->id }})">
                    <svg class="heart-icon w-5 h-5 {{ $answer->is_liked ? 'liked' : '' }}" 
                         fill="{{ $answer->is_liked ? '#ff4757' : 'currentColor' }}" 
                         viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span
                    wire:poll.keep-alive
                    class="caption text-xs ml-1">{{ $answer->total_likes }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endif --}}


<!-- Answers Container - Desktop -->
@if(count($answers) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 py-8">
        @foreach($answers as $answer)
            <div class="glass-card p-4 relative min-h-[140px] flex flex-col justify-between hover:!z-50">
                <div class="relative z-2">
                    <p class="body-text text-sm mb-3 leading-relaxed">
                        {{ $answer->answer }}
                    </p>
                    <span class="caption text-xs text-gray-300">
                        {{ $answer->created_at->diffForHumans() }}
                    </span>
                </div>
                <div class="heart-container absolute bottom-3 right-3 flex items-center" wire:click="toggleLike({{ $answer->id }})">
                    <svg class="heart-icon w-5 h-5 {{ $answer->is_liked ? 'liked' : '' }}" 
                         fill="{{ $answer->is_liked ? '#ff4757' : 'currentColor' }}" 
                         viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>


                    <span wire:poll.keep-alive class="caption text-xs ml-1">{{ $answer->total_likes }}</span>
                    
                </div>
            </div>
        @endforeach
    </div>
@endif




</div>




<!-- Tablet Layout -->
<div class="hidden sm:block md:hidden">
    <div class="mb-8">
        <div class="glass-card main-question-card animate-float p-6 mx-auto max-w-lg">
            <div class="text-center relative z-2">
                <h2 class="text-xl subtitle mb-4 leading-relaxed">
                    {{ $latestQuestion->question }}
                </h2>
                <button wire:click="setActiveQuestion({{ $latestQuestion->id }})" 
                        class="btn-primary">
                    {{ $activeQuestionId === $latestQuestion->id ? 'Cancelar' : 'Responder' }}
                </button>
            </div>
        </div>
    </div>

    @if($activeQuestionId === $latestQuestion->id)
        <div class="flex justify-center mb-8">
            <div class="glass-card p-6 max-w-md w-full">
                <form wire:submit.prevent="addAnswer({{ $latestQuestion->id }})" class="space-y-4 relative z-2">
                    <textarea 
                        wire:model="newAnswers.{{ $latestQuestion->id }}"
                        placeholder="Cuentanos tu anécdota..." 
                        rows="3"  
                        class="glass-input body-text w-full min-h-[6rem] resize-none"
                        required></textarea>
                    <button type="submit" class="btn-primary w-full mt-4">
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    @endif

    @if(count($answers) > 0)
        <!-- Cambio principal aquí: grid de 2 columnas -->
        <div class="grid grid-cols-2 gap-4">
            @foreach($answers as $answer)
                <div class="glass-card p-4 relative min-h-[140px] flex flex-col justify-between">
                    <div class="relative z-2">
                        <p class="body-text text-sm mb-3 leading-relaxed">
                            {{ $answer->answer }}
                        </p>
                        <span class="caption text-xs">
                            {{ $answer->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="heart-container" wire:click="toggleLike({{ $answer->id }})">
                        <span class="caption text-xs">{{ $answer->total_likes }}</span>
                        <svg class="heart-icon {{ $answer->is_liked ? 'liked' : '' }}" 
                             fill="{{ $answer->is_liked ? '#ff4757' : 'currentColor' }}" 
                             viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Mobile Layout -->
                <div class="block sm:hidden">
                    <div class="mb-6">
                        <div class="glass-card main-question-card animate-float p-6 mx-2 min-h-[200px] flex items-center justify-center">
                            <div class="text-center w-full relative z-2">
                                <h2 class="text-lg subtitle mb-4 leading-relaxed">
                                    {{ $latestQuestion->question }}
                                </h2>
                                <button wire:click="setActiveQuestion({{ $latestQuestion->id }})" 
                                        class="btn-primary text-sm">
                                    {{ $activeQuestionId === $latestQuestion->id ? 'Cancelar' : 'Responder' }}
                                </button>
                            </div>
                        </div>
                    </div>


                    
                    {{-- @if($activeQuestionId === $latestQuestion->id)
                        <div class="mb-6">
                            <div class="glass-card p-4 mx-2">
                                <form wire:submit.prevent="addAnswer({{ $latestQuestion->id }})" class="space-y-3 relative z-2">
                                    <input type="text" 
                                           wire:model="newAnswers.{{ $latestQuestion->id }}"
                                           placeholder="Escribe tu respuesta..."
                                           class="glass-input body-text text-sm"
                                           required>
                                    <button type="submit" class="btn-primary w-full text-sm">
                                        Guardar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif --}}


                    <!-- Answer Form -->
@if($activeQuestionId === $latestQuestion->id)
    <div class="flex justify-center mb-8">
        <div class="glass-card p-6 max-w-md w-full">
            <form wire:submit.prevent="addAnswer({{ $latestQuestion->id }})" class="space-y-4 relative z-2">
                <textarea 
                    wire:model="newAnswers.{{ $latestQuestion->id }}"
                    placeholder="Cuentanos tu anécdota..." 
                    rows="3"  
                    class="glass-input body-text w-full min-h-[6rem] resize-none"
                    required></textarea>
                <button type="submit" class="btn-primary w-full mt-4">
                    Enviar
                </button>
            </form>
        </div>
    </div>
@endif                   

                    @if(count($answers) > 0)
                        <div class="space-y-4">
                            @foreach($answers as $answer)
                                <div class="glass-card p-4 mx-2 min-h-[120px] flex flex-col justify-between relative">
                                    <div class="relative z-2">
                                        <p class="body-text text-sm mb-3 leading-relaxed">
                                            {{ $answer->answer }}
                                        </p>
                                        <span class="caption text-xs">
                                            {{ $answer->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="heart-container" wire:click="toggleLike({{ $answer->id }})">
                                        <span class="caption text-xs">{{ $answer->total_likes }}</span>
                                        <svg class="heart-icon {{ $answer->is_liked ? 'liked' : '' }}" 
                                             fill="{{ $answer->is_liked ? '#ff4757' : 'currentColor' }}" 
                                             viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Stats -->
                <div class="text-center mt-8">
                    <div class="pagination-container inline-block">
                        <span class="text-white body-text">
                            Respuestas: <span class="font-semibold">{{ $totalAnswers }}</span> 
                            @if(count($answers) < $totalAnswers)
                                <span class="caption text-sm">(Mostrando {{ count($answers) }})</span>
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Pagination -->
                @if($paginatedAnswers && $paginatedAnswers->hasPages())
                    <div class="text-center mt-6">
                        <div class="pagination-container inline-flex items-center space-x-4">
                            @if($paginatedAnswers->previousPageUrl())
                                <button wire:click="previousPage" 
                                        class="text-white hover:text-blue-200 transition-colors p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                            @endif
                            
                            <span class="text-white caption">
                                Página {{ $paginatedAnswers->currentPage() }} de {{ $paginatedAnswers->lastPage() }}
                            </span>
                            
                            @if($paginatedAnswers->nextPageUrl())
                                <button wire:click="nextPage" 
                                        class="text-white hover:text-blue-200 transition-colors p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

            @else
                <!-- No questions state -->
                <div class="text-center py-16">
                    <div class="glass-card p-12 max-w-md mx-auto">
                        <div class="relative z-2">
                            <svg class="w-16 h-16 text-white mx-auto mb-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h2 class="text-2xl subtitle mb-2">No hay preguntas disponibles</h2>
                            <p class="caption">Aún no se han creado preguntas.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- @script
    <script>
        // Listen for the 'updateLikeCookie' event dispatched from Livewire
        Livewire.on('updateLikeCookie', (event) => {
            const likedAnswers = event.likedAnswers;
            fetch('/api/cookie/update-likes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ liked_answers: likedAnswers })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Cookie update response:', data);
            })
            .catch(error => {
                console.error('Error updating cookie:', error);
            });
        });
    </script>
    @endscript --}}
    
    @script
<script>
    // Escuchar evento de like actualizado
    Livewire.on('likeUpdated', (event) => {
        // Actualizar el corazón específico
        const heartIcon = document.querySelector(`[wire\\:click="toggleLike(${event.answerId})"] .heart-icon`);
        if (heartIcon) {
            if (event.isLiked) {
                heartIcon.classList.add('liked');
                heartIcon.setAttribute('fill', '#ff4757');
            } else {
                heartIcon.classList.remove('liked');
                heartIcon.setAttribute('fill', 'currentColor');
            }
        }
        
        // Actualizar el contador
        const likeCount = document.querySelector(`[wire\\:click="toggleLike(${event.answerId})"] .caption`);
        if (likeCount) {
            // Enviar solicitud para obtener el conteo actualizado
            fetch(`/get-like-count/${event.answerId}`)
                .then(response => response.json())
                .then(data => {
                    likeCount.textContent = data.count;
                });
        }
    });

    // Manejar errores
    Livewire.on('errorOccurred', (event) => {
        alert(event.message);
    });
</script>
@endscript

</div> 




