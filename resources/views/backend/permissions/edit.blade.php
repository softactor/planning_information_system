<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Permission
            <small>Permission Update</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Permission</a></li>
            <li class="active">Permission Update</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="pull-right add_edit_delete_link">
                            <a href="#">
                                <span class="fa fa-plus add_link"></span>
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="POST" action="{{ url('admin/permissions/'.$permission->id) }}">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <label class=" required" for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{ old('name', isset($permission->name) ? $permission->name:'')}}">
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection