<div class="page-header navbar navbar-fixed-top">
    <?php $permissions  = \App\Http\Controllers\Controller::getPermissions(); ?>
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                        <span class="username username-hide-on-mobile"> {{ @Auth::user()->name }} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ url('users/profile') }}">
                                <i class="icon-user"></i>الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="icon-key"></i>تسجيل خروج</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="clearfix"> </div>