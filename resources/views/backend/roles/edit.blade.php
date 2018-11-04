<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Role information
            <small>Update</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Role</a></li>
            <li class="active">Role Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @include('backend/pertial/operation_message')                        
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" action="{{ url('admin/roles/'.$role->id) }}">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <label class=" required" for="name">Name</label>
                                @if ($errors->has('name'))
                                    <div class="alert-error">{{ $errors->first('name') }}</div>
                                @endif
                                <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{ old('name', isset($role->name) ? $role->name:'') }}">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-0 col-sm-8 custom_button_left_align">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ url('admin/roles')}}" class="btn btn-info">Cancel</a>
                                    <a href="{{ url($list_url)}}" class="btn btn-info">Menu</a>
                                </div>
                            </div>
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