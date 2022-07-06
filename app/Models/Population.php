<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Population extends Model
{
    use HasFactory;

    protected $table = 'population';

    protected $fillable =[
        'id_nation',
        'nation',
        'id_year',
        'year',
        'population',
        'slug_nation'
    ];
}
