<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagens';

    protected $fillable = [
        'vaga_id',
        'remetente_id',
        'destinatario_id',
        'conteudo',
        'lida',
    ];

    protected $casts = [
        'lida' => 'boolean',
    ];

    public function remetente()
    {
        return $this->belongsTo(User::class, 'remetente_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    public function vaga()
    {
        return $this->belongsTo(Vaga::class, 'vaga_id', 'vaga_id');
    }
}
