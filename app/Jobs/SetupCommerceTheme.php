<?php

namespace Mahalli\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mahalli\Models\Site;

class SetupCommerceTheme implements ShouldQueue
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
        $bop_plugin = env('SITES_REPO') . "/plugins/woocommerce-gateway-bop.zip";

        $site->status = $site::INSTALLING_THEME;
        $site->save();

        // FIRST COMMAND
        $command = implode(" ", [
            "cd " . $site_dir . " && ",
            "wp plugin install woocommerce --activate"
        ]);

        $output = "";
        exec($command, $output);

        // SECOND COMMAND
        $command = implode(" ", [
            "cd " . $site_dir . " && ",
            "wp plugin install " . $bop_plugin 
        ]);

        $output = "";
        exec($command, $output); 

        \Log::info("SetupCommerceTheme::disbatched");
    }
}
