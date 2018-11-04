<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>List</small>
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
                        <div class="pull-left add_edit_delete_link" style="width: 100%;">
                            @include('backend/search/on_project_progress_search')
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ csrf_field() }}
                        @if(isset($list_data))
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Short</th>
                                    <th>Code</th>
                                    <th>Wing</th>
                                    <th>Sub Sector</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $slNo  =   1;
                                ?>
                                @foreach ($list_data as $data)
                                <tr id="data_entry_id_{{$data->id}}">
                                    <td class="text-center">{{ $slNo++}}</td>
                                    <td>{{ $data->project_entry_date }}</td>
                                    <td>{{ $data->project_name_eng }}</td>
                                    <td>{{ $data->project_short_name }}</td>
                                    <td>{{ $data->project_app_code }}</td>
                                    <td>
										<?php
                                                if(isset($data->wing_id) && !empty($data->wing_id)){
                                                    $gisresdata =   get_data_name_by_id('wings',$data->wing_id);
                                                    if(isset($gisresdata) && !empty($gisresdata)){
                                                        echo $gisresdata->wing_short_name;  
                                                    }
                                                }
                                            ?>
				    </td>
                                    <td>{{ ((isset($data->subsector_id) && !empty($data->subsector_id)) ? get_data_name_by_id('subsectors',$data->subsector_id)->subsector_name:"") }}</td>
                                    <td>
                                        <a href="{{ url($edit_url.'/'.$data->id) }}" class="btn btn-xs btn-info">View</a>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Short</th>
                                    <th>Code</th>
                                    <th>Wing</th>
                                    <th>Sub Sector</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        @endif
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
        function loadConstituencyByUpz(upz_id){
            if(district_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadConstituencyByUpz")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"upz_id="+upz_id,
                        success     :function(response){
                            if(response.status == 'success'){
                                $('#constituency').val(response.data)
                            }
                        }
                    });
            }
        }
        function loadConstituencyByWard(ward_id){
            if(district_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadConstituencyByWard")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"ward_id="+ward_id,
                        success     :function(response){
                            if(response.status == 'success'){
                                $('#constituency').val(response.data)
                            }
                        }
                    });
            }
        }
        function disableOtherLocationInput(locationType){
            if(locationType == 1){
                //--------------------all disable area--------------------------
                $('#city_corp_id option[value=""]').attr("selected",true);
                $('#city_corp_id').prop('disabled', 'disabled');
                
                $('#ward_id option[value=""]').attr("selected",true);
                $('#ward_id').prop('disabled', 'disabled');
                
                $("#roadno").val("");
//                $("#roadno").prop('disabled', true);
                //--------------------------------------------------------------
                
                //---------------------all enable area--------------------------
                $('#div_id').prop('disabled', false);                
                $('#district_id').prop('disabled', false);                
                $('#upz_id').prop('disabled', false);                
                $("#area").prop('disabled', false);
                //--------------------------------------------------------------
            }
            
            if(locationType == 2){
               
                //---------------------all enable area--------------------------
                $('#city_corp_id').prop('disabled', false);                
                $('#ward_id').prop('disabled', false);                
//                $("#roadno").prop('disabled', false);
                //--------------------------------------------------------------
                
                //--------------------all disable area--------------------------
                $('#div_id option[value=""]').attr("selected",true);
                $('#div_id').prop('disabled', 'disabled');
                
                $('#district_id option[value=""]').attr("selected",true);
                $('#district_id').prop('disabled', 'disabled');
                
                $('#upz_id option[value=""]').attr("selected",true);
                $('#upz_id').prop('disabled', 'disabled');
                
                $("#area").val("");
                $("#area").prop('disabled', true);
                //--------------------------------------------------------------
            }
        }
        function loadUnionByUpazila(upz_id){
            if(upz_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadUnionByUpazila")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"upz_id="+upz_id,
                        success     :function(response){
                            $('#union_id').html(response)
                        }
                    });
            }
        }
        function loadUnionByUpazila(upz_id){
            if(upz_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadUnionByUpazila")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"upz_id="+upz_id,
                        success     :function(response){
                            $('#union_id').html(response)
                        }
                    });
            }
        }
        function loadWingByPcdivision(pcdivision_id){
            if(pcdivision_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadWingByPcDivision")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"pcdivision_id="+pcdivision_id,
                        success     :function(response){
                            $('#wing_id').html(response)
                        }
                    });
            }
        }
    </script>
@endsection
@endsection