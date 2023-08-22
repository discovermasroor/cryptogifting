<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateTransactionOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:transaction:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update transactions whose status have been in progress be default';

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
        return app(\App\Http\Controllers\TransactionController::class)->update_orders();
    }
}
