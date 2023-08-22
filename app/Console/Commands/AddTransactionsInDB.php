<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddTransactionsInDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will add transactions from valr in to our db. We are creating it for the purpose of cron job which will get hit multiple times a day';

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
        return app(\App\Http\Controllers\TransactionController::class)->transaction_history();
    }
}
