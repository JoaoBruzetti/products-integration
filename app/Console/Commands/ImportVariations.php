<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\DTOs\VariationJsonDto;
use App\Services\VariationImportService;

class ImportVariations extends Command
{
    protected $signature = 'import:variations';
    protected $description = 'Importa variações do arquivo variacoes.json';

    public function handle(VariationImportService $service)
    {
        $path = base_path('variacoes.json');
        if (!File::exists($path)) {
            $this->error('Arquivo variacoes.json não encontrado!');
            return 1;
        }
        $json = File::get($path);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            $this->error('Arquivo variacoes.json inválido!');
            return 1;
        }
        $inseridos = $service->import($data);
        $this->info(count($inseridos) . ' variações importadas!');
        return 0;
    }
}
