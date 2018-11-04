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
                        <form class="form-horizontal" action="{{url('admin/agency/store')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}} 
                             <div class="form-group">
                                <label class="control-label col-sm-2" for="ministry">Ministry/ Division<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ministry_id'))
                                        <div class="alert-error">{{ $errors->first('ministry_id') }}</div>
                                    @endif
                                    <select class="form-control" id="ministry_id" name="ministry_id" onchange="hideErrorDiv('ministry_id')">
                                        <option value="">Select Ministry</option>
                                        <?php
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "ministry_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('ministries',$order_by);
                                        foreach($result as $data){
                                        ?>
                                        <option value="<?php echo $data->id ?>" {{($data->id == old('ministry_id')) ? 'selected' : ''}}><?php echo $data->ministry_name."(".$data->ministry_name_bn.")" ?></option>
                                        <?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="agency1">Agency (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('agency_name'))
                                    <div class="alert-error">{{ $errors->first('agency_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="agency1" name="agency_name" value="{{ old('agency_name') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="agency2">Agency (Bangla)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('agency_name_bn'))
                                    <div class="alert-error">{{ $errors->first('agency_name_bn') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="agency2" name="agency_name_bn" value="{{ old('agency_name_bn') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="short">Short name<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('agency_short_name'))
                                    <div class="alert-error">{{ $errors->first('agency_short_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="short" name="agency_short_name" value="{{ old('agency_short_name') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="code">Code</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('agency_code'))
                                    <div class="alert-error">{{ $errors->first('agency_code') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="code" name="agency_code" value="{{ old('agency_code') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url('admin/agency')}}" class="btn btn-info">Cancel</a>
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