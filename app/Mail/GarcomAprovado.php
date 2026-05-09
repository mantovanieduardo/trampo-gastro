<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GarcomAprovado extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nomeGarcom,
        public string $tituloVaga,
        public string $nomeRestaurante,
        public string $dataHora,
        public string $valor,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Você foi aprovado! — ' . $this->tituloVaga,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.garcom_aprovado',
        );
    }
}
