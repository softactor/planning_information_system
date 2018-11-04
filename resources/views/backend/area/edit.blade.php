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
                       <form class="form-horizontal" action="{{url('admin/area/update')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="div">Division (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('div_id'))
                                    <div class="alert-error">{{ $errors->first('div_id') }}</div>
                                    @endif
                                    <select class="form-control" id="div_id" name="div_id" onchange="loadDistrict(this.value);">
                                        <option value="">Select</option>
                                        @php
                                            $pcdivisions    =   get_table_data_by_table('admdivisions');
                                            foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}" <?php if($division_selected_id==$data->id){ ?>selected<?php } ?>>{{$data->dvname}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="div">District (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="district_id" name="district_id" onchange="loadUpozila(this.value);">
                                        <option value="">Select</option>
                                        @php
                                            $checkParam['table'] = "districts";
                                            $checkWhereParam = [
                                                    ['div_id',       '=', $division_selected_id]
                                            ];
                                            $checkParam['where']    = $checkWhereParam;
                                            $districts  =   get_table_data_by_clause($checkParam);
                                            foreach($districts as $data){
                                        @endphp
                                        <option value="{{$data->id}}" <?php if($district_selected_id==$data->id){ ?>selected<?php } ?>>{{$data->district_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="upa">Upazila (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="upz_id" name='upz_id'>
                                        <option value="">Select</option>
                                        @php
                                            $checkParam['table'] = "upazilas";
                                            $checkWhereParam = [
                                                    ['district_id',       '=', $district_selected_id]
                                            ];
                                            $checkParam['where']    = $checkWhereParam;
                                            $districts  =   get_table_data_by_clause($checkParam);
                                            foreach($districts as $data){
                                        @endphp
                                        <option value="{{$data->id}}" <?php if($edit_data->upz_id==$data->id){ ?>selected<?php } ?>>{{$data->upazila_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="area1">Area (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('area_name'))
                                    <div class="alert-error">{{ $errors->first('area_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="area_name" name="area_name" value="{{ old('area_name',$edit_data->area_name) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="area2">Area (Bangla)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('area_name_bn'))
                                    <div class="alert-error">{{ $errors->first('area_name_bn') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="area_name_bn" name="area_name_bn" value="{{ old('area_name_bn',$edit_data->area_name_bn) }}">
                                </div>    
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-3" for="geo">Geo Code</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('geo_code'))
                                    <div class="alert-error">{{ $errors->first('geo_code') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="geo" name="geo_code" value="{{ old('geo_code',$edit_data->geo_code) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="lati">X</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('upz_x'))
                                    <div class="alert-error">{{ $errors->first('area_x') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="area_x" name="area_x" value="{{ old('area_x',$edit_data->area_x) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="long">Y</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('upz_y'))
                                    <div class="alert-error">{{ $errors->first('area_y') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="area_y" name="area_y" value="{{ old('area_y',$edit_data->area_y) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="edit_id" value="{{$edit_data->id}}">
                                    <input name="submit" type="submit" value="Update" class="btn btn-success">
                                    <a href="{{ url('admin/area')}}" class="btn btn-info">Cancel</a>
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
        function loadDistrict(division_id) {
            if (division_id) {
                $.ajax({
                    url: '{{url("admin/dashbord/loadDivisionByDistrict")}}',
                    type: "get",
                    dataType: "JSON",
                    data: "division_id=" + division_id,
                    success: function (response) {
                        $("#district_id").html(response);
                    }
                });
            }
        }
        function loadUpozila(district_id){
            if(district_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadUpazilaByDistrict")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"district_id="+district_id,
                        success     :function(response){
                            $("#upz_id").html(response);
                        }
                    });
            }
        }
    </script>
@endsection
@endsection