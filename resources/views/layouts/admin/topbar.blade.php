<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-light navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>
    <div class="navbar-collapse collapse flex-lg-1 order-2 order-lg-1" id="navbar-search">
        <div class="navbar-search d-flex align-items-center py-2 py-lg-0">
            
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center flex-1 flex-lg-0 order-1 order-lg-2">
        <ul class="navbar-nav flex-row">

            <li class="nav-item nav-item-dropdown-lg dropdown dropdown-user">
                <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown">
                    <img src="{{url('admin/assets/images/placeholders/admin.png')}}" class="rounded-pill mr-lg-2" height="34" alt="">
                    <span class="d-none d-lg-inline-block">{{Session::get('name')}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{url('admin/logout')}}" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->