<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\HouseService;

class ImportHouses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magic:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import house data from external API';

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
     * @return mixed
     */
    public function handle()
    {
        try {

            $houseService = new HouseService();

            $houseService->import_from_api();

        } catch (\Exception $e) {
            $this->error("An error occurred while updating the movies");
        }
    }
}
