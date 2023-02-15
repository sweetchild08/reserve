<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- App logo and controls -->
    <div class="navbar navbar-dark bg-dark-100 navbar-static border-0">
        <div class="navbar-brand flex-fill wmin-0">
            <a href="index.html" class="d-inline-block">
                <img src="{{url('admin/assets/images/sbrlogo.png')}}" class="sidebar-resize-hide" alt="">
                <img src="{{url('admin/assets/images/sbrlogo.png')}}" class="sidebar-resize-show" alt="">
            </a>
        </div>

        <ul class="navbar-nav align-self-center ml-auto sidebar-resize-hide">
            <li class="nav-item dropdown">
                <button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                    <i class="icon-transmission"></i>
                </button>

                <button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                    <i class="icon-cross2"></i>
                </button>
            </li>
        </ul>
    </div>
    <!-- /app logo and controls -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section sidebar-section-body user-menu-vertical text-center">
            <div class="card-img-actions d-inline-block">
                <img class="img-fluid rounded-circle" src="{{url('admin/assets/images/placeholders/logo.png')}}" width="80" height="80" alt="">
                <div class="card-img-actions-overlay card-img rounded-circle">
                    <a href="#" class="btn btn-white btn-icon btn-sm rounded-pill">
                    <img src="{{url('admin/assets/images/sbrlogo.png')}}" class="sidebar-resize-show" alt="">
                    </a>
                </div>
            </div>

            <div class="sidebar-resize-hide position-relative mt-2">
                <div class="dropdown">
                    <div class="cursor-pointer" >
                        <h6 class="font-weight-semibold  mb-0">{{Session::get('name')}}</h6>
                        <span class="d-block text-muted">Administrator</span>
                    </div>

                </div>
            </div>
        </div>
        <!-- /user menu -->

        
        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header pt-0"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item">
                    <a href="{{url('admin/dashboard')}}" id="dashboard" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item nav-item-submenu" id="bookings-must-open">
                    <a href="#" class="nav-link"><i class="icon-address-book"></i> <span>Bookings</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Bookings">
                        <li class="nav-item"><a href="{{url('admin/bookings/rooms')}}" id="bookings-rooms" class="nav-link">Rooms</a></li>
                        <li class="nav-item"><a href="{{url('admin/bookings/cottages')}}" id="bookings-cottages" class="nav-link">Cottages</a></li>
                        <li class="nav-item"><a href="{{url('admin/bookings/foods')}}" id="bookings-foods" class="nav-link">Foods</a></li>
                        <li class="nav-item"><a href="{{url('admin/bookings/events')}}" id="bookings-events" class="nav-link">Events</a></li>
                        <li class="nav-item"><a href="{{url('admin/bookings/activities')}}" id="bookings-activities" class="nav-link">Activities</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/transactions/pos') }}" class="nav-link"><i class="icon-stack"></i> <span>Point of Sales</span></a>
                </li>

                <li class="nav-item nav-item-submenu" id="inventory-must-open">
                    <a href="#" class="nav-link"><i class="icon-list"></i> <span>Inventory</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Bookings">
                        <li class="nav-item"><a href="{{route('admin.inventory.products')}}" id="inventory-products" class="nav-link @if($title=='Products') active @endif">Products</a></li>
                        <li class="nav-item"><a href="{{route('admin.inventory.category')}}"  class="nav-link @if($title=='Product Categories') active @endif">Categories</a></li>
                        {{-- <li class="nav-item"><a href="{{url('admin/inventory/category')}}" id="inventory-category" class="nav-link">Category</a></li> --}}
                        <li class="nav-item"><a href="{{route('admin.inventory.stocks')}}" id="inventory-stocks" class="nav-link @if($title=='Stocks') active @endif">Stocks</a></li>
                        <li class="nav-item"><a href="{{route('admin.inventory.deployments')}}" id="inventory-deployments" class="nav-link @if($title=='Deployments') active @endif">Deployments</a></li>
                        {{-- <li class="nav-item"><a href="{{route('admin.inventory.returns')}}" id="inventory-deployments" class="nav-link">Returns</a></li> --}}
                    </ul>
                </li>

                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Manage Transactions</div> <i class="icon-menu" title="Content Management System"></i></li>
                

                <li class="nav-item nav-item-submenu" id="transactions-must-open">
                    <a href="#" class="nav-link"><i class="icon-folder-open"></i> <span>Transactions</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Transactions">
                        <li class="nav-item"><a href="{{url('admin/transactions/rooms')}}" id="transactions-rooms" class="nav-link">Rooms</a></li>
                        <li class="nav-item"><a href="{{url('admin/transactions/cottages')}}" id="transactions-cottages" class="nav-link">Cottages</a></li>
                        <li class="nav-item"><a href="{{url('admin/transactions/foods')}}" id="transactions-foods" class="nav-link">Foods</a></li>
                        <li class="nav-item"><a href="{{url('admin/transactions/events')}}" id="transactions-events" class="nav-link">Events</a></li>
                        <li class="nav-item"><a href="{{url('admin/transactions/activities')}}" id="transactions-activities" class="nav-link">Activities</a></li>
                    </ul>
                </li>
                <!-- Layout -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Content Management System</div> <i class="icon-menu" title="Content Management System"></i></li>
                <li class="nav-item nav-item-submenu" id="rooms-must-open">
                    <a href="#" class="nav-link"><i class="icon-stack2"></i> <span>Rooms</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Rooms">
                        <li class="nav-item"><a href="{{url('admin/rooms/create')}}" id="rooms-create" class="nav-link">Create</a></li>
                        <li class="nav-item"><a href="{{url('admin/rooms/category')}}" id="rooms-category" class="nav-link">Category</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu" id="cottages-must-open">
                    <a href="#" class="nav-link"><i class="icon-stack2"></i> <span>Cottages</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Cottages">
                        <li class="nav-item"><a href="{{url('admin/cottages/create')}}" id="cottages-create" class="nav-link">Create</a></li>
                        <li class="nav-item"><a href="{{url('admin/cottages/category')}}" id="cottages-category" class="nav-link">Category</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu" id="foods-must-open">
                    <a href="#" class="nav-link"><i class="icon-stack2"></i> <span>Foods</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Foods">
                        <li class="nav-item"><a href="{{url('admin/foods/create')}}" id="foods-create" class="nav-link">Create</a></li>
                        <li class="nav-item"><a href="{{url('admin/foods/category')}}" id="foods-category" class="nav-link">Category</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu" id="events-must-open">
                    <a href="#" class="nav-link"><i class="icon-stack2"></i> <span>Events</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Events">
                        <li class="nav-item"><a href="{{url('admin/events/create')}}" id="events-create" class="nav-link">Create</a></li>
                        <li class="nav-item"><a href="{{url('admin/events/category')}}" id="events-category" class="nav-link">Category</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu" id="activities-must-open">
                    <a href="#" class="nav-link"><i class="icon-stack2"></i> <span>Activities</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Foods">
                        <li class="nav-item"><a href="{{url('admin/activities/create')}}" id="activities-create" class="nav-link">Create</a></li>
                        <li class="nav-item"><a href="{{url('admin/activities/category')}}" id="activities-category" class="nav-link">Category</a></li>
                    </ul>
                </li>
                
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">User Management</div> <i class="icon-menu" title="User Management"></i></li>

                <li class="nav-item">
                    <a href="{{url('admin/customers')}}" id="customers" class="nav-link">
                        <i class="icon-users"></i>
                        <span>Customers</span>
                    </a>
                </li>

                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">REPORTS</div> <i class="icon-menu" title="Content Management System"></i></li>

                <li class="nav-item">
                    <a href="{{url('admin/reports/sales-report')}}" id="sales-report" class="nav-link">
                        <i class="icon-graph"></i>
                        <span>Sales Report</span>
                    </a>
                </li>

                
                <!-- /layout -->
                    
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->