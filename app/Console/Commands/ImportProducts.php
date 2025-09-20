<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductImportService;

class ImportProducts extends Command
{
    protected $signature = 'import:products {filename}';
    protected $description = 'Importa produtos de um arquivo .json informado';

    public function handle(ProductImportService $service)
    {
        dd("Caiuuu aqui");
        // $this->info($service->import($this->argument('filename') . '.json'));
        return 0;
    }
}
