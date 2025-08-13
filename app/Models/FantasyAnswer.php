<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FantasyAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question_id',
        'answer',
        'status',
        'placeholder',
    ]; 

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Estados
    const STATUS_REJECTED = 0;
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    // Relaciones
    public function question()
    {
        return $this->belongsTo(FantasyQuestion::class, 'question_id');
    }
    

    //LIKES
        public function metrics()
    {
        return $this->hasMany(FantasyAnswersMetric::class, 'answers_id');
    }

    // Métodos de ayuda
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_REJECTED => 'Rechazada',
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_APPROVED => 'Aprobada',
            default => 'Desconocido'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_REJECTED => 'red',
            self::STATUS_PENDING => 'yellow',
            self::STATUS_APPROVED => 'green',
            default => 'gray'
        };
    }

    // Método para obtener el total de likes
    public function getTotalLikesAttribute()
    {
        return $this->metrics()->sum('likes');
    }

    // Método para obtener los likes de hoy
    public function getTodayLikesAttribute()
    {
        return $this->metrics()
            ->where('date_metric', now()->toDateString())
            ->sum('likes');
    }


}

