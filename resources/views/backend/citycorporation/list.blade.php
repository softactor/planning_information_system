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
                            @include('backend/search/citycorporation_search')
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
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Category</th>
                                    <th>Name</th>
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
                                    <td>{{ get_data_name_by_id('admdivisions',$data->div_id)->dvname }}</td>
                                    <td>
                                        <?php
                                        if(isset($data->dis_id) && !empty($data->dis_id)){
                                        echo get_data_name_by_id('districts',$data->dis_id)->district_name;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(isset($data->cat_id) && !empty($data->cat_id)){
                                            if($data->cat_id==1){
                                                echo 'City corporation';
                                            }elseif($data->cat_id==2){
                                                echo 'Municipality';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>{{ $data->citycorp_name }}</td>
                                    <td>
                                        <a href="{{ url($edit_url.'/'.$data->id) }}" class="btn btn-xs btn-info">Edit</a>
                                        <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$data->id}}, 'citycorporations');">Delete</button>
                                    </td>

                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3"><div class="no_data_message_style">Sorry, There is no data.</div></td>
                                </tr>
                                @endif
                            </tbody>
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