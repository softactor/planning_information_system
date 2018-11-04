<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>Update</small>
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
                         <form class="form-horizontal" action="{{url('admin/wing/update')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}} 
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sector">Division of Bangladesh Planning Commission</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="sector" name="pcdivision_id">
                                        <option value="">Select</option>
                                        @php
                                            $pcdivisions    =   get_table_data_by_table('pcdivisions');
                                            foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}" {{ (($edit_data->pcdivision_id==$data->id)? "selected":"") }}>{{$data->pcdivision_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="wing1">Wing (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('wing_name'))
                                    <div class="alert-error">{{ $errors->first('wing_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="wing1" name="wing_name" value="{{ old('wing_name',$edit_data->wing_name) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="wing2">Wing (Bangla)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('wing_name_bn'))
                                    <div class="alert-error">{{ $errors->first('wing_name_bn') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="wing2" name="wing_name_bn" value="{{ old('wing_name_bn',$edit_data->wing_name_bn) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="short">Short name<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('wing_short_name'))
                                    <div class="alert-error">{{ $errors->first('wing_short_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="short" name="wing_short_name" value="{{ old('wing_short_name',$edit_data->wing_short_name) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="edit_id" value="{{$edit_data->id}}">
                                    <input name="submit" type="submit" value="Update" class="btn btn-success">
                                    <a href="{{ url('admin/wing')}}" class="btn btn-info">Cancel</a>
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