<?php

namespace App\Mail\ProjectBilling;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ProjectChargesDueSoonMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Collection $charges,
        public readonly string $cutoffDate,
        public readonly int $days,
        public readonly string $actionUrl,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Pagos de proyectos proximos a vencer')
            ->view('emails.project-billing.charges-due-soon');
    }
}
