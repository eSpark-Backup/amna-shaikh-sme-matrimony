<header>
    <div class="top-header">
        <div class="container">
            <div class="header-row">
                <div class="site-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo.svg') }}" alt="logo"></a>
                </div>
                <div class="mobile-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="site-menu">
        <div class="container">
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('user.members') }}">Members</a></li>
                    <li><a href="{{ route('events') }}">Matrimonial Events</a></li>
                    <li><a href="{{ route('user.chat-listing') }}">Chat</a></li>
                    <li><a href="{{ route('user.interests') }}">Interest</a></li>
                    <li><a href="{{ route('stories') }}">Success Stories</a></li>
                    <li><a href="{{ route('plans') }}">Plans</a></li>

                    @auth('user')

                    <div class="site-menu2 d-flex align-items-center ">
                        <li>
                            <div class="dropdown">
                                <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-toggle="dropdown" aria-expanded="true" data-auto-close="outside" data-dropdown-animation="">

                                    <div class="avatar avatar-sm avatar-circle">
                                        <img class="avatar-img" src="{{ checkImage(asset('storage/members/profile-image/' . Session::get('user')->profile_image),'image-svgrepo-com.svg',Session::get('user')->profile_image,1) }}" alt="Image Description">
                                        <!-- <span class="avatar-status avatar-sm-status avatar-status-success"></span> -->
                                    </div>

                                </a>

                                <div class="dropdown-menu" aria-labelledby="accountNavbarDropdown" style="width: 16rem; opacity: 1; transform: translateY(10px) translateY(-10px); transition: transform 300ms ease 0s, opacity 300ms ease 0s;">
                                    <div class="dropdown-item-text">
                                        <div class="d-flex align-items-center">



                                            <div class="flex-grow-1 ml-3">
                                                <h5 class="mb-0">{{ Session::get('user')->first_name }}</h5>
                                                <p class="card-text text-body">{{ Session::get('user')->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{url('user/edit-profile')}}">Profile</a>

                                    <a class="dropdown-item" href="{{ route('user.settings') }}">Settings</a>
                                    <a class="dropdown-item" href="{{ route('user.my_notifications') }}">Notifications</a>
                                    <a class="dropdown-item" href="{{ route('user.transactions') }}">Payment History</a>
                                    <div class="mobile"><a class="dropdown-item" href="{{ route('user.auth.logout') }}">Logout</a></div>


                                    <div class="dropdown-divider"></div>

                                    <!-- <a class="dropdown-item" href="{{ route('user.auth.logout') }}">Logout</a> -->
                                </div>
                        <li class="log"><a href="{{ route('user.auth.logout') }}">Logout</a></li>
                        </li>
                    </div>
        </div>

        @else
        <li><a href="{{ route('login') }}">Login</a></li>
        @endauth

        </ul>

        </nav>
    </div>
    </div>
</header>