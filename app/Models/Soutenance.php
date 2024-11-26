<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soutenance extends Model
{
    use HasFactory;

    protected $table = 'soutenances';

    protected $fillable = [
        'etudiant',
        'jury1',
        'jury2',
        'societe',
        'date_debut',
        'date_fin',
        'classe',
        'heure',
        'date_soutenance',
    ];
}
