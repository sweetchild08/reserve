<!-- ========== TOP MENU ========== -->
<header class="fixed">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle mobile_menu_btn" data-toggle="collapse" data-target=".mobile_menu" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="{{asset('assets/images/sbrlogo.png')}}" height="32" alt="Logo">
            </a>
        </div>
        <nav id="main_menu" class="mobile_menu navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="mobile_menu_title" style="display:none;">MENU</li>
                <li style="margin-top:2px"><a href="{{url('home')}}">HOME</a></li>
                
                <li style="margin-top:2px"><a href="{{url('about-us')}}">ABOUT US</a></li>
                <li style="margin-top:2px"><a href="{{url('contact-us')}}">CONTACT US</a></li>
                <li class="dropdown simple_menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ACCOMMODATIONS <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('services/rooms')}}">ROOMS</a></li>
                        <li><a href="{{url('services/cottage')}}">COTTAGE</a></li>
                        <li><a href="{{url('services/foods')}}">FOODS</a></li>
                        <li><a href="{{url('services/activities')}}">ACTIVITIES</a></li>
                        <li><a href="{{url('services/events')}}">EVENTS</a></li>
                    </ul>
                </li>
                <li class="dropdown simple_menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @if(Session::has('customer_id'))
                            <li><a href="{{url('accounts/my-reservation')}}">My Cart</a></li>
                            <li><a href="{{url('accounts/profile')}}">Profile</a></li>
                            <li><a href="{{url('accounts/change-password')}}">Change Password</a></li>
                            <li><a href="{{url('accounts/logout')}}">Logout</a></li>
                        @else
                            <li><a href="{{url('login1')}}">Login</a></li>
                            <li><a href="{{url('register')}}">Register</a></li>
                            <li><a href="{{url('forgot-password')}}">Forgot Password</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>
