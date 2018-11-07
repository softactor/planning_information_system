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
                        <?php
                        
                        $param['table']     = "projects";
                        $param['where']     = [
                            'id'    => Session::get('project_id')
                        ];
                        $pdata              =   get_table_data_by_clause($param);
                        $project_data       =   $pdata[0];
                        ?>
                        <form class="form-horizontal" action="{{ url('admin/project/project_location_store') }}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @include("backend.pertial.project_entry_form_fixed_part")
                            <div class="form-group">                                
                                <label class="control-label col-sm-3" for="loctyp">Location Type,</label>    
                            </div>
                            <div class="form-group">                                
                                <label class="control-label col-sm-3" for="div">
                                    <input type="radio" name="location_type" id="location_type_div" value="1" checked onchange="disableOtherLocationInput(1);">
                                    Division<span class="required_star">*</span>
                                </label>
                                <div class="col-sm-3">
                                    @if ($errors->has('div_id'))
                                        <div class="alert-error">{{ $errors->first('div_id') }}</div>
                                    @endif
                                    <select class="form-control" id="div_id" name="div_id" onchange="loadDistrict(this.value);hideErrorDiv('div_id')">
                                        <option value="">Select</option>
                                        @php
                                        $pcdivisions    =   get_table_data_by_table('admdivisions');
                                        foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}" {{($data->id == old('div_id') || Session::get('div_id')==$data->id) ? 'selected' : ''}}>{{$data->dvname}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>
                                <label class="control-label col-sm-2" for="dis">District<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('district_id'))
                                        <div class="alert-error">{{ $errors->first('district_id') }}</div>
                                    @endif
                                    <select class="form-control" id="district_id" name="district_id" onchange="loadUpozila(this.value);">
                                        <option value="">Select</option>
                                        <?php
                                            if(Session::get('div_id')){
                                            $param['table']  =  "districts";   
                                            $param['where']  =  [
                                                'div_id'   =>  Session::get('div_id')
                                            ];   
                                            $districts = get_table_data_by_clause($param);
                                            foreach($districts as $dis){
                                            ?>
                                        <option value="{{$dis->id}}"{{($dis->id == Session::get('district_id')) ? 'selected' : ''}}>{{$dis->district_name}}</option>
                                            <?php }                                            
                                        } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="upz">Upazila<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="upz_id" name='upz_id' onchange="loadConstituencyByUpz(this.value), loadUnionByUpazila(this.value);">
                                        <option value="">Select</option>
                                        <?php
                                            if(Session::get('district_id')){
                                            $param['table']  =  "upazilas";   
                                            $param['where']  =  [
                                                'district_id'   =>  Session::get('district_id')
                                            ];   
                                            $upazilas = get_table_data_by_clause($param);
                                            foreach($upazilas as $dis){
                                            ?>
                                        <option value="{{$dis->id}}"{{($dis->id == Session::get('upz_id')) ? 'selected' : ''}}>{{$dis->upazila_name}}</option>
                                            <?php }                                            
                                        } ?>
                                    </select>
                                </div>
<!--                                <label class="control-label col-sm-2" for="area">Area</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="area" name="area">
                                </div>    -->
                                <label class="control-label col-sm-2" for="area">Union</label>
                                <div class="col-sm-3">
                                    @if ($errors->has('union_id'))
                                        <div class="alert-error">{{ $errors->first('union_id') }}</div>
                                    @endif
                                    <select class="form-control" id="union_id" name="union_id" onchange="loadConstituencyByUnion(this.value), hideErrorDiv('union_id')">
                                        <option value="">Select Union</option>
                                        @php
                                        $unions    =   get_table_data_by_table('bd_unions');
                                        foreach($unions as $data){
                                        @endphp
                                        <option value="{{$data->id}}" {{($data->id == old('union_id') || Session::get('union_id')==$data->id) ? 'selected' : ''}}>{{$data->bd_union_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="ctycor">
                                    <input type="radio" name="location_type" id="location_type_city" value="2" onchange="disableOtherLocationInput(2);">Category
                                <span class="required_star">*</span></label>
                                
                                <div class="col-sm-3">
                                    @if ($errors->has('cat_id'))
                                        <div class="alert-error">{{ $errors->first('city_corp_id') }}</div>
                                    @endif
                                    <select class="form-control" id="cat_id" name="cat_id" onchange="loadCityCropByCat(this.value);">
                                        <option value="">Select</option>
                                        <option value="1">City corporation</option>
                                        <option value="2">Municipality</option>
                                    </select>
                                </div>   
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="ctycor"></label>                                
                                <div class="col-sm-3">
                                    @if ($errors->has('city_corp_id'))
                                        <div class="alert-error">{{ $errors->first('city_corp_id') }}</div>
                                    @endif
                                    <select disabled="disabled" class="form-control" id="city_corp_id" name="city_corp_id" onchange="loadWardByCityCrop(this.value);hideErrorDiv('city_corp_id')">
                                        <option value="">Select City corporation</option>
                                        @php
                                        $pcdivisions    =   get_table_data_by_table('citycorporations');
                                        foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}" {{($data->id == old('city_corp_id') || Session::get('city_corp_id')==$data->id) ? 'selected' : ''}}>{{$data->citycorp_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>
                                <label class="control-label col-sm-2" for="ward">Ward</label>
                                <div class="col-sm-3">
                                    <select disabled="disabled" class="form-control" id="ward_id" name="ward_id" onchange="loadConstituencyByWard(this.value);">
                                        <option value="">Select Ward</option>
                                        @php
                                        $pcdivisions    =   get_table_data_by_table('wards');
                                        foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}">{{$data->ward_nr}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">                                
                                <label class="control-label col-sm-3" for="road">Road</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="roadno" name="roadno">
                                </div>
                                <label class="control-label col-sm-3" for="ctycor">
                                    <input type="checkbox" name="csv_location" value="csv_location"> CSV Location
                                </label>                                
                                <div class="col-sm-3">
                                    <label class="radio-inline">
                                        <input type="radio" name="csv_type" value="upz">Upazila
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="csv_type" value="wards">Wards
                                    </label>
                                    <div class="custom_file" style="position: relative;right: 50%;padding-top: 4%;">
                                        <input type="file" class="form-control" id="project_docs" name="csvlocationfile">
                                        <span style="color: red; font-style: italic;">GIS object must need to be selected</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="constituency">Constituency</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="constituency" name="constituency" onchange="hideErrorDiv('gisobject_id')">
                                        <option value="">Constituency</option>
                                        @php
                                        $constituency    =   get_table_data_by_table('constituency');
                                        foreach($constituency as $data){
                                        @endphp
                                        <option value="{{$data->id}}" {{($data->id == old('constituency')) ? 'selected' : ''}}>
                                            <?php 
                                            echo $data->const_id.'('.$data->name.')';
                                            ?>
                                        </option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="gisobj">GIS object<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('gisobject_id'))
                                        <div class="alert-error">{{ $errors->first('gisobject_id') }}</div>
                                    @endif
                                    <select class="form-control" id="gisobject_id" name="gisobject_id" onchange="hideErrorDiv('gisobject_id')">
                                        <option value="">Select GIS object</option>
                                        @php
                                        $pcdivisions    =   get_table_data_by_table('gisobjects');
                                        foreach($pcdivisions as $data){
                                        @endphp
                                        <option value="{{$data->id}}" {{($data->id == old('gisobject_id')) ? 'selected' : ''}}>{{$data->gisobject_name}}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>   
                            </div>                            
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="lat">X</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="loc_x" name="loc_x" value="{{ old('loc_x',0) }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="long">Y</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="loc_y" name="loc_y" value="{{ old('loc_y',0) }}">
                                </div>    
                            </div>                            
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="ecost">Estimated cost</label>                                
                                <div class="col-sm-3">
                                    @if ($errors->has('estmcost'))
                                        <div class="alert-error">{{ $errors->first('estmcost') }}</div>
                                    @endif
                                    <input type="text" class="form-control" id="estmcost" name="estmcost" value="{{ old('estmcost',0) }}">(Lac taka)
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" id="pla_update_id" name="pla_update_id" value="">
                                    <input type="hidden" name="page_type" value="update">
                                    <input type="hidden" name="project_id" value="<?php echo Session::get('project_id'); ?>">
                                    <input type="submit" name="submit" value="Save" class="btn btn-success">
                                    <a href="{{ url($back.Session::get('project_id'))}}" class="btn btn-info"><< Back</a>
                                </div>
                            </div>
                        </form>
                        <?php
                        $param['table'] = "projectlocations";
                        $param['where'] = [
                            'project_id' => Session::get('project_id')
                        ];
                        $fas = get_table_data_by_clause($param);
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Union</th>
                                    <th>Constituency</th>
                                    <th>City corporation</th>
                                    <th>Ward</th>
                                    <th>Road</th>
                                    <th>GIS Object</th>
                                    <th>X</th>
                                    <th>Y</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>  
                                <?php
                                foreach ($fas as $ag) {
                                    ?>
                                    <tr id="data_entry_id_{{$ag->id}}">
                                        <td>#</td>
                                        <td>{{ (isset($ag->district_id)? getDivisionByDistrict($ag->district_id)->dvname    : getDivisionByCC($ag->city_corp_id)->dvname) }}</td>
                                        <td><?php echo (isset($ag->district_id)? get_data_name_by_id("districts", $ag->district_id)->district_name:"") ?></td>
                                        <td><?php echo (isset($ag->upz_id)? get_data_name_by_id("upazilas", $ag->upz_id)->upazila_name:"") ?></td>                                                    
                                        <td><?php echo (isset($ag->union_id)? get_data_name_by_id("bd_unions", $ag->union_id)->bd_union_name:"") ?></td>
                                        <td><?php echo (isset($ag->constituency)?$ag->constituency:"") ?></td>
                                        <td><?php echo (isset($ag->city_corp_id)? get_data_name_by_id("citycorporations", $ag->city_corp_id)->citycorp_name:"") ?></td>
                                        <td><?php echo (isset($ag->ward_id)? get_data_name_by_id("wards", $ag->ward_id)->ward_nr:"") ?></td>
                                        <td><?php echo (isset($ag->roadno) ? $ag->roadno:"") ?></td>
                                        <td><?php echo (isset($ag->gisobject_id) ?get_data_name_by_id("gisobjects", $ag->gisobject_id)->gisobject_name:"") ?></td>
                                        <td><?php echo (isset($ag->loc_x)? $ag->loc_x:"") ?></td>
                                        <td><?php echo (isset($ag->loc_y)? $ag->loc_y:"") ?></td>
                                        <td>
                                            <a href="#" onclick="onPageEditData({{$ag->id}}, 'projectlocations')" class="btn btn-xs btn-info">Edit</a>
                                            <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$ag->id}}, 'projectlocations');">Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
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
            if(upz_id){    
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
        
        function loadConstituencyByUnion(union_id){
            if(union_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadConstituencyByUnion")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"union_id="+union_id,
                        success     :function(response){
                            if(response.status == 'success'){
                                $('#constituency').val(response.data)
                            }
                        }
                    });
            }
        }
        
        function loadConstituencyByWard(ward_id){
            if(ward_id){    
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
                $("#union_id").prop('disabled', false);
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
                
                $("#union_id").val("");
                $("#union_id").prop('disabled', true);
                
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
    </script>
    <script>
        function loadCityCropByCat(cat_id){
            if(cat_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadCityCropByCat")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"cat_id="+cat_id,
                        success     :function(response){
                            $("#city_corp_id").html(response);
                        }
                    });
            }
        }
        function loadWardByCityCrop(city_crop_id){
            if(city_crop_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadWardByCityCrop")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"citycorp_id="+city_crop_id,
                        success     :function(response){
                            $("#ward_id").html(response);
                        }
                    });
            }
        }
    </script>
@endsection
@endsection