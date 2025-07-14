<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{

    protected $fillable = ['titre', 'description', 'cour_id', 'date_expiration', 'statut'];

    protected $casts = [
        'date_expiration' => 'date',
    ];

    public function cour()
    {
        return $this->belongsTo(Cour::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('position')->orderBy('position');
    }
    public function participants()
{
    return $this->hasMany(EvaluationParticipant::class);
}
}
