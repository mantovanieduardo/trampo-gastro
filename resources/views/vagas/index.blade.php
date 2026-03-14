<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Vagas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Vagas Publicadas</h2>
            <a href="{{ route('vagas.create') }}" class="btn btn-primary">Nova Vaga</a>
        </div>

        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Título</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Criado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vagas as $vaga)
                            <tr>
                                <td>{{ $vaga->titulo_vaga }}</td>
                                <td>R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $vaga->status_vaga == 'aberta' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($vaga->status_vaga) }}
                                    </span>
                                </td>
                                <td>{{ $vaga->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Nenhuma vaga cadastrada ainda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>