<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'codigo',
        'descricao',
        'valor',
        'fornecedor',
        'data_cadastro',
        'data_deleted',
    ];

    protected $casts = [
        'data_cadastro' => 'datetime',
        'data_deleted' => 'date',
    ];
}
