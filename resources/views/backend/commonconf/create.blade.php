<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>Create</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashbord')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url($list_url) }}">{{ $list_title }}</a></li>
            <li class="active">{{ $list_title }} Create</li>
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
                        <form class="form-horizontal" action="{{url('admin/commonconf/store')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="confi">Common configuration<span class="required_star">*</span></label>                                
                                <div class="col-sm-8">
                                    @if ($errors->has('commonconf_name'))
                                    <div class="alert-error">{{ $errors->first('commonconf_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="commonconf_name" name="commonconf_name" value="{{ old('commonconf_name') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="typ">Type<span class="required_star">*</span></label>                                
                                <div class="col-sm-8">
                                        @if ($errors->has('commonconf_type'))
                                            <div class="alert-error">{{ $errors->first('commonconf_type') }}</div>
                                        @endif
                                    <select class="form-control" id="commonconf_type" name="commonconf_type">
                                        <option value="">Select Type</option>
                                        @php
                                            $configType =   get_table_data_by_table('configuration_type');
                                            foreach($configType as $data){
                                        @endphp
                                        <option value="{{$data->id}}" <?php if(old('commonconf_type') && old('commonconf_type')==$data->id){ echo "selected"; } ?>>{{$data->name}}</option>
                                        @php
                                            }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input name="submit" type="submit" value="Save" class="btn btn-success">
                                    <a href="{{ url('admin/commonconf')}}" class="btn btn-info">Cancel</a>
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