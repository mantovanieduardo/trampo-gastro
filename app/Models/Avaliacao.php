<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'vaga_id',
        'avaliador_id',
        'avaliado_id',
        'nota',
        'comentario',
        'tipo',
    ];

    public function avaliador()
    {
        return $this->belongsTo(User::class, 'avaliador_id');
    }

    public function avaliado()
    {
        return $this->belongsTo(User::class, 'avaliado_id');
    }

    public function vaga()
    {
        return $this->belongsTo(Vaga::class, 'vaga_id', 'vaga_id');
    }
}
