<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MadeEventFromLiveToPast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Events status from live to past!';

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
    public function handle()
    {
        return app(\App\Http\Controllers\EventController::class)->move_events_to_past();
    }
}
