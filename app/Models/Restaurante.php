<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    protected $table = 'restaurantes';
    protected $primaryKey = 'restaurante_id';

    protected $fillable = [
        'usuario_id',
        'nome_fantasia',
        'logotipo',
        'endereco',
        'cidade',
        'fotos_galeria',
        'cnpj',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function vagas()
    {
        return $this->hasMany(Vaga::class, 'restaurante_id', 'restaurante_id');
    }
}
