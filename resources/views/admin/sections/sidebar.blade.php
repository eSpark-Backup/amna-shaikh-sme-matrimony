<aside class="page-sidebar aside-dark bg-dark">
	<div class="h-100 flex-column d-flex" data-simplebar>
		<!--Aside-logo-->
		<div class="aside-logo">
			<a href="#" class="d-block">
				<div class="d-flex align-items-center flex-no-wrap text-truncate">
					<!--Sidebar-icon-->
					<span class="fs-5 lh-1">
						<img src="{{ asset('admin-assets/assets/media/logo/Group 3209.png') }}" id="header-logo">
					</span>
				</div>
			</a>
		</div>
		<!--Aside-Menu-->
		<div class="aside-menu px-2 my-auto flex-column-fluid">
			<nav class="flex-grow-1 h-100" id="page-navbar">
				<!--:Sidebar nav-->
				<ul class="nav flex-column collapse-group collapse d-flex pt-4">
					<li class="nav-item">
						<a href="{{route('admin.dashboard')}}" class="nav-link d-flex align-items-center text-truncate active">
							<span class="sidebar-icon">
								<i data-feather="activity" class="fe-2x"></i>
							</span>
							<!--Sidebar nav text-->
							<span class="sidebar-text">Dashboard</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('admin/admins') }}"
							class="nav-link d-flex align-items-center text-truncate">
							<span class="sidebar-icon">
								<i class="far fa-user"></i>
							</span>
							<span class="sidebar-text">Admins</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('admin/members') }}"
							class="nav-link d-flex align-items-center text-truncate">
							<span class="sidebar-icon">
								<i class="fa fa-users"></i>
							</span>
							<span class="sidebar-text">Members</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('admin/plans') }}"
							class="nav-link d-flex align-items-center text-truncate">
							<span class="sidebar-icon">
								<i class="far fa-paper-plane"></i>
							</span>
							<span class="sidebar-text">Plans</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('admin/stories') }}"
							class="nav-link d-flex align-items-center text-truncate">
							<span class="sidebar-icon">
								<i class="far fa-thumbs-up"></i>
							</span>
							<span class="sidebar-text">Stories</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('admin/events') }}"
							class="nav-link d-flex align-items-center text-truncate">
							<span class="sidebar-icon">
								<i class="far fa-calendar"></i>
							</span>
							<span class="sidebar-text">Events</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ url('admin/feedback') }}"
							class="nav-link d-flex align-items-center text-truncate">
							<span class="sidebar-icon">
								<i class="far fa-comments"></i>
							</span>
							<span class="sidebar-text">FeedBack</span>
						</a>
					</li>
					<li class="nav-item">
						<a data-bs-toggle="collapse"
							class="nav-link d-flex align-items-center text-truncate"
							aria-expanded="false" href="#ui-pages">
							<span class="sidebar-icon">
								<i class="fa fa-edit" aria-hidden="true"></i>
							</span>
							<!--Sidebar nav text-->
							<span class="sidebar-text">Email Templates</span>
						</a>
						<ul id="ui-pages" class="sidebar-dropdown list-unstyled collapse">
							<li class="sidebar-item">
								<a href="{{ url('admin/email-templates') }}" class="sidebar-link">
									Email Templates
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a data-bs-toggle="collapse"
							class="nav-link d-flex align-items-center text-truncate"
							aria-expanded="false" href="#config">
							<span class="sidebar-icon">
								
								<i class="fa fa-cogs" aria-hidden="true"></i>
							</span>
							<!--Sidebar nav text-->
							<span class="sidebar-text">Configuration</span>
						</a>
						<ul id="config" class="sidebar-dropdown list-unstyled collapse">
							<li class="sidebar-item">
								<a href="{{ url('admin/onbehalf') }}" class="sidebar-link">
									On Behalf
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/countries') }}" class="sidebar-link">
									Countries
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/states') }}" class="sidebar-link">
									States
								</a>
							</li><li class="sidebar-item">
								<a href="{{ url('admin/cities') }}" class="sidebar-link">
									Cities
								</a>
							</li>
						</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/castes') }}" class="sidebar-link">
									Castes
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/religions') }}" class="sidebar-link">
									Religions
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/languages') }}" class="sidebar-link">
									Languages
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/family-values') }}" class="sidebar-link">
									Family Values
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/family-status') }}" class="sidebar-link">
									Family Status
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/marital-status') }}" class="sidebar-link">
									Mrital Status
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/educations') }}" class="sidebar-link">
									Educations
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/occupations') }}" class="sidebar-link">
									Occupations
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/specialisations') }}" class="sidebar-link">
									Specialisations
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/working-with') }}" class="sidebar-link">
									Working With
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/nationality') }}" class="sidebar-link">
									Nationality
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ url('admin/sibling') }}" class="sidebar-link">
									Sibling
								</a>
							</li>
						</ul>
					</li>
					</li><li class="nav-item">
						<a href="{{ url('admin/general-settings') }}"
							class="nav-link d-flex align-items-center text-truncate">
							<span class="sidebar-icon">
								<i class="fa fa-cog"></i>
							</span>
							<span class="sidebar-text">General Settings</span>
						</a>
					</li>
					</li><li class="nav-item">
						<a href="{{ url('admin/seo-settings') }}"
							class="nav-link d-flex align-items-center text-truncate">
							<span class="sidebar-icon">
								<i class="fa fa-cog"></i>
							</span>
							<span class="sidebar-text">Seo Settings</span>
						</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</aside>
