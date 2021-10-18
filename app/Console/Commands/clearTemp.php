<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Core\Models\TemporaryFile;
use Carbon\Carbon;

class clearTemp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-temp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears temp media uploads';

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
        $tempFiles = TemporaryFile::all();

        foreach ($tempFiles as $temp) {
            if (Carbon::now()->greaterThanOrEqualTo($temp->created_at->addHour())) {
                unlink(storage_path('app/public/uploads/tmp/' . $temp->folder . '/' . $temp->filename));
                rmdir(storage_path('app/public/uploads/tmp/' . $temp->folder));
                $temp->delete();
            }
        }

        return 0;
    }
}
