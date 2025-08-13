<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
use App\Http\Livewire\QuestionAnswers;
use App\Http\Controllers\FantasyQuestionController;
use App\Livewire\Fantasy;
use App\Livewire\AdminQuestions;
use App\Livewire\Admin\AdminAnswers;
use App\Helpers\CookieManager;
use App\Livewire\Cookies;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/questions', Fantasy::class);

// Rutas protegidas con autenticación de Jetstream
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
   
    // Rutas de administración - Solo para usuarios admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        Route::get('/admin/questions', AdminQuestions::class)->name('admin.questions');
        
        // Agregar más rutas de admin aquí
        Route::get('/admin/users', function () {
            $users = \App\Models\User::paginate(10);
            return view('admin.users', compact('users'));
        })->name('admin.users');
    }); 
}); 

// routes/web.php

// // Rutas protegidas para administradores
// Route::middleware(['auth:sanctum', 'verified'])->group(function () {
//     Route::get('/admin/answers', App\Livewire\Admin\AdminAnswers::class)->name('admin.answers');
// }); 


Route::get('/cookies',Cookies::class);


