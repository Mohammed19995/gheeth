<!-- BEGIN SIDEBAR -->
<?php
$permission_user = Auth::user()->permissions->pluck('name')->toArray();

?>
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            @if(count(array_intersect(['home_page'] , $permission_user)) > 0)

                <li class="nav-item start {{ @$menu == 'home' ? 'active open' : '' }}">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="icon-home"></i>
                        <span class="title">الرئيسية</span>
                        <span class="selected"></span>
                    </a>
                </li>

            @endif
            @if(count(array_intersect(['user_display' , 'user_create' , 'user_update' , 'user_delete'] , $permission_user)) > 0)
                <li class="nav-item {{ (@$selected == 'users') ? 'active open' : '' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-user"></i>
                        <span class="title">المستخدمين</span>
                        <span class="arrow {{ (@$selected == 'users') ? 'open' : '' }}"></span>
                    </a>
                    <ul class="sub-menu" style="display: {{ (@$selected == 'users') ? 'block' : 'none' }}">

                        @if(in_array('user_create' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'users-create') ? 'active open' : '' }}">
                                <a href="{{ url('users/create') }}" class="nav-link">
                                    <i class="fa fa-user-plus"></i>
                                    <span class="title">اضافة مستخدم جديد</span>
                                </a>
                            </li>
                        @endif


                        @if(in_array('user_display' , $permission_user) || in_array('user_update' , $permission_user) || in_array('user_delete' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'Display-user') ? 'active open' : '' }}">

                                <a href="{{ url('users') }}" class="nav-link">
                                    <i class="fa fa-eye"></i>
                                    <span class="title"> عرض المستخدمين</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            @if(count(array_intersect(['broker_display' , 'broker_create' , 'broker_update' , 'broker_delete'] , $permission_user)) > 0)
                <li class="nav-item {{ (@$menu == 'brokers') ? 'open active' : '' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-tag"></i>
                        <span class="title">الوسطاء</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">

                        @if(in_array('broker_create' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'broker-create') ? 'open active' : '' }} ">
                                <a href="{{ url('brokers/create') }}" class="nav-link">
                                    <i class="fa fa-plus"></i>
                                    <span class="title">اضافة وسيط جديد</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif

                        @if(in_array('broker_display' , $permission_user) || in_array('broker_update' , $permission_user) || in_array('broker_delete' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'broker-display') ? 'open active' : '' }} ">
                                <a href="{{ url('brokers') }}" class="nav-link">
                                    <i class="fa fa-eye"></i>
                                    <span class="title">عرض الوسطاء</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif


            @if(count(array_intersect(['donor_display' , 'donor_create' , 'donor_update' , 'donor_delete'] , $permission_user)) > 0)
                <li class="nav-item {{ (@$menu == 'donors') ? 'open active' : '' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-gift"></i>
                        <span class="title">المتبرعين</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">


                        @if(in_array('donor_create' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'donors-create') ? 'open active' : '' }} ">
                                <a href="{{ url('donors/create') }}" class="nav-link">
                                    <i class="fa fa-plus"></i>
                                    <span class="title">اضافة متبرع جديد</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif

                        @if(in_array('donor_display' , $permission_user) || in_array('donor_update' , $permission_user) || in_array('donor_delete' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'display-donors') ? 'open active' : '' }} ">
                                <a href="{{ url('donors') }}" class="nav-link">
                                    <i class="fa fa-eye"></i>
                                    <span class="title">عرض المتبرعين</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif


            @if(count(array_intersect(['project_display' , 'project_create' , 'project_update' , 'project_delete'] , $permission_user)) > 0)
                <li class="nav-item {{ (@$menu == 'projects') ? 'open active' : '' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-tasks"></i>
                        <span class="title">المشاريع</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">


                        @if(in_array('project_create' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'projects-create') ? 'open active' : '' }} ">
                                <a href="{{ url('projects/create') }}" class="nav-link">
                                    <i class="fa fa-plus"></i>
                                    <span class="title">اضافة مشروع جديد</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif

                        @if(in_array('project_display' , $permission_user) || in_array('project_update' , $permission_user) || in_array('project_delete' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'display-projects') ? 'open active' : '' }} ">
                                <a href="{{ url('projects') }}" class="nav-link">
                                    <i class="fa fa-eye"></i>
                                    <span class="title">عرض المشاريع</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif


            @if(count(array_intersect(['donation_display' , 'donation_create' , 'donation_update' , 'donation_delete'] , $permission_user)) > 0)
                <li class="nav-item {{ (@$menu == 'donations') ? 'open active' : '' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-gift"></i>
                        <span class="title">التبرعات</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">

                        @if(in_array('donation_create' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'donations-create') ? 'open active' : '' }} ">
                                <a href="{{ url('donations/create') }}" class="nav-link">
                                    <i class="fa fa-plus"></i>
                                    <span class="title">اضافة تبرع جديد</span>
                                    <span class="selected"></span>
                                </a>
                            </li>

                        @endif

                        @if(in_array('donation_display' , $permission_user) || in_array('donation_update' , $permission_user) || in_array('donation_delete' , $permission_user))
                            <li class="nav-item {{ (@$sub_menu == 'display-donations') ? 'open active' : '' }} ">
                                <a href="{{ url('donations') }}" class="nav-link">
                                    <i class="fa fa-eye"></i>
                                    <span class="title">عرض التبرعات</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(in_array('search' , $permission_user))
                <li class="nav-item {{ (@$menu == 'search') ? 'open active' : '' }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-search"></i>
                        <span class="title">صفحة البحث</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">


                        <li class="nav-item {{ (@$sub_menu == 'projects-search') ? 'open active' : '' }} ">
                            <a href="{{ url('searchProject') }}" class="nav-link">
                                <i class="fa fa-search"></i>
                                <span class="title">المشاريع</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <li class="nav-item {{ (@$sub_menu == 'donors-search') ? 'open active' : '' }} ">
                            <a href="{{ url('searchDonor') }}" class="nav-link">
                                <i class="fa fa-search"></i>
                                <span class="title">المتبرعين</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <li class="nav-item {{ (@$sub_menu == 'brokers-search') ? 'open active' : '' }} ">
                            <a href="{{ url('searchBroker') }}" class="nav-link">
                                <i class="fa fa-search"></i>
                                <span class="title">الوسطاء</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        {{--
                        <li class="nav-item {{ (@$sub_menu == 'broker-donor-search') ? 'open active' : '' }} ">
                            <a href="{{ url('searchBrokerDonor') }}" class="nav-link">
                                <i class="fa fa-search"></i>
                                <span class="title">الوسطاء والمتبرعين</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                       --}}
                        <li class="nav-item {{ (@$sub_menu == 'donations-search') ? 'open active' : '' }} ">
                            <a href="{{ url('searchDonation') }}" class="nav-link">
                                <i class="fa fa-search"></i>
                                <span class="title">التبرعات</span>
                                <span class="selected"></span>
                            </a>
                        </li>


                    </ul>
                </li>
            @endif

            @if(in_array('import' , $permission_user))
                <li class="nav-item {{ (@$sub_menu == 'import') ? 'active' : '' }} ">
                    <a href="{{ url('import') }}" class="nav-link">
                        <i class="fa fa-file"></i>
                        <span class="title">استيراد</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            @if(in_array('export' , $permission_user))
                <li class="nav-item {{ (@$sub_menu == 'export') ? 'active' : '' }} ">
                    <a href="{{ url('export') }}" class="nav-link">
                        <i class="fa fa-file"></i>
                        <span class="title">تصدير</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endif

            <li class="nav-item start ">
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="fa fa-sign-out"></i>
                    <span class="title">تسجيل الخروج</span>
                    <span class="selected"></span>
                </a>
            </li>

        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
