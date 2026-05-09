<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Você foi aprovado!</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f9fafb; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb; }
        .header { background: #111827; padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 18px; font-weight: 700; color: #fff; }
        .header span { color: #f59e0b; }
        .body { padding: 32px; }
        .badge { display: inline-block; background: #d1fae5; color: #065f46; font-size: 13px; font-weight: 600; padding: 6px 14px; border-radius: 99px; margin-bottom: 20px; }
        h2 { font-size: 20px; color: #111827; margin: 0 0 8px; }
        p { color: #6b7280; font-size: 15px; line-height: 1.6; margin: 0 0 20px; }
        .card { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px; margin: 20px 0; }
        .card-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
        .card-row:last-child { margin-bottom: 0; }
        .card-label { color: #9ca3af; font-weight: 500; }
        .card-value { color: #111827; font-weight: 600; }
        .btn { display: inline-block; background: #f59e0b; color: #fff; text-decoration: none; font-weight: 700; padding: 12px 28px; border-radius: 8px; font-size: 15px; }
        .footer { background: #f3f4f6; padding: 20px 32px; text-align: center; }
        .footer p { margin: 0; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1><span>TRAMPO</span> GASTRO</h1>
        </div>
        <div class="body">
            <div class="badge">✅ Aprovado!</div>
            <h2>Parabéns, {{ $nomeGarcom }}!</h2>
            <p>Você foi selecionado para um trabalho. Confira os detalhes abaixo e prepare-se para arrasar!</p>

            <div class="card">
                <div class="card-row">
                    <span class="card-label">Vaga</span>
                    <span class="card-value">{{ $tituloVaga }}</span>
                </div>
                <div class="card-row">
                    <span class="card-label">Restaurante</span>
                    <span class="card-value">{{ $nomeRestaurante }}</span>
                </div>
                <div class="card-row">
                    <span class="card-label">Data e Hora</span>
                    <span class="card-value">{{ $dataHora }}</span>
                </div>
                <div class="card-row">
                    <span class="card-label">Cachê</span>
                    <span class="card-value">{{ $valor }}</span>
                </div>
            </div>

            <p>Acesse sua agenda para ver todos os detalhes do trabalho.</p>
            <a href="{{ url('/minha-agenda') }}" class="btn">Ver Minha Agenda</a>
        </div>
        <div class="footer">
            <p>Trampo Gastro — Plataforma de freelas para restaurantes</p>
        </div>
    </div>
</body>
</html>
