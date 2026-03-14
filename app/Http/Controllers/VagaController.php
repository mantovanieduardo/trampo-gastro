<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaga; // Importa o modelo que criamos

class VagaController extends Controller
{
    // Exibe a lista de vagas
    public function index()
    {
        $vagas = Vaga::all();
        return view('vagas.index', compact('vagas'));
    }

    // Exibe o formulário de criação
    public function create()
    {
        return view('vagas.create');
    }

    // Salva os dados no banco
    public function store(Request $request)
    {
        // Cria a vaga com os nomes de colunas do seu banco
        Vaga::create([
            'restaurante_id' => 1, // Por enquanto fixo em 1 até criarmos o login
            'titulo_vaga'    => $request->titulo,
            'tipo_contrato'  => 'Freelancer',
            'valor_diaria'   => $request->valor_pago,
            'status_vaga'    => 'aberta'
        ]);

        return redirect('/vagas')->with('sucesso', 'Vaga publicada!');
    }
}