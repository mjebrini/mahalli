<?php

namespace Mahalli\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mahalli\Models\Site;

class SetupCommerceDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     *  Site instace  
     *  @var string
     */
    public $site;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($site)
    {
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $site = Site::find($this->site);

        $site->status = $site::QUEUED;
        $site->save(); 

        $command = implode(" ", [
            'DB_HOST=' . env('DB_HOST','35.187.25.201'), 
            'DB_USER=' . env('DB_USERNAME','mahalli_account'), 
            'DB_PASS=' . env('DB_PASSWORD','zP4VvD6WTeE2Wz4a'), 
            'DB_PORT=' . env('DB_PORT', '3306') ,
            'NEW_DB_NAME=mahalli_' . $site->admin_user ,
            'node-create-db'
        ]);

        $output = "";
        exec($command, $output);

        \Log::info("SetupCommerceDatabase::disbatched :: " . $site->site_title);
    }
}
