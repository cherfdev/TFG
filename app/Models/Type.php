<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['nom'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
