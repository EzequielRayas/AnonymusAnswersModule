<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FantasyQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'question',
        'status',
        'start_date',
        'end_date',
        'placeholder',
    ];

    protected $casts = [
        'status' => 'boolean', // Mantenemos esto para el campo 'status'
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
    ];

    // --- Nuevas Constantes de Estado (Basadas en el campo 'status' booleano existente) ---
    // Aunque tu campo 'status' es booleano (0/1), podemos definir constantes para mayor claridad
    const STATUS_INACTIVE = 0; // Correspondiente a false
    const STATUS_ACTIVE = 1;   // Correspondiente a true

    // --- Scopes (Ajustados o Nuevos) ---
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    // Scope para preguntas en período vigente
    public function scopeInPeriod($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    // --- Relaciones ---
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(FantasyAnswer::class, 'question_id')->latest();
    }

    // --- Métodos de ayuda para la vista (Nuevos) ---

    /**
     * Obtiene el texto legible del estado de la pregunta.
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Activa' : 'Inactiva';
    }

    /**
     * Obtiene el color de Tailwind CSS para el estado de la pregunta.
     *
     * @return string (green, gray)
     */
    public function getStatusColorAttribute()
    {
        return $this->status ? 'green' : 'gray';
    }
}