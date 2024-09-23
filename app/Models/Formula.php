<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    use HasFactory;

    protected $table = 'formula';

    public function responses()
    {
        return $this->hasMany(FormulaResponse::class);
    }
}
