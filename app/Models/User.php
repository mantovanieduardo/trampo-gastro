<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Define o nome correto da tabela
    protected $table = 'usuarios';

    // 2. Define a chave primária correta
    protected $primaryKey = 'usuario_id';

    // 3. Desativa os timestamps (se não tiver as colunas created_at/updated_at nesta tabela)
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'tipo_usuario',
    ];

    protected $hidden = [
        'senha', // Esconde o campo 'senha' em vez de 'password'
        'remember_token',
    ];

    /**
     * IMPORTANTE: O Laravel busca por uma coluna chamada 'password' para o login.
     * Este método diz para ele usar a sua coluna 'senha'.
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // O cast 'hashed' garante que o Laravel saiba lidar com a criptografia
            'senha' => 'hashed', 
        ];
    }
}