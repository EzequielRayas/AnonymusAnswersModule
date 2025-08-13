<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Helpers\CookieManager;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/cookie/update-likes', function (Request $request) {
    $likedAnswers = $request->input('liked_answers', []);
    return CookieManager::getCookieResponse($likedAnswers);
});

Route::post('/cookie/update-likes', [CookieManager::class, 'updateLikedAnswersCookie']);