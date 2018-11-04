<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small> List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashbord')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url($list_url) }}">{{ $list_title }}</a></li>
            <li class="active">{{ $list_title }} List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @include('backend/pertial/operation_message')
                        <div class="pull-left add_edit_delete_link">
                            @include('backend/search/division_search')
                        </div>
                        <div class="pull-right add_edit_delete_link">
                            <a href="{{ url($list_url) }}">
                                <span class="">Menu</span>
                            </a>
                        </div>  
                        <div class="pull-right add_edit_delete_link">
                            <a href="{{ url($create_url) }}">
                                <span class="">Add new record</span>
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ csrf_field() }}
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Division name</th>
                                    <th>Bangla</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $slNo  =   1;
                                ?>
                                @if(isset($list_data))
                                @foreach ($list_data as $data)
                                <tr id="data_entry_id_{{$data->id}}">
                                    <td class="text-center">{{ $slNo++}}</td>
                                    <td>{{ $data->dvname }}</td>
                                    <td>{{ $data->dvname_bn }}</td>
                                    <td>
                                        <a href="{{ url($edit_url.'/'.$data->id) }}" class="btn btn-xs btn-info">Edit</a>
                                        <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$data->id}}, 'admdivisions');">Delete</button>
                                    </td>

                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3"><div class="no_data_message_style">Sorry, There is no data.</div></td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Division Name</th>
                                    <th>Bangla</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
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