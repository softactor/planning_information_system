<?php
    $filename = $_SERVER['REQUEST_URI'];
    $str = explode("/",$filename);
    $route_name     =   "/".$str[1]."/".$str[2]; 
    
?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <!--
        hasAccessPermission is a method to check the user has access this link or not
        @param1 =   user_id
        @param2 =   common config id which denotes a config name from commonconfs table(Here 52 means Dashbord);
        @param3 =   denote page type. it means view, add edit or delete
    -->
    @if(hasAccessPermission(Auth::user()->id, 52, 'view'))
    <li class="{{ ((isset($active_menu) && $active_menu=='adminstrator')? 'active treeview':"treeview") }}">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>User Administration</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <!--<li class="{{ (($route_name=='/admin/permissions')? 'active':"") }}"><a href="{{ url('admin/permissions') }}"><i class="fa fa-circle-o"></i> Permission Information</a></li>-->
            <li class="{{ (($route_name=='/admin/roles')? 'active':"") }}"><a href="{{ url('admin/roles') }}"><i class="fa fa-circle-o"></i> Role Information</a></li>
            <li class="{{ (($route_name=='/admin/users')? 'active':"") }}"><a href="{{ url('admin/users') }}"><i class="fa fa-circle-o"></i> User</a></li>
            <li class="{{ (($route_name=='/admin/roles')? 'active':"") }}"><a href="{{ url('admin/dashbord/role_assign') }}"><i class="fa fa-circle-o"></i> Role Assign</a></li>
        </ul>
    </li>
    <li class="{{ ((isset($active_menu) && $active_menu=='setup')? 'active treeview':"treeview") }}">
        <a href="#">
            <i class="fa fa-gears"></i> <span>Setup Information</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (($route_name=='/admin/ministry')? 'active':"") }}"><a href="{{ url('admin/ministry') }}"><i class="fa fa-circle-o"></i> Ministry/ Division Information</a></li>
            <li class="{{ (($route_name=='/admin/agency')? 'active':"") }}"><a href="{{ url('admin/agency') }}"><i class="fa fa-circle-o"></i> Agency Information</a></li>
            <li class="{{ (($route_name=='/admin/wing')? 'active':"") }}"><a href="{{ url('admin/wing') }}"><i class="fa fa-circle-o"></i> Wing Information</a></li>
            <li class="{{ (($route_name=='/admin/sector')? 'active':"") }}"><a href="{{ url('admin/sector') }}"><i class="fa fa-circle-o"></i> Sector Information</a></li>
            <li class="{{ (($route_name=='/admin/subsector')? 'active':"") }}"><a href="{{ url('admin/subsector') }}"><i class="fa fa-circle-o"></i> Sub-Sector Information</a></li>
            <li class="{{ (($route_name=='/admin/gisobject')? 'active':"") }}"><a href="{{ url('admin/gisobject') }}"><i class="fa fa-circle-o"></i> GIS Object Information</a></li>
            <li class="{{ (($route_name=='/admin/commonconf')? 'active':"") }}"><a href="{{ url('admin/commonconf') }}"><i class="fa fa-circle-o"></i> Common Configuration</a></li>
            <li class="{{ (($route_name=='/admin/constituency')? 'active':"") }}"><a href="{{ url('admin/constituency') }}"><i class="fa fa-circle-o"></i> Constituency Information</a></li>
        </ul>
    </li>
    <li class="{{ ((isset($active_menu) && $active_menu=='location')? 'active treeview':"treeview") }}">
        <a href="#">
            <i class="fa fa-building"></i> <span>Location Information</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (($route_name=='/admin/division')? 'active':"") }}"><a href="{{ url('admin/division') }}"><i class="fa fa-circle-o"></i> Division Information</a></li>
            <li class="{{ (($route_name=='/admin/district')? 'active':"") }}"><a href="{{ url('admin/district') }}"><i class="fa fa-circle-o"></i> District Information</a></li>
            <li class="{{ (($route_name=='/admin/upazila')? 'active':"") }}"><a href="{{ url('admin/upazila') }}"><i class="fa fa-circle-o"></i> Upazila Information</a></li>
            <li class="{{ (($route_name=='/admin/union')? 'active':"") }}"><a href="{{ url('admin/union') }}"><i class="fa fa-circle-o"></i> Union Information</a></li>
            <!--<li class="{{ (($route_name=='/admin/area')? 'active':"") }}"><a href="{{ url('admin/area') }}"><i class="fa fa-circle-o"></i> Area Information</a></li>-->
            <li class="{{ (($route_name=='/admin/citycorporation')? 'active':"") }}"><a href="{{ url('admin/citycorporation') }}"><i class="fa fa-circle-o"></i> City Corporation Information</a></li>
            <li class="{{ (($route_name=='/admin/ward')? 'active':"") }}"><a href="{{ url('admin/ward') }}"><i class="fa fa-circle-o"></i> Ward Information</a></li>
        </ul>
    </li>
    @endif
    <!--
        hasAccessPermission is a method to check the user has access this link or not
        @param1 =   user_id
        @param2 =   common config id which denotes a config name from commonconfs table(Here 48 means New Project Information);
        @param3 =   denote page type. it means view, add edit or delete
    -->
    @if(hasAccessPermission(Auth::user()->id, 48, 'view'))
    <li class="{{ ((isset($active_menu) && $active_menu=='project')? 'active treeview':"treeview") }}">
        <a href="#">
            <i class="fa fa-support"></i> <span>Project Information</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @if(hasAccessPermission(Auth::user()->id, 48, 'add'))
            <li class="{{ (($route_name=='/admin/project')? 'active':"") }}"><a href="{{ url('admin/project/project_create') }}"><i class="fa fa-circle-o"></i> New Project</a></li>
            @endif
            @if(hasAccessPermission(Auth::user()->id, 48, 'add'))
            <li class="{{ (($route_name=='/admin/project')? 'active':"") }}"><a href="{{ url('admin/project/temporary_project') }}"><i class="fa fa-circle-o"></i> Final Save</a></li>
            @endif
            @if(hasAccessPermission(Auth::user()->id, 54, 'view'))
                <li class="{{ (($route_name=='/admin/project')? 'active':"") }}"><a href="{{ url('admin/project/revised_projects') }}"><i class="fa fa-circle-o"></i> <span>Revised Project</span></a></li>
            @endif
            <!--<li class="{{ ((isset($active_menu) && $active_menu=='approved')? 'active':"") }}"><a href="{{ url('admin/project/on_project_progress') }}"><i class="fa fa-circle-o"></i> View projects (Other wing)</a></li>-->
        </ul>
    </li>  
    @endif 
    <!--
        hasAccessPermission is a method to check the user has access this link or not
        @param1 =   user_id
        @param2 =   common config id which denotes a config name from commonconfs table(Here 49 means Quality Controll);
        @param3 =   denote page type. it means view, add edit or delete
    -->
    @if(hasAccessPermission(Auth::user()->id, 49, 'view'))
    <li class="{{ ((isset($active_menu) && $active_menu=='quality_control')? 'active treeview':"treeview") }}">
        <a href="#">
            <i class="fa fa-gg"></i> <span>Quality Review</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @if(hasAccessPermission(Auth::user()->id, 49, 'view'))
                <li class="{{ ((isset($active_menu) && $active_menu=='quality_control')? 'active':"") }}"><a href="{{ url('admin/project/project_quality_review') }}"><i class="fa fa-circle-o"></i> <span>New Project</span></a></li>
                <li class="{{ ((isset($active_menu) && $active_menu=='quality_control')? 'active':"") }}"><a href="{{ url('admin/project/revised_quality_review') }}"><i class="fa fa-circle-o"></i> <span>Revised Project</span></a></li>
            @endif
            -->
        </ul>
    </li>  
    @endif
    <!--
        hasAccessPermission is a method to check the user has access this link or not
        @param1 =   user_id
        @param2 =   common config id which denotes a config name from commonconfs table(Here 50 means Project Progress);
        @param3 =   denote page type. it means view, add edit or delete
    -->
    @if(hasAccessPermission(Auth::user()->id, 50, 'view'))
    <li class="{{ ((isset($active_menu) && $active_menu=='project_progress')? 'active treeview':"treeview") }}">
        <a href="#">
            <i class="fa fa-gg"></i> <span>Project Progress</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @if(hasAccessPermission(Auth::user()->id, 50, 'view'))
                <li class="{{ ((isset($active_menu) && $active_menu=='project_progress')? 'active':"") }}"><a href="{{ url('admin/project/project_progress') }}"><i class="fa fa-circle-o"></i> <span>Manage project (Own wing)</span></a></li>
            @endif
            <li class="{{ ((isset($active_menu) && $active_menu=='approved')? 'active':"") }}"><a href="{{ url('admin/project/on_project_progress') }}"><i class="fa fa-circle-o"></i> View projects (Other wing)</a></li>
            @if(hasAccessPermission(Auth::user()->id, 67, 'view'))
			<li class="{{ ((isset($active_menu) && $active_menu=='approved')? 'active':"") }}"><a href="{{ url('admin/project/approved_project') }}"><i class="fa fa-circle-o"></i> View approved projects</a></li>
			@endif
        </ul>
    </li>  
    @endif
    <!--
        hasAccessPermission is a method to check the user has access this link or not
        @param1 =   user_id
        @param2 =   common config id which denotes a config name from commonconfs table(Here 65 means Existing approved project);
        @param3 =   denote page type. it means view, add edit or delete
    -->
    
    <!--
        hasAccessPermission is a method to check the user has access this link or not
        @param1 =   user_id
        @param2 =   common config id which denotes a config name from commonconfs table(Here 49 means Quality Controll);
        @param3 =   denote page type. it means view, add edit or delete
    -->
    
        
    <!--<li class="{{ ((isset($active_menu) && $active_menu=='plis_gis')? 'active':"") }}"><a href="{{ url('admin/project/plis_gis') }}"><i class="fa fa-circle-o"></i> PLIS-GIS</a></li>-->
    <li class="{{ ((isset($active_menu) && $active_menu=='reports')? 'active':"") }}"><a href="http://127.0.0.1:8090/scriptcase/app/plis/plis_reports/plis_reports.php?nmgp_outra_jan=true&nmgp_start=SC&script_case_session=9nok4040006qpt4lnibjuqcnn6&4645" target="_blank"><i class="fa fa-circle-o"></i> Reports</a></li>-->
	
	
	
	<li class="{{ ((isset($active_menu) && $active_menu=='plis_gis')? 'active treeview':"treeview") }}">
        <a href="#">
            <i class="fa fa-gg"></i> <span>PLIS-GIS</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <!--@if(hasAccessPermission(Auth::user()->id, 50, 'view'))-->
                <li class="{{ ((isset($active_menu) && $active_menu=='plis_gis')? 'active':"") }}"><a href="http://172.16.3.120:6080/arcgis/manager/" target="_blank"><i class="fa fa-circle-o"></i> Local Server</a></li>
            <!--@endif-->
				<li class="{{ ((isset($active_menu) && $active_menu=='plis_gis')? 'active':"") }}"><a href="http://gtz.maps.arcgis.com/home/index.html" target="_blank"><i class="fa fa-circle-o"></i>Web Server</a></li>
            <!--@if(hasAccessPermission(Auth::user()->id, 67, 'view'))-->
			
			<!--@endif-->
        </ul>
    </li>  
	
	
	
</ul>