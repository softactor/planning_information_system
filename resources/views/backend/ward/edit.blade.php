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
                       <form class="form-horizontal" action="{{url('admin/ward/update')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}}
                             <div class="form-group">
                                <label class="control-label col-sm-3" for="div">Category<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="cat_id" name="cat_id" onchange="loadCityCropByCat(this.value);">
                                        <option value="">Select</option>
                                        <option value="1"<?php if(isset($edit_data->cat_id) && $edit_data->cat_id==1){ ?>selected<?php } ?>>City corporation</option>
                                        <option value="2"<?php if(isset($edit_data->cat_id) && $edit_data->cat_id==2){ ?>selected<?php } ?>>Municipality</option>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="div">City corporation (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('citycorp_id'))
                                    <div class="alert-error">{{ $errors->first('citycorp_id') }}</div>
                                    @endif
                                    <select class="form-control" id="citycorp_id" name="citycorp_id">
                                        <option value="">Select</option>
                                        @php
                                            $pcdivisions    =   get_table_data_by_table('citycorporations');
                                            foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}" {{ (($edit_data->citycorp_id==$data->id)? "selected":"") }}>{{$data->citycorp_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="ward">Ward (English)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ward_nr'))
                                    <div class="alert-error">{{ $errors->first('ward_nr') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="ward" name="ward_nr" value="{{ old('ward_nr',$edit_data->ward_nr) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="lati">X</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ward_x'))
                                    <div class="alert-error">{{ $errors->first('ward_x') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="lati" name="ward_x" value="{{ old('ward_x',$edit_data->ward_x) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="long">Y</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ward_y'))
                                    <div class="alert-error">{{ $errors->first('ward_y') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="long" name="ward_y" value="{{ old('ward_y',$edit_data->ward_y) }}">
                                </div>    
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-3" for="upa2">Constituency</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('constituency'))
                                    <div class="alert-error">{{ $errors->first('constituency') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="constituency" name="constituency" value="{{ old('constituency',$edit_data->constituency) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="edit_id" value="{{$edit_data->id}}">
                                    <input name="submit" type="submit" value="Update" class="btn btn-success">
                                    <a href="{{ url('admin/ward')}}" class="btn btn-info">Cencel</a>
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
        function loadCityCropByCat(cat_id){
            if(cat_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadCityCropByCat")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"cat_id="+cat_id,
                        success     :function(response){
                            $("#citycorp_id").html(response);
                        }
                    });
            }
        }
    </script>
@endsection
@endsection