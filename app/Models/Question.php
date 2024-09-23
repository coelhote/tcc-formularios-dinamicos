<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function formQuestions()
    {
        return $this->hasMany(FormQuestion::class);
    }

    public function forms() {
        return $this->belongsToMany(Form::class, 'form_question');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
