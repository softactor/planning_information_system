<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small> Create</small>
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
                        <form class="form-horizontal" action="{{url('admin/union/store')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="div">Division (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('div_id'))
                                    <div class="alert-error">{{ $errors->first('division_id') }}</div>
                                    @endif
                                    <select class="form-control" id="division_id" name="division_id" onchange="loadDistrict(this.value);">
                                        <option value="">Select</option>
                                        @php
                                            $pcdivisions    =   get_table_data_by_table('admdivisions');
                                            foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}">{{$data->dvname}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="div">District (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="district_id" name="district_id" onchange="loadUpazila(this.value);">
                                        <option value="">Select</option>
                                    </select>
                                </div>    
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-3" for="div">Upazila (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="upz_id" name="upz_id">
                                        <option value="">Select</option>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="upa1">Union (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('bd_union_name'))
                                    <div class="alert-error">{{ $errors->first('bd_union_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="bd_union_name" name="bd_union_name" value="{{ old('bd_union_name') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="lati">X<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('un_x'))
                                    <div class="alert-error">{{ $errors->first('un_x') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="lati" name="un_x" value="{{ old('un_x') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="long">Y<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('un_y'))
                                    <div class="alert-error">{{ $errors->first('un_y') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="long" name="un_y" value="{{ old('un_y') }}">
                                </div>    
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-3" for="constituent">Constituency</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('constituent'))
                                    <div class="alert-error">{{ $errors->first('constituent') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="constituent" name="constituent" value="{{ old('constituent') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url('admin/union')}}" class="btn btn-info">Cancel</a>
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
        function loadDistrict(division_id){
            if(division_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadDivisionByDistrict")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"division_id="+division_id,
                        success     :function(response){
                            $("#district_id").html(response);
                        }
                    });
            }
        }
        function loadUpazila(district_id){
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