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
                        <form class="form-horizontal" action="{{url('admin/citycorporation/update')}}" method="post">
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
                                        <option value="{{$data->id}}" {{ (($edit_data->div_id==$data->id)? "selected":"") }}>{{$data->dvname}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="city1">City corporation (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('citycorp_name'))
                                    <div class="alert-error">{{ $errors->first('citycorp_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="city1" name="citycorp_name" value="{{ old('citycorp_name',$edit_data->citycorp_name) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="city2">City corporation (Bangla)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('citycorp_name_bn'))
                                    <div class="alert-error">{{ $errors->first('citycorp_name_bn') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="city2" name="citycorp_name_bn" value="{{ old('citycorp_name_bn',$edit_data->citycorp_name_bn) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="lati">X</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('citycorp_x'))
                                    <div class="alert-error">{{ $errors->first('citycorp_x') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="lati" name="citycorp_x" value="{{ old('citycorp_x',$edit_data->citycorp_x) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="long">Y</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('citycorp_y'))
                                    <div class="alert-error">{{ $errors->first('citycorp_y') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="long" name="citycorp_y" value="{{ old('citycorp_y',$edit_data->citycorp_y) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="edit_id" value="{{$edit_data->id}}">
                                    <input name="submit" type="submit" value="Update" class="btn btn-success">
                                    <a href="{{ url('admin/citycorporation')}}" class="btn btn-info">Cancel</a>
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