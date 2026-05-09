<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garcom extends Model
{
    protected $table = 'garcons';
    protected $primaryKey = 'garcom_id';

    protected $fillable = [
        'usuario_id',
        'cpf',
        'telefone',
        'bio',
        'experiencia',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
