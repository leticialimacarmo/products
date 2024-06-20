<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nomeFantasia', 'razaoSocial', 'cpf', 'cidade', 'data_cadastro', 'data_deleted'
    ];

    protected $dates = [
        'data_cadastro', 'data_deleted'
    ];

}
