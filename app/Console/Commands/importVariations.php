<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VariationImportService;


class importVariations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importVariations {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar variações de produtos a partir de um arquivo JSON';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
     public function handle(VariationImportService $service)
    {
        $this->info($service->import($this->argument('filename') . '.json'));
        return 0;
    }
}
