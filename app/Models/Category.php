<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Nome da tabela, se necessário

    // Relacionamento com Questions (Categoria tem muitas perguntas)
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
