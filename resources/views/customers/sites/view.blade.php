@extends('layouts.app')

@section('content') 
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> Your site <a href="{{ $site->site_domain }}">{{ $site->site_title }}</a>   is: <span class="badge">{{ $site->status }}</span> </h3>
            </div>
            <!-- /.box-header -->
            @if( $site->status != $site::READY )
            <!-- form start --> 
            <div class="box-body"> 
                
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <img src="/images/Blocks.svg" title="Working..." />
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8" >
                        <br/>
                        <strong> Building Your site takes a few steps (approx. 5min): </strong>
                        <ol>
                            <li>Buildig Your Site Strcuture.</li>
                            <li>Installing Web Server.</li>
                            <li>Setup your store theme.</li>
                            <li>Providing your login info to your portal.</li>
                        </ol>
                    </div>
                </div> 
            </div>
            <!-- /.box-body -->
            @else 
            <div class="box-body"> 
                
                <div class="row">
                   
                    <div class="col-md-12 col-sm-12 col-xs-12" >
                        <br/>
                        <strong> Your site is ready, follow the steps to configure your store: </strong>
                        <p>
                            <ul>
                                <li> Access your <a target="_blank" href="{{ $site->site_domain }}/wp-login.php">control panel Here</a> </li>
                                <li> <b>Username:</b> {{ $site->admin_email }}</li>
                                <li> <b>Password:</b> <span onclick="this.innerHTML ='{{ $site->admin_password }}' "> Click to show </span></li>
                            </ul>
                        </p>
                        <strong> Configure your E-Store Products: </strong>
                        <ol>
                            <li>Configure your store 
                                <a target="_blank" href="{{ $site->site_domain }}/wp-admin/admin.php?page=wc-setup"> Payment methods</a></li> 
                        </ol>
                    </div>
                </div> 
            </div>
            @endif
        </div>
    </div> 
</div>
@if( $site->status != $site::READY )
<script>
    setTimeout(function(){ window.location.reload(); }, 3000);
</script>
@endif
@endsection
