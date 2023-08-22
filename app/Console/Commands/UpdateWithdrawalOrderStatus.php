<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateWithdrawalOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:withdrawals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Withdrawal orders status';

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
        return app(\App\Http\Controllers\WithdrawalController::class)->update_withdrawals();
    }
}
