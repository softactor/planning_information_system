<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User information
            <small>Update</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User</a></li>
            <li class="active">User Edit</li>
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
                        <form class="form-horizontal" method="post" action="{{ url('admin/users/'.$user->id) }}" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <label class="control-label  required col-sm-3" for="email">User name</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('email'))
                                    <div class="alert-error">{{ $errors->first('email') }}</div>
                                    @endif
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ old('email', isset($user->email) ? $user->email:'') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="password">Password</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('password'))
                                    <div class="alert-error">{{ $errors->first('password') }}</div>
                                    @endif
                                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="control-label required col-sm-3" for="first_name">First name</label>                                
                                <div class="col-sm-8">
                                    @if ($errors->has('first_name'))
                                        <div class="alert-error">{{ $errors->first('first_name') }}</div>
                                    @endif
                                    <input type="text" class="form-control" id="first_name" placeholder="Enter first name" name="first_name" value="{{ old('first_name', isset($user->first_name) ? $user->first_name:'') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label required col-sm-3" for="last_name">Last name</label>                                
                                <div class="col-sm-8">
                                    @if ($errors->has('last_name'))
                                        <div class="alert-error">{{ $errors->first('last_name') }}</div>
                                    @endif
                                    <input type="text" class="form-control" id="last_name" placeholder="Enter first name" name="last_name" value="{{ old('last_name', isset($user->last_name) ? $user->last_name:'') }}">
                                </div>
                            </div>                                                        
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="div">Division of Bangladesh Planning Commission</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="pcdivision_id" name="pcdivision_id" onchange="loadWingByPcDivision(this.value);">
                                        <option value="">Select</option>
                                        @php
                                            $pcdivisions    =   get_table_data_by_table('pcdivisions');
                                            foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}" <?php if($user->pcdivision_id==$data->id){ ?>selected<?php } ?>>{{$data->pcdivision_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="wing">Wing</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="wing_id" name="wing_id">
                                        <option value="">Select</option>
                                        @php
                                            $checkParam['table'] = "wings";
                                            $checkWhereParam = [
                                                    ['id',       '=', $user->wing_id]
                                            ];
                                            $checkParam['where']    = $checkWhereParam;
                                            $districts  =   get_table_data_by_clause($checkParam);
                                            foreach($districts as $data){
                                        @endphp
                                        <option value="{{$data->id}}" <?php if($user->wing_id==$data->id){ ?>selected<?php } ?>>{{$data->wing_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pos">Designation</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation', isset($user->designation) ? $user->designation:'') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="mbl">Mobile</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', isset($user->mobile) ? $user->mobile:'') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="mbl">User status</label>
                                <div class="col-sm-8">
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="1" <?php if($user->status==1){ echo "checked";} ?>>Active
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" value="0"<?php if($user->status==0){ echo "checked";} ?>>Inactive
                                    </label>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label  required col-sm-3" for="name">Roles</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('roles'))
                                    <div class="alert-error">{{ $errors->first('roles') }}</div>
                                    @endif
                                    <select class="form-control" id="roles" name="roles[]" multiple="multiple">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                                <?php if (is_array(old('roles')) && in_array($role->name, old('roles')) || in_array($role->name, $user->roles()->pluck('name', 'name')->all())) { ?> selected <?php } ?>
                                                >{{ $role->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(isset($user->image_path))
                            <div class="form-group">
                                <img src="{{asset('uploads/resize_images/'.$user->image_path)}}" class="img-rounded" alt="Cinque Terre"> 
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="control-label required col-sm-3" for="name">Profile image</label>
                                <div class="col-sm-8">
                                    <input type="file" name="profile_image" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ url('admin/users')}}" class="btn btn-info">Cancel</a>
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
@section('footer_js_scrip_area')
    @parent
    <script>
        function loadWingByPcDivision(pcdivision_id) {
            if (pcdivision_id) {
                $.ajax({
                    url: '{{url("admin/dashbord/loadWingByPcDivision")}}',
                    type: "get",
                    dataType: "JSON",
                    data: "pcdivision_id=" + pcdivision_id,
                    success: function (response) {
                        $("#wing_id").html(response);
                    }
                });
            }
        }
    </script>
@endsection
@endsection