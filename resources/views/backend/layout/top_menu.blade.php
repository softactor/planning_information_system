<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <span class="admin-dashboard-main-top-title">
        Planning Information System (PLIS)<br />
        <span>Bangladesh Planning Commission</span>
    </span>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">            
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    @if(!empty(Auth::user()->image_path))
                        <img src="{{ asset('uploads/resize_images/'.Auth::user()->image_path)}}" class="user-image" alt="User Image">
                    @else
                    <span class="fa fa-user"></span>
                    @endif
                    <span class="hidden-xs">{{ Auth::user()->first_name." ".Auth::user()->last_name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ url('admin/users/'.Auth::user()->id.'/edit') }}" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <!--<a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>-->
                            <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
        </ul>
    </div>
</nav>