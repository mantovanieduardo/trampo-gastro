<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    // Nome da tabela (já que o Laravel esperaria "restaurantes" no plural)
    protected $table = 'restaurantes';
    
    // Chave primária (já que na sua imagem é restaurante_id e não apenas id)
    protected $primaryKey = 'restaurante_id';

    protected $fillable = [
        'usuario_id',
        'nome_fantasia',
        'logotipo',
        'endereco',
        'cidade',
        'fotos_galeria'
    ];
}