<header class="navbar py-0 page-header navbar-expand navbar-light bg-white shadow-lg px-4">
	<a href="index.html" class="navbar-brand d-block d-lg-none">
		<div class="d-flex align-items-center flex-no-wrap text-truncate">
			<!--Sidebar-icon-->
			<span class="sidebar-icon bg-primary rounded-3 size-40 text-white">
				<svg width="16" height="18" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="0.399994" width="4" height="12" fill="white"/>
					<path d="M5.89998 9.6C7.1465 9.6 8.34196 9.09429 9.22338 8.19411C10.1048 7.29394 10.6 6.07304 10.6 4.8C10.6 3.52696 10.1048 2.30606 9.22338 1.40589C8.34196 0.505713 7.1465 2.4787e-07 5.89998 0L5.89998 4.8L5.89998 9.6Z" fill="white"/>
				</svg>
			</span>
		</div>
	</a>
	<ul class="navbar-nav ms-auto d-flex align-items-center h-100">
		
		<li
			class="nav-item dropdown d-flex align-items-center justify-content-center flex-column h-100">
			<a href="#"
				class="nav-link dropdown-toggle rounded-2 p-1 lh-1 pe-1 pe-md-2 d-flex align-items-center justify-content-center"
				aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
				<div class="d-flex align-items-center">
					<!--Avatar with status-->					
					<span class="d-none d-md-inline-block">{{ Auth::user()->name }}</span>
				</div>
			</a>
			<div class="dropdown-menu mt-0 pt-0 dropdown-menu-end overflow-hidden">
				<!--User meta-->
				<div class="position-relative overflow-hidden p-3 mb-3 border-bottom">
					<h5 class="mb-1">{{ Auth::user()->name }}</h5>
				</div>
				<a href="{{ url('admin/manage-profile') }}">Manage Profile</a>
				<a href="{{ route('admin.auth.logout') }}" class="dropdown-item d-flex align-items-center" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					<i data-feather="log-out" class="fe-1x opacity-50 align-middle me-2"></i>
					Sign out
				</a>
			</div>
		</li>

		<form id="logout-form" action="{{ route('admin.auth.logout') }}" method="POST"
            style="display: none;">
            {{ csrf_field() }}
        </form>

		<li
			class="nav-item dropdown ms-1 ms-lg-3 d-flex d-lg-none align-items-center justify-content-center flex-column h-100">
			<a href="#"
				class="nav-link sidebar-trigger-lg-down hover-bg-primary text-secondary size-35 p-0 d-flex align-items-center justify-content-center rounded-circle">
				<i data-feather="menu" class="fe-2x"></i>
			</a>
		</li>
	</ul>
</header>
		<!--Main Header End-->
