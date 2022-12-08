<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Services\AbyssDemoService;

class AbyssDemoCron extends Command
{

    /**
     * Set Service Instance
     * 
     * @var object
     */
    private $service;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abyss:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AbyssDemoService $service)
    {
        parent::__construct();
        $this->service = $service;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Deleting 30 days older records cron job started!");
        $this->service->deleteOlderRecords();
        Log::info("Deleting 30 days older records cron job ended!");
    }
}
