<?php

namespace App\Console\Commands;

use App\Services\ProjectBilling\ProjectMonthlyChargeGeneratorService;
use Illuminate\Console\Command;

class GenerateProjectMonthlyChargesCommand extends Command
{
    protected $signature = 'project-billing:generate-monthly-charges {--month= : Month in YYYY-MM format}';

    protected $description = 'Generate monthly project billing charges without duplicating periods.';

    public function handle(ProjectMonthlyChargeGeneratorService $generator): int
    {
        $summary = $generator->generate($this->option('month'));

        $this->info("Generated: {$summary['generated']}");
        $this->line("Skipped: {$summary['skipped']}");

        foreach ($summary['errors'] as $error) {
            $this->error($error);
        }

        return empty($summary['errors']) ? self::SUCCESS : self::FAILURE;
    }
}
