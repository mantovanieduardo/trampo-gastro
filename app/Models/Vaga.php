<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    // Avisa ao Laravel que o nome da tabela é 'vagas'
    protected $table = 'vagas';

    // Avisa que a chave primária não é 'id', mas sim 'vaga_id'
    protected $primaryKey = 'vaga_id';

    // Colunas que podem ser preenchidas pelo formulário (conforme seu print)
    protected $fillable = [
        'restaurante_id',
        'titulo_vaga',
        'tipo_contrato',
        'valor_diaria',
        'status_vaga',
        'data_hora_inicio'
    ];
}