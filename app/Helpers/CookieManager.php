<?php

namespace App\Helpers;

class CookieManager
{
    const COOKIE_NAME = 'fantasy_liked_answers';
    const COOKIE_DURATION = 60 * 24 * 30; // 30 días en minutos

    /**
     * Obtiene los IDs de las respuestas que el usuario ha dado like
     *
     * @return array
     */
    public static function getLikedAnswers(): array
    {
        $cookieValue = request()->cookie(self::COOKIE_NAME);
        
        if (!$cookieValue) {
            return [];
        }

        $likedAnswers = json_decode($cookieValue, true);
        
        return is_array($likedAnswers) ? $likedAnswers : [];
    }

    /**
     * Verifica si el usuario ha dado like a una respuesta específica
     *
     * @param int $answerId
     * @return bool
     */
    public static function hasLikedAnswer(int $answerId): bool
    {
        $likedAnswers = self::getLikedAnswers();
        return in_array($answerId, $likedAnswers);
    }

    /**
     * Agrega un like a la cookie
     *
     * @param int $answerId
     * @return array Los likes actualizados
     */
    public static function addLike(int $answerId): array
    {
        $likedAnswers = self::getLikedAnswers();
        
        if (!in_array($answerId, $likedAnswers)) {
            $likedAnswers[] = $answerId;
            self::saveLikedAnswers($likedAnswers);
        }
        
        return $likedAnswers;
    }

    /**
     * Remueve un like de la cookie
     *
     * @param int $answerId
     * @return array Los likes actualizados
     */
    public static function removeLike(int $answerId): array
    {
        $likedAnswers = self::getLikedAnswers();
        
        $key = array_search($answerId, $likedAnswers);
        if ($key !== false) {
            unset($likedAnswers[$key]);
            $likedAnswers = array_values($likedAnswers); // Reindexar array
            self::saveLikedAnswers($likedAnswers);
        }
        
        return $likedAnswers;
    }

    /**
     * Guarda los likes en la cookie
     *
     * @param array $likedAnswers
     * @return void
     */
    private static function saveLikedAnswers(array $likedAnswers): void
    {
        $cookieValue = json_encode($likedAnswers);
        
        cookie()->queue(cookie(
            self::COOKIE_NAME,
            $cookieValue,
            self::COOKIE_DURATION,
            '/',
            null,
            false,
            false,
            false,
            'lax'
        ));
    }

    /**
     * Método para la respuesta de API (para uso con JavaScript)
     *
     * @param array $likedAnswers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getCookieResponse(array $likedAnswers = null)
    {
        if ($likedAnswers === null) {
            $likedAnswers = self::getLikedAnswers();
        }
        
        self::saveLikedAnswers($likedAnswers);
        
        return response()->json([
            'success' => true,
            'liked_answers' => $likedAnswers
        ]);
    }
}