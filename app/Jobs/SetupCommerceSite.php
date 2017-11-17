<?php

namespace Mahalli\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mahalli\Models\Site;


class SetupCommerceSite implements ShouldQueue
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
        $site_dir = env('SITES_ROOT') . "/" . $site->admin_user;
        mkdir($site_dir, 0777, true);

        $site->status = $site::BUILDING_SITE;
        $site->save();

        // FIRST COMMAND 
        $command = implode(" ", [
            "wp core download",
            "--locale=en_US",
            "--allow-root",
            "--path=" . $site_dir
        ]);

        $output = "";
        exec($command, $output);
        
        // SECOND COMMAND 
        $command = implode(" ", [
            "cd " . $site_dir . " && ",
            "wp config create",
            "--allow-root",
            "--dbname=mahalli_" . $site->admin_user ,
            "--dbuser=" . env('DB_USERNAME','mahalli_account'),
            "--dbpass=" . env('DB_PASSWORD','zP4VvD6WTeE2Wz4a'),
            "--dbhost=" . env('DB_HOST','35.187.25.201') . ":" . env('DB_PORT','3306'),
            "--skip-check"
        ]);

        $output = "";
        exec($command, $output);

        // THIRD COMMAND
        $command = implode(" ", [
            "cd " . $site_dir . " && ",
            "wp core install",
            "--allow-root",
            "--url=" . $site->site_domain ,
            "--title=\"" . $site->site_title . "\"" ,
            "--admin_user=" . $site->admin_user ,
            "--admin_password=" . $site->admin_password,
            "--admin_email=" . $site->admin_email
        ]);

        $output = "";
        exec($command, $output);

        \Log::info("SetupCommerceSite::disbatched");
    }
}
