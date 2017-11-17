<?php

namespace Mahalli\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{

    /**
     * Statues 
     */
    const PENDING               = 'PENDING';
    const QUEUED                = 'QUEUED';
    const BUILDING_SITE         = 'BILDING_SITE';
    const BUILDING_WEB_SERVER   = 'BILDING_WEB_SERVERS';
    const INSTALLING_THEME      = 'INSTALLING_THEME';
    const READY                 = 'READY';
    const UNDER_MAINTANUNC      = 'UNDER_MAINTANUNCE';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ecommerce_sites';

    /**
     * The key datatype associated with the model.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'site_domain', 'status', 'site_title', 'admin_email', 
        'admin_user', 'admin_password'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('Mahalli\User', 'user_id');
    }
}
