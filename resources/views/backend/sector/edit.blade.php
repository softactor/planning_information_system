<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>{{ $list_title }} {{$page}}</small>
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
                        <form class="form-horizontal" action="{{url('admin/sector/update')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}} 
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sec1">Sector (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('sector_name'))
                                    <div class="alert-error">{{ $errors->first('sector_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="sec1" name="sector_name" value="{{ old('sector_name',$edit_data->sector_name) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sec2">Sector (Bangla)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('sector_name_bn'))
                                    <div class="alert-error">{{ $errors->first('sector_name_bn') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="sec2" name="sector_name_bn" value="{{ old('sector_name_bn',$edit_data->sector_name_bn) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <input type="hidden" name="edit_id" value="{{$edit_data->id}}">
                                    <input name="submit" type="submit" value="Update" class="btn btn-success">
                                    <a href="{{ url('admin/sector')}}" class="btn btn-info">Cancel</a>
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