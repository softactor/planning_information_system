<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<style>
    .map_holder{
        float: left;
        width: 97%;
        height: 800px;
        margin: 1% 1%;
    }
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      
      .map_filter{
          position: absolute;
          width: 28%;
          height: 435px;
          border: 1px solid lightgrey;
          z-index: 9999;
          padding: 1%;
          background: white;
          opacity: .9;
      }
      .map_information_area{
        right: 0;
        position: absolute;
        width: 28%;
        height: 235px;
        border: 1px solid lightgrey;
        z-index: 9999;
        padding: 1%;
        opacity: .9;
        background-color: white;
      }
      
    </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
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
            <div class="col-xs-12 col-md-12">
                <div class="box">
                    <div class="box-header">
                        @include('backend/pertial/operation_message') 
<!--                        <div class="pull-left add_edit_delete_link" style="width: 100%;">
                            @include('backend/search/project_quality_review_search')
                        </div>-->
                    </div>
                    
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="map_holder">
                            <div class="map_filter">
                                <form id="map_search" action="" method="post">
                                    <div class="form-group">
                                        <label for="email">Project Type:</label>
                                        <select class="form-control" id="proposal_type_id" name="proposal_type_id">
                                            <option value="">Select proposal type</option>
                                            <?php 
                                            $param['table']  =  "commonconfs";   
                                                $param['where']  =  [
                                                    'commonconf_type'   =>  1
                                                ];   
                                            $proposal = get_table_data_by_clause($param);
                                            foreach($proposal as $type){
                                            ?>
                                            <option value="<?php echo $type->id ?>" {{($type->id == old('proposal_type_id')) ? 'selected' : ''}}><?php echo $type->commonconf_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Division:</label>
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
                                    <div class="form-group">
                                        <label for="email">District:</label>
                                        <select class="form-control" id="district_id" name="district_id" onchange="loadUpozila(this.value);">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Upazila:</label>
                                        <select class="form-control" id="upz_id" name='upz_id'>
                                            <option value="">Select</option>
                                        </select>
                                    </div>
<!--                                    <div class="form-group">
                                        <label for="pwd">Date:</label>
                                        <br>
                                        <input style="float: left;width: 100px; margin: 0 1%;" type="text" class="form-control" id="from_date" placeholder="From Date" name="from_date">
                                        <input style="float: left;width: 100px; margin: 0 1%;" type="text" class="form-control" id="to_date" placeholder="To Date" name="to_date">
                                    </div> -->
                                    <br>
                                    <br>
                                    <button type="button" class="btn btn-default" onclick="plot_map_data();">Search</button>
                                    <button type="button" class="btn btn-default" onclick="plot_map_reset();">Reset</button>
                                </form>
                            </div>
                            <div class="map_information_area" id="map_information_area" style="display: none;">
                                <div class="table-responsive">          
                                    <table class="table" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>Division</td>
                                                <td><span id="div_data"></span></td>
                                            </tr>
                                            <tr>
                                                <td>District</td>
                                                <td><span id="dis_data"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Upazila</td>
                                                <td><span id="upz_data"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Lat</td>
                                                <td><span id="lat_data"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Long</td>
                                                <td><span id="long_data"></span></td>
                                            </tr>
                                            <tr>
                                                <td>Number of project</td>
                                                <td><a target="_blank" href="{{ url('admin/project/temporary_project') }}"><span id="no_of_project_data"></span></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="map"></div>
                        </div>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQZHbQuUmnszDX6jFke6sCT2C1C2n5org"></script>
    <script type="text/javascript">
      var map;
      $(document).ready(function(){
            // we call the function
            initMap = function() {
            var bangladesh = {lat: 23.5, lng: 90};
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: bangladesh,
                disableDefaultUI: true
            });
        }        
        initMap();
        
        //map.data.loadGeoJson('/map/bd-districts.geojson');
        map.data.loadGeoJson('{{asset("/map/bd-districts.geojson")}}');
            map.data.setStyle(function (feature) {
                var divCode = feature.getProperty('Div_ID');
                var dis_id  = feature.getProperty('DistCode');
                if (dis_id < 10) dis_id = "0" + dis_id;
                //division_color = divsion_borderColor(divCode);
                    return {
                        fillColor: 'green',
                        fillOpacity: .6,
                        strokeColor: 'white',
                        strokeWeight: 1.2,
                        zIndex: 100
                    }
                
            });
    });
    </script>
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
        
        function plot_map_data(){
            $.ajax({
                type: "GET",
                url: '{{url("admin/project/get_map_upazila_details")}}',
                dataType: "JSON",
                data: $("#map_search").serialize(),
                success: function (response) {
                    map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                    center: {lat: 23.788328, lng: 90.154256},
                    disableDefaultUI: true,
                });
                map.data.loadGeoJson(response.data);
                map.data.setStyle(function (feature) {    
                return {
                                fillColor: 'red',
                                fillOpacity: .6,
                                strokeColor: 'blue',
                                strokeWeight: 1.2,
                                zIndex: 100
                            }

                });
                map.data.addListener('click', function (event) {
                    $("#map_information_area").show();
                    var randomNumber    =   Math.floor(Math.random() * 6) + 1;  
                    map.data.revertStyle();
                    map.data.overrideStyle(event.feature, {
                        strokeColor: 'white',
                        strokeWeight: 3,
                        fillColor: "#B83D96"
                    });
                    
                    var UpazilaParam = {
                        div_name: event.feature.getProperty('Divi_name'),
                        dis_name: event.feature.getProperty('Dist_name'),
                        upz_name: event.feature.getProperty('Upaz_name'),
                        lat: event.latLng.lat(),
                        lon: event.latLng.lng(),
                        dis_id: event.feature.getProperty('Dis_ID'),
                        upz_id: event.feature.getProperty('Upz_UID'),
                    };
                    
                    $("#div_data").html(UpazilaParam.div_name);
                    $("#dis_data").html(UpazilaParam.dis_name);
                    $("#upz_data").html(UpazilaParam.upz_name);
                    $("#lat_data").html(UpazilaParam.lat);
                    $("#long_data").html(UpazilaParam.lon);
                    $("#no_of_project_data").html(randomNumber);
                    
                });
                }
            });  
        }
        
        function plot_map_reset(){
            $("#map_information_area").hide();
            var bangladesh = {lat: 23.5, lng: 90};
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: bangladesh,
                disableDefaultUI: true
            });
            
            map.data.loadGeoJson('{{asset("/map/bd-districts.geojson")}}');
            map.data.setStyle(function (feature) {
                var divCode = feature.getProperty('Div_ID');
                var dis_id  = feature.getProperty('DistCode');
                if (dis_id < 10) dis_id = "0" + dis_id;
                //division_color = divsion_borderColor(divCode);
                    return {
                        fillColor: 'green',
                        fillOpacity: .6,
                        strokeColor: 'white',
                        strokeWeight: 1.2,
                        zIndex: 100
                    }
                
            });
        }
    </script>
@endsection
@endsection