<?php

namespace App\Console\Commands;

use App\Service\IntegrationOneC;
use Illuminate\Console\Command;

class GetSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for cron';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $integration;


    public function __construct(IntegrationOneC $integration)
    {
        parent::__construct();
        $this->integration = $integration;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->integration->getScheduleForDate();
    }
}
