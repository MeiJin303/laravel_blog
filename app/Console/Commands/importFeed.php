<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiSetting;
use Facade\Ignition\LogRecorder\LogMessage;
use GuzzleHttp\Psr7\Message;

class importFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import feed from the API Urls which are due';

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
        $settings = ApiSetting::where('next_executed_at', '<=', now())
        ->where('active', '=', '1')->get();
        $num = 0;
        foreach($settings as $s) {
            if($s->fetch())
                $num++;
        }
        $msg = "Execute {$num} API feed imports at ".now()->format('Y-m-d H:i:s');
        info($msg);
        return $msg;
    }
}
