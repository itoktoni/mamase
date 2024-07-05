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
			@if($group_data->system_group_code != 'setting')
			<li>
				<a class="icon {{ request()->segment(2) == $group_data->field_primary ? 'active' : '' }}" href="{{ $group_data->field_url ?? '#' }}"
					data-nav-target="#{{ $group_data->field_primary }}">
					<i data-feather="{{ $group_data->field_icon }}"></i>
					<h5 class="text-center text-white">
						{{ __($group_data->field_name) }}
					</h5>
				</a>
			</li>
			@elseif(auth()->user()->username == 'itoktoni')
			<li>
				<a class="icon {{ request()->segment(2) == $group_data->field_primary ? 'active' : '' }}" href="{{ $group_data->field_url ?? '#' }}"
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

				@php
				$document = asset('files/doc/doc.pdf');

				if(auth()->user()->type != RoleType::Admin) {
					$document = asset('files/doc/'.auth()->user()->type.'.pdf');
				}
				@endphp

				<a target="_blank" class="icon" href="{{ $document }}">
					<i data-feather="book-open"></i>
					<h5 class="text-center text-white">
						Manual Book
					</h5>
				</a>
				@endauth
			</li>

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

@if(Template::greatherAdmin())
<!-- begin::navigation menu -->
<div class="navigation-menu-body" data-turbolinks="false">

	<!-- begin::navigation-logo -->
	<div class="navigation-header">
		<div id="navigation-logo">
			<a href="{{ url('/') }}">
				<img class="logo"
					src="{{ env('APP_LOGO') ? url('files/logo/'.env('APP_LOGO')) : url('assets/media/image/logo.png') }}"
					alt="logo">
			</a>
		</div>
	</div>
	<!-- end::navigation-logo -->

	<div class="navigation-menu-group">

		@if($groups = SharedData::get('groups'))
		@foreach($groups as $group_data)
		<div class="{{ request()->segment(2) == $group_data->field_primary || request()->segment(1) == 'home' ? 'open' : '' }}" id="{{ $group_data->field_primary }}">
			<ul>
				@if($menus = $group_data->has_menu)
				@foreach($menus as $menu)
				@if($menu->field_type == MenuType::Internal)
				<li>
					<a href="{{ $menu->field_action }}">
						<span>{{ $menu->field_name }}</span>
					</a>
				</li>
				@elseif($menu->field_type == MenuType::External)
				<li>
					<a target="_blank" href="{{ $menu->field_action }}">
						<span>{{ $menu->field_name }}</span>
					</a>
				</li>
				@elseif($menu->field_type == MenuType::Devider)
				<li>
					<hr>
				</li>
				@elseif($menu->field_type == MenuType::Menu)
				@php
				$active = request()->segment(2) == $group_data->field_primary && request()->segment(3) == 'default' && request()->segment(4) == $menu->field_primary;
				@endphp
				<li>
					<a class="{{ $active ? 'active' : '' }}" href="{{ $menu->field_action ? route($menu->field_action) : '' }}">
						<span>{{ $menu->field_name }}</span>
					</a>
				</li>
				@elseif($menu->field_type == MenuType::Group)
				@php
				$open = request()->segment(2) == $group_data->field_primary && request()->segment(3) == $menu->field_primary;
				@endphp
				<li class="{{ $open ? 'open' : '' }}">
					<a href="#">{{ $menu->field_name }}</a>
					@if($links = $menu->has_link)
					<ul>
						@foreach($links as $link)
						@php
						$active = $open && request()->segment(4) == $link->field_primary;
						@endphp
						<li>
							<a class="{{ $active ? 'active' : '' }}" href="{{ $link->field_url ? $link->field_url : route($link->field_action) }}">
								{{ $link->field_name }}
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
		@endforeach
		@endif

	</div>
</div>
@endif