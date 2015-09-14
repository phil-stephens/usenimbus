<div class="col-md-2 col-sm-3 sidebar">
    <header>
        <h2><a href="/" title="Nimbus">Nimbus</a></h2>
    </header>

    <ul class="nav nav-sidebar">
        <li>{!! link_to_route('droplet_files_path', 'Files', $droplet->id) !!}</li>
        <li>{!! link_to_route('edit_droplet_path', 'Settings', $droplet->id) !!}</li>
        <li>{!! link_to_route('droplet_security_path', 'Security', $droplet->id) !!}</li>
    </ul>

    <footer>
        <ul class="nav nav-sidebar">
            <li><a href="{{ route('logout_path') }}">{{ Auth::user()->name }} <span class="text-muted small">Logout</span></a></li>
        </ul>

        <a href="http://alchemydigital.com.au" class="alchemy-credit">made by <span>Alchemy</span></a>
    </footer>

</div>