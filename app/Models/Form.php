<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';

    public function formQuestions() {
        return $this->hasMany(FormQuestion::class);
    }

    public function questions() {
        return $this->belongsToMany(Question::class, 'form_question');
    }
}
