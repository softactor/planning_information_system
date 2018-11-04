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
                        <form class="form-horizontal" action="{{url('admin/gisobject/update')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="gis">GIS object information<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('gisobject_name'))
                                    <div class="alert-error">{{ $errors->first('gisobject_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="gis" name="gisobject_name" value="{{ old('gisobject_name',$edit_data->gisobject_name) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="typ">Type<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('gisobject_type'))
                                    <div class="alert-error">{{ $errors->first('gisobject_type') }}</div>
                                    @endif
                                    <select class="form-control" id="gisobject_type" name="gisobject_type">
                                        <option value="">Select</option>
                                        @php
                                            $param['table']  =  "commonconfs";   
                                            $param['where']  =  [
                                                'commonconf_type'   =>  9
                                            ];   
                                            $all_pages = get_table_data_by_clause($param);
                                            foreach($all_pages as $data){
                                        @endphp
                                        <option value="{{$data->commonconf_name}}" {{ (($edit_data->gisobject_type==$data->commonconf_name)? "selected":"") }}>{{$data->commonconf_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <input type="hidden" name="edit_id" value="{{$edit_data->id}}">
                                    <input name="submit" type="submit" value="Update" class="btn btn-success">
                                    <a href="{{ url('admin/gisobject')}}" class="btn btn-info">Cancel</a>
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