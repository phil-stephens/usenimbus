<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        @section('nav-header')
        <div class="navbar-header std-navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <a class="navbar-brand site-title" href="/">Nimbus</a>
        </div>
        @show

        <div class="collapse navbar-collapse" id="navbar-collapse">
            @yield('extra-nav-links')

            <ul class="nav navbar-nav navbar-right">
                @if( ! Auth::check())
                <li>{!! link_to_route('login_path', 'Login') !!}</li>
                <li>{!! link_to_route('register_path', 'Sign Up') !!}</li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>{!! link_to_route('droplets_path', 'Your Droplets') !!}</li>
                        <li>{!! link_to_route('storage_path', 'Your Storage') !!}</li>
                        <li>{!! link_to_route('edit_user_path', 'Your Account') !!}</li>
                        <li class="divider"></li>
                        <li>{!! link_to_route('logout_path', 'Logout') !!}</li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>