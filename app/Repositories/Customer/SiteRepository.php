<?php 

namespace Mahalli\Repositories\Customer;

use Mahalli\Models\Site;
use Mahalli\User;

class SiteRepository {

    /**
     * Get the sites related to the customer 
     * @param Mahali\User $customer 
     * @return Mahalli\Models\Site
     */
    public function get(User $customer)
    {
        return $customer->site();
    }

    /**
     * Get the sites related to the customer 
     * @param Mahalli\Models\Site $site 
     * @return Mahalli\Models\Site
     */
    public function put(Site $site)
    {
        return $site->save();
    }
}
