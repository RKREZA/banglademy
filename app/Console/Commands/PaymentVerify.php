<?php

namespace App\Console\Commands;

use App\Http\Controllers\PaymentController;
use Illuminate\Console\Command;

class PaymentVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify payment transaction';

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
//        takes 2 seconds to run
        (new PaymentController)->paymentTranCheck();

    }
}
