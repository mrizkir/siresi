<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span >@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="bx bxs-dashboard"></i> <span >DASHBOARDS</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="dashboard-analytics" class="nav-link" >PICKER</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-crm" class="nav-link" >CHECKER</a>
                            </li>
                            <li class="nav-item">
                                <a href="index" class="nav-link" >HAND OFFER</a>
                            </li>
                            <li class="nav-item">
                                <a href="dashboard-crypto" class="nav-link" >ADMIN</a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('scan') }}" 
                        role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="bx bx-layer"></i> <span >SCAN RESI</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts"  role="button"
                        aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="bx bx-layout"></i> <span >LAPORAN</span>
                    </a>
                
                </li> <!-- end Dashboard Menu -->

                <li class="menu-title"><i class="ri-more-fill"></i> <span >@lang('translation.pages')</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="bx bx-user-circle"></i> <span >SETTING</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarPermission" class="nav-link" role="button"
                                    aria-expanded="false" aria-controls="sidebarPermission" >PERMISSION
                                </a>                            
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarUserRoles" class="nav-link"  role="button"
                                    aria-expanded="false" aria-controls="sidebarUserRoles" >ROLES
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('userpicker.index')}}" class="nav-link"  role="button"
                                    aria-expanded="false" aria-controls="sidebarUserPicker" >USER PICKER
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
