<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'cliente',
        'tipoPagamento',
        'valorIntegral',
        'vendedor',
        'produto',
        'quantidade',
        'valorUnitario',
        'data_cadastro',
        'data_deleted'
    ];

    public $timestamps = false;
}
