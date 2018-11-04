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
                        <form class="form-horizontal" action="{{url('admin/ward/store')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}}
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
                                        <option value="{{$data->id}}">{{$data->citycorp_name}}</option>
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
                                    <input type="text" class="form-control" id="ward" name="ward_nr" value="{{ old('ward_nr') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="lati">X</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ward_x'))
                                    <div class="alert-error">{{ $errors->first('ward_x') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="lati" name="ward_x" value="{{ old('ward_x') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="long">Y</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ward_y'))
                                    <div class="alert-error">{{ $errors->first('ward_y') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="long" name="ward_y" value="{{ old('ward_y') }}">
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
@endsection