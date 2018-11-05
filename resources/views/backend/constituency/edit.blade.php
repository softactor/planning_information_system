<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small> Update</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashbord')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url($list_url) }}">{{ $list_title }}</a></li>
            <li class="active">{{ $list_title }} {{$page}}</li>
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
                        <div class="box-body">
                        <form class="form-horizontal" action="{{url('admin/constituency/update')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="confi">Constituency<span class="required_star">*</span></label>                                
                                <div class="col-sm-8">
                                    @if ($errors->has('const_id'))
                                    <div class="alert-error">{{ $errors->first('const_id') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="const_id" name="const_id" value="{{ old('const_id',$edit_data->const_id) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="name">Name<span class="required_star">*</span></label>                                
                                <div class="col-sm-8">
                                    @if ($errors->has('name'))
                                    <div class="alert-error">{{ $errors->first('name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$edit_data->name) }}">
                                </div>    
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-3" for="lati">X</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('latitude'))
                                    <div class="alert-error">{{ $errors->first('latitude') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude',$edit_data->latitude) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="longitude">Y</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('longitude'))
                                    <div class="alert-error">{{ $errors->first('longitude') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude',$edit_data->longitude) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="edit_id" value="{{$edit_data->id}}">
                                    <input name="submit" type="submit" value="Update" class="btn btn-success">
                                    <a href="{{ url('admin/constituency')}}" class="btn btn-info">Cancel</a>
                                    <a href="{{ url($list_url)}}" class="btn btn-info">Menu</a>
                                </div>
                            </div>
                        </form>
                    </div>
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