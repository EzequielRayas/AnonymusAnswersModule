<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FantasyAnswersMetric extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'answers_id',
        'date_metric',
        'likes',
    ];

    public function answer()
    {
        return $this->belongsTo(FantasyAnswer::class, 'answers_id');
    }
}  




