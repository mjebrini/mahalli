<?php 
    $faker =  Faker\Factory::create();
?>
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="{{ Gravatar::src(Auth::user()->email, 160) }}" class="user-image" alt="User Image">
        <span class="hidden-xs">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            <img src="{{ Gravatar::src(Auth::user()->email, 160) }}" class="img-circle" alt="User Image">

            <p>
                {{ Auth::user()->name }}
                <small>Member since {{ Auth::user()->created_at->format("M Y") }} </small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="row">
                <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                </div>
            </div>
            <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <form name="logout" action="{{ route('logout') }}" method="post">
                    {{ csrf_field() }}
                    <a href="javascript:document.logout.submit();" class="btn btn-default btn-flat">Sign out</a>
                </form> 
            </div>
        </li>
    </ul>
</li>
