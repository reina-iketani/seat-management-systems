<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Reservedelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservedelete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '５日前の予約を削除';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservedel_controller = app()->make('App\Http\Controllers\ReservesController');
        $reservedel_controller->reservedelete();
        
        return Command::SUCCESS;
    }
}
