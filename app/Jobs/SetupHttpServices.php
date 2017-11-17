<?php

namespace Mahalli\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mahalli\Models\Site;

class SetupHttpServices implements ShouldQueue
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
        $server_path = env('SITES_ROOT') . "/" . $site->admin_user;
        $config_path = env('SITES_CONF') . "/" . $site->admin_user . ".conf";
        $server_name = str_replace("http://" , "" , $site->site_domain);
        $server_name = str_replace("https://" , "" , $server_name);

        $site->status = $site::BUILDING_WEB_SERVER;
        $site->save();

        $nginx_config = 'server {
            
              #change this
              server_name '. $server_name .';
            
              #chnage this
              root '.$server_path.';
            
            
              index index.php index.html;
            
              location /
              {
                  try_files $uri  /index.php?$args;
              }
            
              location ~ \.php$
              {
                try_files $uri =404;
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_index  index.php;
            
            
                #chnage this
                fastcgi_pass unix:/run/php/php7.0-fpm.sock;
                #fastcgi_pass   127.0.0.1:9000;
              }
            }';

        $nginx_file = fopen($config_path, "w");
        fwrite($nginx_file, $nginx_config);
        fclose($nginx_file);

        // SECOND COMMAND
        $command = "sudo nginx -s reload"  ;

        $output = "";
        exec($command, $output); 

        $site->status = $site::READY;
        $site->save();

        \Log::info("SetupHttpServices::disbatched");
    }
}
