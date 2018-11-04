<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
            <small>User Update</small>
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
                                <label class="control-label  required col-sm-3" for="email">User Name</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('email'))
                                    <div class="alert-error">{{ $errors->first('email') }}</div>
                                    @endif
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ old('email', isset($user->email) ? $user->email:'') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="old_password">Old Password</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('old_password'))
                                    <div class="alert-error">{{ $errors->first('old_password') }}</div>
                                    @endif
                                    <input type="password" class="form-control" id="old_password" placeholder="Enter old password" name="old_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="password">Enter new Password</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('password'))
                                    <div class="alert-error">{{ $errors->first('password') }}</div>
                                    @endif
                                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="password_confirmation">Confirm Password</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('password'))
                                    <div class="alert-error">{{ $errors->first('password_confirmation') }}</div>
                                    @endif
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="Enter confirm password" name="password_confirmation">
                                    <span>
                                        one upper case, one lower case, one digit[0-9],one special character[#?!@$%^&*-],minimum length 6.
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ url('admin/dashbord')}}" class="btn btn-info">Cancel</a>
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