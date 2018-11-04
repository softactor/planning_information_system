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
                        <form class="form-horizontal" method="post" action="{{url('admin/ministry/store')}}" method="post">
                             <!--to protect csrf-->
                             {{csrf_field()}} 
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="name1">Name (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ministry_name'))
                                    <div class="alert-error">{{ $errors->first('ministry_name') }}</div>
                                @endif
                                <input type="text" class="form-control" id="ministry_name" name="ministry_name" value="{{ old('ministry_name') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="name2">Name (Bangla)</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ministry_name_bn'))
                                    <div class="alert-error">{{ $errors->first('ministry_name_bn') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="name2" name="ministry_name_bn" value="{{ old('ministry_name_bn') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="short">Short name<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ministry_short_name'))
                                    <div class="alert-error">{{ $errors->first('ministry_short_name') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="ministry_short_name" name="ministry_short_name" value="{{ old('ministry_short_name') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="code">Code</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ministry_code'))
                                    <div class="alert-error">{{ $errors->first('ministry_code') }}</div>
                                @endif
                                    <input type="text" class="form-control" id="code" name="ministry_code" value="{{ old('ministry_code') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-8">
                                    <input name="submit" type="submit" value="Save" class="btn btn-success">
                                    <a href="{{ url('admin/ministry')}}" class="btn btn-info">Cancel</a>
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