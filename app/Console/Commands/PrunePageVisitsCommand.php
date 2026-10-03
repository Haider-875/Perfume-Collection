<?php

namespace App\Console\Commands;

use App\Models\PageVisit;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PrunePageVisitsCommand extends Command
{
    protected $signature = 'visitors:prune {--days=60 : Days of telemetry to retain}';
    protected $description = 'Prune old page visits to maintain optimal MySQL database performance on shared hosting';

    public function handle()
    {
        $days = (int) $this->option('days');
        $cutoff = Carbon::now()->subDays($days);

        $count = PageVisit::where('visited_at', '<', $cutoff)->delete();

        $this->info("Pruned {$count} historical page visit records older than {$days} days.");

        return Command::SUCCESS;
    }
}
