<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('voyager.dashboard') }}">
                    <div class="logo-icon-container">
                            <img src="storage/{{ setting('site.logo') }}" alt="Logo Icon">
                    </div>
                    <div class="title">{{ setting('site.title') }}</div><br />
                    <small>{{ setting('site.description')  }}</small>
                </a>
            </div><!-- .navbar-header -->

            <div class="panel widget center bgimage"
                 style="background-image:url({{ Voyager::image( Voyager::setting('admin.bg_image'), voyager_asset('images/bg.jpg') ) }}); background-size: cover; background-position: 0px;">
                <div class="dimmer"></div>
                @if(\Auth::check())
                    <div class="panel-content">
                        <img src="{{ $user_avatar }}" class="avatar" alt="{{ app('VoyagerAuth')->user()->name }} avatar">
                        <h4>{{ ucwords(app('VoyagerAuth')->user()->name) }}</h4>
                        <p>{{ app('VoyagerAuth')->user()->email }}</p>

                        <a href="{{ route('voyager.profile') }}" class="btn btn-primary">{{ __('voyager::generic.profile') }}</a>
                        <div style="clear:both"></div>
                    </div>
                @endif
            </div>

        </div>
        <div id="clientmenu">
            {{ menu('page','menu') }}
        </div>
    </nav>
</div>
