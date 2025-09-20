<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VariationImportService;

class ImportVariations extends Command
{
    protected $signature = 'import:variations {filename}';
    protected $description = 'Importa variações de um arquivo .json informado';

    public function handle(VariationImportService $service)
    {
        $this->info($service->import($this->argument('filename') . '.json'));
        return 0;
    }
}
