<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Vaga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Nova Vaga para Garçom</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('vagas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Título da Vaga</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ex: Garçom - Evento de Sábado" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Valor do Cache (R$)</label>
                            <input type="number" name="valor_pago" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data e Hora</label>
                            <input type="datetime-local" name="data_hora_inicio" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Publicar Vaga</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>