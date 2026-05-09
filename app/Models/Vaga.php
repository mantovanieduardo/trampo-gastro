<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $table = 'vagas';
    protected $primaryKey = 'vaga_id';

    protected $fillable = [
        'restaurante_id',
        'titulo_vaga',
        'descricao',
        'tipo_contrato',
        'valor_diaria',
        'status_vaga',
        'data_hora_inicio',
    ];

    protected $casts = [
        'data_hora_inicio' => 'datetime',
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'restaurante_id', 'restaurante_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'vaga_id', 'vaga_id');
    }
}
