<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormQuestion extends Model
{
    use HasFactory;

    protected $table = 'form_question';

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
