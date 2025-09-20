<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductImportService;

class importProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importProducts {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar produtos a partir de um arquivo JSON';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ProductImportService $service)
    {
        $this->info($service->import($this->argument('filename') . '.json'));
        return 0;
    }
}
