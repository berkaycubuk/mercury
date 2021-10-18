<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Core\Models\Cart;
use Carbon\Carbon;

class ClearCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-carts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes old carts';

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
        $carts = Cart::all();

        foreach ($carts as $cart) {
            // after one day
            if (Carbon::now()->greaterThanOrEqualTo($cart->updated_at->addDay())) {
                $cart->delete();
            }
        }

        return 0;
    }
}
