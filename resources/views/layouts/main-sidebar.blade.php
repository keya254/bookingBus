<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
                @php
                    $setting=App\Models\Setting::first();
                @endphp
				<a class="desktop-logo logo-light active" href="{{ url('/') }}"><img src="{{URL::asset($setting->logo)}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{ url('/') }}"><img src="{{URL::asset($setting->logo)}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ url('/') }}"><img src="{{URL::asset($setting->logo)}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/') }}"><img src="{{URL::asset($setting->logo)}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img class="avatar avatar-xl brround" src="{{URL::asset(auth()->user()->image)}}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{auth()->user()->name}}</h4>
						</div>
					</div>
				</div>
				<ul class="side-menu">
                    @can('dashboard')
					<li class="slide">
						<a class="side-menu__item" href="{{ route('dashboard.index') }}"><span class="side-menu__label">الرئيسية</a>
                    </li>
                    @endcan
                    @can('roles')
                    <li class="slide">
					    <a class="side-menu__item" href="{{ route('roles.index') }}"><span class="side-menu__label">الوظائف</a>
                    </li>
                    @endcan
                    @can('permissions')
                    <li class="slide">
					    <a class="side-menu__item" href="{{ route('permissions.index') }}"><span class="side-menu__label">الصلاحيات</a>
                    </li>
                    @endcan
                    @can('typecars')
                    <li class="slide">
					    <a class="side-menu__item" href="{{ route('typecar.index') }}"><span class="side-menu__label">انواع السيارات</a>
                    </li>
                    @endcan
                    @can('cars')
                    <li class="slide">
					    <a class="side-menu__item" href="{{ route('car.index') }}"><span class="side-menu__label">السيارات</a>
                    </li>
                    @endcan
                    @can('trips')
                    <li class="slide">
					    <a class="side-menu__item" href="{{ route('trip.index') }}"><span class="side-menu__label">الرحلات</a>
                    </li>
                    @endcan
					@can('website-setting')
					<li class="slide">
						<a class="side-menu__item" href="{{ route('setting.index' ) }}"><span class="side-menu__label">الاعدادات</a>
					</li>
					@endcan
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->