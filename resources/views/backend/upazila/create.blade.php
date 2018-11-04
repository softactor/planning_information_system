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
                        <form class="form-horizontal" action="{{url('admin/upazila/store')}}" method="post">
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
                                    <select class="form-control" id="district_id" name="district_id">
                                        <option value="">Select</option>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="upa1">Upazila (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('upazila_name'))
                                    <div class="alert-error">{{ $errors->first('upazila_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="upa1" name="upazila_name" value="{{ old('upazila_name') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="upa2">Upazila (Bangla)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('upazila_name_bn'))
                                    <div class="alert-error">{{ $errors->first('upazila_name_bn') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="upa2" name="upazila_name_bn" value="{{ old('upazila_name_bn') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="geo">Geo Code</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('geo_code'))
                                    <div class="alert-error">{{ $errors->first('geo_code') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="geo" name="geo_code" value="{{ old('geo_code') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="lati">X</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('upz_x'))
                                    <div class="alert-error">{{ $errors->first('upz_x') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="lati" name="upz_x" value="{{ old('upz_x') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="long">Y</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('upz_y'))
                                    <div class="alert-error">{{ $errors->first('upz_y') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="long" name="upz_y" value="{{ old('upz_y') }}">
                                </div>    
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-3" for="upa2">Constituency</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('constituency'))
                                    <div class="alert-error">{{ $errors->first('constituency') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="constituency" name="constituency" value="{{ old('constituency') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url('admin/upazila')}}" class="btn btn-info">Cancel</a>
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
    </script>
@endsection
@endsection