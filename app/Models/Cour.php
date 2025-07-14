<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cour extends Model
{
    protected $fillable = ['nom', 'code', 'user_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function students()
{
    return $this->belongsToMany(User::class);
}
}
