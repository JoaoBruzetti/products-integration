<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\ProductImportService;

class ImportProducts extends Command
{
    protected $signature = 'import:products {filename}';
    protected $description = 'Importa produtos de um arquivo .json informado';

    public function handle(ProductImportService $service)
    {
        $filename = $this->argument('filename') . '.json';
        $path = base_path($filename);
        if (!File::exists($path)) {
            $this->error("Arquivo {$filename} não encontrado!");
            return 1;
        }
        $json = File::get($path);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            $this->error("Arquivo {$filename} inválido!");
            return 1;
        }
        $inseridos = $service->import($data);
        $this->info(count($inseridos) . ' produtos importados!');
        return 0;
    }
}
