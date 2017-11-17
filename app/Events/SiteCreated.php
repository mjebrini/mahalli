<?php

namespace Mahalli\Events;

use Carbon\Carbon;
use Illuminate\Foundation\Events\Dispatchable;
use Mahalli\Jobs\SiteCreator;
use Mahalli\Jobs\SetupCommerceDatabase;
use Mahalli\Jobs\SetupCommerceSite;
use Mahalli\Jobs\SetupCommerceTheme;
use Mahalli\Jobs\SetupHttpServices; 
use Illuminate\Queue\SerializesModels; 

class SiteCreated
{
    use Dispatchable , SerializesModels;

    /**
     *  Site instace  
     *  @var string
     */
    public $site;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($site)
    {
        $this->site = $site;
        $this->run();
    }

    /**
     * run the event 
     *
     * @return mixed
     */
    public function run()
    {
        SiteCreator::withChain([
            new SetupCommerceDatabase($this->site),
            new SetupCommerceSite($this->site), 
            new SetupCommerceTheme($this->site),
            new SetupHttpServices($this->site)
        ])->dispatch();
    }
}
