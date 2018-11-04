<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<!-- Main component for a primary marketing message or call to action -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!-- ./col -->
            @if(hasAccessPermission(Auth::user()->id, 52, 'view'))
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <a href="{{ url('admin/users') }}"> 
                            <h3>
                                <?php
                                $param['table'] = 'users';
                                $param['field'] = 'id';
                                $param['where'] = [
                                    'status' => 1
                                ];
                                echo getTableTotalRows($param)->total;
                                ?>
                            </h3>

                            <p>Users</p>
                        </a>
                    </div>
                    <div class="icon">
                        <a href="{{ url('admin/users') }}"> <i class="fa fa-user-circle"></i></a>
                    </div>
                    <a href="{{ url('admin/users') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            @endif
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <a href="{{ url('admin/project/temporary_project') }}">
                        <h3>
                            <?php
                                $user_type    =   getRoleIdByUserId(Auth::user()->id); 
                                $param['table'] = 'projects';
                                $param['field'] = 'id';
                                if($user_type == 4){
                                    $param['where'] = [
                                        'protemp' => 1,
                                        'is_deleted' => 0
                                    ];
                                }else{
                                    $param['where'] = [
                                        'protemp' => 1,
                                        'is_deleted' => 0,
                                        'user_id' =>Auth::user()->id
                                    ];
                                }
                                echo getTableTotalRows($param)->total;
                                ?>
                        </h3>
                        <p>New Projects</p>
                        </a>
                    </div>
                    <div class="icon">
                        <a href="{{ url('admin/project/temporary_project') }}"><i class="fa fa-cubes"></i></a>
                    </div>
                    <a href="{{ url('admin/project/temporary_project') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            @if(hasAccessPermission(Auth::user()->id, 49, 'view'))
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <a href="{{ url('admin/project/project_quality_review') }}">
                        <h3>
                            <?php
                                $param['table'] = 'projects';
                                $param['field'] = 'id';
                                $param['where'] = [
                                    'protemp'                   => 0,
                                    'quality_review_identity'   => 0,
                                    'is_deleted'                => 0
                                ];
                                echo getTableTotalRows($param)->total;
                                ?>
                        </h3>
                        <p>Projects in QR</p>
                        </a>
                    </div>
                    <div class="icon">
                        <a href="{{ url('admin/project/project_quality_review') }}"><i class="fa fa-cubes"></i></a>
                    </div>
                    <a href="{{ url('admin/project/project_quality_review') }}"  class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>   
            @endif
            @if(hasAccessPermission(Auth::user()->id, 50, 'view'))
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <a href="{{ url('admin/project/project_progress') }}">
                        <h3>
                            <?php
                                $param['table'] = 'projects';
                                $param['field'] = 'id';
                                $param['where'] = [
                                    'protemp'                   => 3,
                                    'quality_review_identity'   => 0,
                                    'is_deleted'                => 0
                                ];
                                echo getTableTotalRows($param)->total;
                                ?>
                        </h3>
                        <p>Project in Progress</p>
                        </a>
                    </div>
                    <div class="icon">
                        <a href="{{ url('admin/project/project_progress') }}"><i class="fa fa-cubes"></i></a>
                    </div>
                    <a href="{{ url('admin/project/project_progress') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            @endif
            @if(hasAccessPermission(Auth::user()->id, 65, 'view'))
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-maroon">
                    <div class="inner">
                        <a href="{{ url('admin/project/approved_project') }}">
                        <h3>
                            <?php
                                $param['table'] = 'projects';
                                $param['field'] = 'id';
                                $param['where'] = [
                                    'protemp'                   => 2,
                                    'quality_review_identity'   => 0,
                                    'is_deleted'                => 0
                                ];
                                echo getTableTotalRows($param)->total;
                                ?>
                        </h3>
                        <p>Approved project</p>
                        </a>
                    </div>
                    <div class="icon">
                        <a href="{{ url('admin/project/approved_project') }}"><i class="fa fa-cubes"></i></a>
                    </div>
                    <a href="{{ url('admin/project/approved_project') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            @endif
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection