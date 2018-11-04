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
                        <form class="form-horizontal" action="{{url('admin/district/store')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="div">Division (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('div_id'))
                                    <div class="alert-error">{{ $errors->first('div_id') }}</div>
                                    @endif
                                    <select class="form-control" id="div_id" name="div_id">
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
                                <label class="control-label col-sm-3" for="dis1">District (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('district_name'))
                                    <div class="alert-error">{{ $errors->first('district_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="dis1" name="district_name" value="{{ old('district_name') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="dis2">District (Bangla)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('district_bn'))
                                    <div class="alert-error">{{ $errors->first('district_bn') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="dis2" name="district_bn" value="{{ old('district_bn') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="geo">Geo code</label>
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
                                    @if ($errors->has('dv_x'))
                                    <div class="alert-error">{{ $errors->first('dv_x') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="lati" name="dv_x" value="{{ old('dv_x') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="long">Y</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('dv_y'))
                                    <div class="alert-error">{{ $errors->first('dv_y') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="long" name="dv_y" value="{{ old('dv_y') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url('admin/district')}}" class="btn btn-info">Cancel</a>
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