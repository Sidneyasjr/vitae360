<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'cnpj',
        'email',
    ];

    protected $casts = [
        'cnpj' => 'string',
    ];

    /**
     * Campos que podem ser pesquisados
     *
     * @var array
     */
    protected $searchable = [
        'name',
        'cnpj',
        'email',
    ];
}
