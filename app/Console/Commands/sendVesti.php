<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SendVestiService;

class sendVesti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendVesti';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar lista de produtos para Vesti';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(SendVestiService $service)
    {
        $this->info($service->send());
        return 0;
    }
}
