<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['intitule', 'categorie', 'obligatoire', 'type_id'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function choices()
    {
        return $this->belongsToMany(Choice::class)->withTimestamps();
    }
    public function evaluations()
{
    return $this->belongsToMany(Evaluation::class);
}
}
