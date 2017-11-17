<?php

namespace Mahalli\Http\Controllers\Customers;

use Illuminate\Http\Request;
use Mahalli\Http\Controllers\Controller;
use Mahalli\Models\Site;
use Mahalli\Repositories\Customer\SiteRepository;
use Uuid;
use Mahalli\Events\SiteCreated;
use Validator;

class SitesController extends Controller
{   
    /**
     * @var SitesController
     */
    private $site = null;

    /**
     * Initialize the controller class
     * 
     * @param SiteRepository $site 
     * @return SitesController
     */
    public function __construct(SiteRepository $site)
    {
        $this->site = $site;
    }

    /**
     * Get a validator for an incoming site creating request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'site_domain' => 
                'required|string|url|max:191|unique:ecommerce_sites,site_domain',
            'site_title' => 'required|string'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $site = $this->site->get($request->user())->first();

        if( ! $site  ) {
            return view('customers.sites.create');
        } else {
            return redirect('customer/site/' . $site->id ); 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = $this->validator($request->all()); 
        if ($validator->fails()) {
            return redirect('customer/site')
                ->withErrors($validator)
                ->withInput();
        }

        $site_uuid = (string) Uuid::generate();

        $site = new Site([
            'id' => $site_uuid,
            'site_title' => $request->site_title,
            'status' => Site::PENDING,
            'site_domain' => $request->site_domain,
            'admin_email' => $request->user()->email,
            'admin_user' => str_random(12),
            'admin_password' => md5(str_random(16)) ]);

        $site->user()->associate($request->user());
        $this->site->put($site);

        // run the events chain
        event(new SiteCreated($site_uuid));

        return redirect('customer/site/' . $site_uuid );
    }

    /**
     * Display the specified resource.
     * 
     * @param  Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {   
        $site = $request->user()->site()->first();

        if( !$site ) {
            abort(404);
        }

        return view('customers.sites.view', [
            'site' => $request->user()->site()->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }
}
