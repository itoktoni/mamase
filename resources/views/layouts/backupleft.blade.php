<div class="navigation-menu-tab">
    <div class="flex-grow-1">
        <ul>
            <li>
                <a class="icon {{ request()->segment(1) == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <i data-feather="bar-chart-2"></i>
                    <h5 class="text-center text-white">
                        Dashboard
                    </h5>
                </a>
            </li>
            @if($groups = SharedData::get('groups'))
            @foreach($groups as $group_data)
            @if(Views::auth(auth()->user()->role, $group_data->field_primary))
            <li>
                <a class="icon {{ request()->segment(2) == $group_data->field_primary ? 'active' : '' }}" href="#"
                    data-nav-target="#{{ $group_data->field_primary }}">
                    <i data-feather="{{ $group_data->field_icon }}"></i>
                    <h5 class="text-center text-white">
                        {{ __($group_data->field_name) }}
                    </h5>
                </a>
            </li>
            @endif
            @endforeach
            @endif

            <li>
                @auth
                <a class="icon" href="{{ route('logout') }}">
                    <i data-feather="log-out"></i>
                    <h5 class="text-center text-white">
                        Logout
                    </h5>
                </a>
                @else
                <a class="icon" href="{{ route('login') }}">
                    <i data-feather="log-in"></i>
                    <h5 class="text-center text-white">
                        Login
                    </h5>
                </a>
                @endauth
            </li>

        </ul>
    </div>
</div>

<!-- begin::navigation menu -->
<div class="navigation-menu-body" data-turbolinks="false">

    <!-- begin::navigation-logo -->
    <div class="navigation-header">
        <div id="navigation-logo">
            <a href="{{ url('/') }}">
                <img class="logo" src="{{ env('APP_LOGO') ? url('storage/'.env('APP_LOGO')) : url('assets/media/image/logo.png') }}" alt="logo">
            </a>
        </div>
    </div>
    <!-- end::navigation-logo -->

    <div class="navigation-menu-group">
        @if($access = SharedData::get('access'))
        @foreach($access as $acc_key => $acc_data)
        @if(Views::auth(auth()->user()->role, $acc_key))
        <div class="{{ $acc_key == request()->segment(2) || request()->segment(1) == 'home' ? 'open' : '' }}" id="{{ $acc_key }}">
            <ul>
                @if($acc_data)
                @foreach($acc_data as $acc)
                @php
                $check_access = (request()->segment(2) == $acc[Routes::field_group()] && request()->segment(3) ==
                $acc[Routes::field_primary()]);
                $sub_menu = $acc->has_menu->where('menu_show', 1);
                $check_sub_menu = $sub_menu->count() ?? 0;
                $highlight_module = request()->segment(3) == $acc[Routes::field_primary()];
                @endphp
                @if(Views::auth(auth()->user()->role, $acc_key, $acc[Routes::field_primary()]))
                <li class="{{ $highlight_module ? 'open' : '' }}">
                    <a class="{{ $check_access ? 'active' : '' }}"
                        href="{{ $acc[Routes::field_report()] == 1 ? route($acc[Routes::field_primary()].'.getCreate') : route($acc[Routes::field_primary()].'.getTable') }}">
                        <span>
                               {{ __($acc[Routes::field_name()]) }}
                        </span>
                    </a>
                    @if($check_sub_menu)
                    <ul>
                        @foreach($sub_menu as $menu)
                        @php
                        $menu_code = str_replace('get_','', Str::snake($menu->field_primary));
                        @endphp
                        <li>
                            <a class="{{ $check_access && request()->segment(4) == $menu_code ? 'active' : '' }}"
                                href="{{ route($acc[Routes::field_primary()].'.'.$menu->field_primary) }}">{{ __($menu->field_name) }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endif
                @endforeach
                @endif
            </ul>
        </div>
        @endif
        @endforeach
        @endif

    </div>
</div>
<!-- end::navigation menu -->