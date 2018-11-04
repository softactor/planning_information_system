<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>{{ $list_title }} List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashbord')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url($list_url) }}">{{ $list_title }}</a></li>
            <li class="active">{{ $list_title }} View</li>
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
                        <div id="wizard">
                            <h2>Project</h2>
                            <section>
                                <div style="float: lefft;height: auto; margin-bottom: 10px; width: 100%;">
                                    <form class="form-horizontal" action="{{url('admin/project/new_project_store')}}" method="post">
                                    <!--to protect csrf-->
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="date">Dateb<span class="required_star">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="project_entry_date" name="project_entry_date" value="{{$project_data->project_entry_date}}">
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="prptyp">Proposal type<span class="required_star">*</span></label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="proposal_type_id" name="proposal_type_id">
                                                <option>Select proposal type</option>
                                                <?php
                                                $param['table'] = "commonconfs";
                                                $param['where'] = [
                                                    'commonconf_type' => 1
                                                ];
                                                $proposal = get_table_data_by_clause($param);
                                                foreach ($proposal as $type) {
                                                    ?>
                                                    <option value="<?php echo $type->id ?>" <?php if ($project_data->proposal_type_id == $type->id) {
                                                    echo "selected";
                                                } ?>><?php echo $type->commonconf_name ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="prjname">Project name (English)<span class="required_star">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="project_name_eng" name="project_name_eng" value="{{ $project_data->project_name_eng }}">
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="project_name_bng" name="project_name_bng" value="{{ $project_data->project_name_bng }}">
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="short">Short name<span class="required_star">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="project_short_name" name="project_short_name" value="{{ $project_data->project_short_name }}">
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="pcdiv">Division of Bangladesh Planning Commission<span class="required_star">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="pcdivision_id" name="pcdivision_id">
                                                <option value="">Select PC Division</option>
                                                <?php
                                                $result = get_table_data_by_table('pcdivisions');
                                                foreach ($result as $data) {
                                                    ?>
                                                    <option value="<?php echo $data->id ?>"<?php if(isset($project_data->pcdivision_id) && $project_data->pcdivision_id==$data->id){ echo "selected"; } ?>><?php echo $data->pcdivision_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="wing">Wing<span class="required_star">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="wing_id" name="wing_id">
                                                <option value="">Select Wing</option>
                                                <?php
                                                $result = get_table_data_by_table('wings');
                                                foreach ($result as $data) {
                                                    ?>
                                                    <option value="<?php echo $data->id ?>"<?php if(isset($project_data->wing_id) && $project_data->wing_id==$data->id){ echo "selected"; } ?>><?php echo $data->wing_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="ministry">Ministry/Division<span class="required_star">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="ministry_id" name="ministry_id">
                                                <option>Select Ministry</option>
                                                <?php
                                                $result = get_table_data_by_table('ministries');
                                                foreach ($result as $data) {
                                                    ?>
                                                    <option value="<?php echo $data->id ?>"<?php if(isset($project_agency_data->ministry_id) && $project_agency_data->ministry_id==$data->id){ echo "selected"; } ?>><?php echo $data->ministry_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="agencyl">Lead Agency<span class="required_star">*</span></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="agency_id" name="agency_id">
                                                <option>Select Agency(Lead)</option>
                                                <?php
                                                $result = get_table_data_by_table('agencies');
                                                foreach ($result as $data) {
                                                    ?>
                                                    <option value="<?php echo $data->id ?>"<?php if(isset($project_agency_data->agency_id) && $project_agency_data->agency_id==$data->id){ echo "selected"; } ?>><?php echo $data->agency_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="adpsector">ADP Sub-sector</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="subsector_id" name="subsector_id">
                                                <option>Select ADP Sub-Sector</option>
                                                <?php
                                                $result = get_table_data_by_table('subsectors');
                                                foreach ($result as $data) {
                                                    ?>
                                                    <option value="<?php echo $data->id ?>"<?php if(isset($project_data->subsector_id) && $project_data->subsector_id==$data->id){ echo "selected"; } ?>><?php echo $data->subsector_name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="keyw">Keyword</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="search_keyword" name="search_keyword" value="{{ $project_data->search_keyword }}">
                                        </div>    
                                    </div>                                    
                                </form>
                                </div>
                            </section>

                            <h2>Agency Information</h2>
                            <section>
                                <div style="float: lefft;height: auto; margin-bottom: 10px; width: 100%;">
                                        <form class="form-horizontal" action="{{ url('admin/project/project_agency_store') }}" method="post">
                                            {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjctcode">Project code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjctcode" value="{{$project_data->project_app_code}}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname">Project name (English)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname" value="{{ $project_data->project_name_eng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname1" value="{{ $project_data->project_name_bng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="agency">Agency<span class="required_star">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="agency_id" name="agency_id">
                                                    <option>Select Agency</option>
                                                    <?php
                                                    $result = get_table_data_by_table('agencies');
                                                    foreach ($result as $data) {
                                                        ?>
                                                        <option value="<?php echo $data->id ?>"><?php echo $data->agency_name ?></option>
                                                <?php } ?>
                                                </select>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="page">Lead Agency</label>
                                            <div class="col-sm-8">
                                                <div class="checkbox">
                                                    <label style="margin-left:15px"><input type="checkbox" value=""></label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </form>
                                    <?php
                                        $param['table'] =   "projectagencies";
                                        $param['where'] =   [
                                            'project_id'    =>  $project_agency_data->project_id
                                        ];
                                        $agencies   =   get_table_data_by_clause($param);

                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Lead Agency</th>
                                            </tr>
                                        </thead>
                                        <tbody>  
                                            <?php
                                                foreach($agencies as $ag){
                                            ?>
                                            <tr>
                                                <td>#</td>
                                                <td><?php echo get_data_name_by_id("agencies",$ag->agency_id)->agency_name; ?></td>
                                                <td><?php echo (($ag->lead_agency==1) ? "Yes":"No"); ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                            <h2>Detail Information</h2>
                            <section>
                                <?php
                                    $param['table'] =   "project_details";
                                    $param['where'] =   [
                                        'project_id'    =>  $project_agency_data->project_id
                                    ];
                                    $responseData       =   get_table_data_by_clause($param);
                                    if(isset($responseData[0]) && !empty($responseData[0])){
                                        $project_details    =   $responseData[0];
                                    }
                                ?>
                                <div style="float: lefft;height: auto; margin-bottom: 10px; width: 100%;">
                                    <form class="form-horizontal" action="{{ url('admin/project/project_details_store') }}" method="post">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjctcode">Project code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjctcode" value="{{$project_data->project_app_code}}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname">Project name (English)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname" value="{{ $project_data->project_name_eng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname1" value="{{ $project_data->project_name_bng }}" readonly>
                                            </div>    
                                        </div>                                        
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="obj">Objectives<span class="required_star">*</span></label>
                                            <div class="col-sm-8">
                                                @if ($errors->has('objectives'))
                                                <div class="alert-error">{{ $errors->first('objectives') }}</div>
                                                @endif
                                                <textarea class="form-control" rows="10" id="objectives" name="objectives"><?php
                                                    if (isset($project_details->objectives) && !empty($project_details->objectives)) {
                                                        echo $project_details->objectives;
                                                    }
                                                    ?></textarea>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="bckgrnd">Backgrounds</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="10" id="backgrounds" name="backgrounds"><?php
                                                    if (isset($project_details->backgrounds) && !empty($project_details->backgrounds)) {
                                                        echo $project_details->backgrounds;
                                                    }
                                                    ?></textarea>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="mainact">Main activities</label>
                                            <div class="col-sm-8">                                    
                                                <textarea class="form-control" rows="10" id="activities" name="activities"><?php
                                                    if (isset($project_details->activities) && !empty($project_details->activities)) {
                                                        echo $project_details->activities;
                                                    }
                                                    ?></textarea>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="mainact">Number of benificiaries</label>
                                            <div class="col-sm-2">
                                                Male<input type="text" class="form-control" id="bnf_male" name="bnf_male" value="<?php
                                                if (isset($project_details->bnf_male) && !empty($project_details->bnf_male)) {
                                                    echo $project_details->bnf_male;
                                                } else {
                                                    echo "0";
                                                }
                                                ?>" onkeyup="calculateGrandTotal();">
                                            </div>   
                                            <div class="col-sm-2">
                                                Female<input type="text" class="form-control" id="bnf_female" name="bnf_female" value="<?php
                                                if (isset($project_details->bnf_female) && !empty($project_details->bnf_female)) {
                                                    echo $project_details->bnf_female;
                                                } else {
                                                    echo "0";
                                                }
                                                ?>" onkeyup="calculateGrandTotal();">
                                            </div>
                                            <div class="col-sm-2">
                                                Total<input type="text" class="form-control" id="bnf_total" name="bnf_total" value="<?php
                                        if (isset($project_details->bnf_total) && !empty($project_details->bnf_total)) {
                                            echo $project_details->bnf_total;
                                        } else {
                                            echo "0";
                                        }
                                        ?>">
                                            </div>
                                        </div>                                        
                                    </form>
                                </div>
                            </section>

                            <h2>Foreign Assistance Information</h2>
                            <section>
                                <div style="float: lefft;height: auto; margin-bottom: 10px; width: 100%;">
                                    <form class="form-horizontal" action="{{ url('admin/project/project_fas_store') }}" method="post">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjctcode">Project code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjctcode" value="{{$project_data->project_app_code}}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname">Project name (English)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname" value="{{ $project_data->project_name_eng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname1" value="{{ $project_data->project_name_bng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="cntry">Country<span class="required_star">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="fa_country" name="fa_country">
                                                    <option>Select Country</option>
                                                    <?php
                                                    $param['table'] = "commonconfs";
                                                    $param['where'] = [
                                                        'commonconf_type' => 4
                                                    ];
                                                    $proposal = get_table_data_by_clause($param);
                                                    foreach ($proposal as $type) {
                                                        ?>
                                                        <option value="<?php echo $type->id ?>"><?php echo $type->commonconf_name ?></option>
                                                    <?php } ?>
                                                </select>                                                
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="doner">Donor<span class="required_star">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="fa_donor" name="fa_donor">
                                                    <option>Select Donor</option>
                                                    <?php
                                                    $param['table'] = "commonconfs";
                                                    $param['where'] = [
                                                        'commonconf_type' => 5
                                                    ];
                                                    $proposal = get_table_data_by_clause($param);
                                                    foreach ($proposal as $type) {
                                                        ?>
                                                        <option value="<?php echo $type->id ?>"><?php echo $type->commonconf_name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="modefi">Mode of finance<span class="required_star">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="fa_mof" name="fa_mof">
                                                    <option>Select Mode of Finance</option>
                                                    <?php
                                                    $param['table'] = "commonconfs";
                                                    $param['where'] = [
                                                        'commonconf_type' => 6
                                                    ];
                                                    $proposal = get_table_data_by_clause($param);
                                                    foreach ($proposal as $type) {
                                                        ?>
                                                        <option value="<?php echo $type->id ?>"><?php echo $type->commonconf_name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="amount">Amount<span class="required_star">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" id="fa_amount" name="fa_amount">(Lac Taka)
                                            </div>    
                                        </div>
                                        
                                    </form>
                                    <?php
                                    $param['table'] = "project_fas";
                                    $param['where'] = [
                                        'project_id' => $project_agency_data->project_id
                                    ];
                                    $fas = get_table_data_by_clause($param);
                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Country</th>
                                                <th>Donor</th>
                                                <th>Mode Of Finance</th>
                                                <th>Amount (Lac Taka)</th>
                                            </tr>
                                        </thead>
                                        <tbody>  
                                            <?php
                                            foreach ($fas as $ag) {
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo get_data_name_by_id("commonconfs",$ag->fa_country)->commonconf_name; ?></td>
                                                    <td><?php echo get_data_name_by_id("commonconfs",$ag->fa_donor)->commonconf_name; ?></td>
                                                    <td><?php echo get_data_name_by_id("commonconfs",$ag->fa_mof)->commonconf_name; ?></td>
                                                    <td><?php echo $ag->fa_amount; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            
                            <h2>Location Information</h2>
                            <section>
                                <div style="float: lefft;height: auto; margin-bottom: 10px; width: 100%;">
                                    <form class="form-horizontal" action="{{ url('admin/project/project_location_store') }}" method="post">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjctcode">Project code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjctcode" value="{{$project_data->project_app_code}}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname">Project name (English)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname" value="{{ $project_data->project_name_eng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname1" value="{{ $project_data->project_name_bng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="loctyp">Location type,</label>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="div">Division</label>
                                            <div class="col-sm-3">
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
                                            <label class="control-label col-sm-2" for="dis">District</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="district_id" name="district_id" onchange="loadUpozila(this.value);">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="upz">Upazila</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="upz_id" name='upz_id'>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                            <label class="control-label col-sm-2" for="area">Area</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="area" name="area">
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="ctycor">City Corporation</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="city_corp_id" name="city_corp_id">
                                                    <option>Select City Corporation</option>
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
                                            <label class="control-label col-sm-2" for="ward">Ward</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="ward_id" name="ward_id">
                                                    <option>Select Ward</option>
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
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="gisobj">GIS object<span class="required_star">*</span></label>
                                            <div class="col-sm-3">
                                                <select class="form-control" id="gisobject_id" name="gisobject_id">
                                                    <option>Select GIS Object</option>
                                                    @php
                                                    $pcdivisions    =   get_table_data_by_table('gisobjects');
                                                    foreach($pcdivisions as $data){
                                                    @endphp
                                                    <option value="{{$data->id}}">{{$data->gisobject_name}}</option>
                                                    @php
                                                    }
                                                    @endphp
                                                </select>
                                            </div>   
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="lat">X</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="loc_x" name="loc_x">
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="long">Y</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="loc_y" name="loc_y">
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="ecost">Estimated cost</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="estmcost" name="estmcost">(Lac taka)
                                            </div>    
                                        </div>
                                        
                                    </form>
                                    <?php
                                    $param['table'] = "projectlocations";
                                    $param['where'] = [
                                        'project_id' => $project_agency_data->project_id
                                    ];
                                    $fas = get_table_data_by_clause($param);
                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>District</th>
                                                <th>Upazila</th>
                                                <th>Area</th>
                                                <th>City corporation</th>
                                                <th>Ward</th>
                                                <th>Road</th>
                                                <th>GIS object</th>
                                                <th>Latitude</th>
                                                <th>Longitude</th>
                                            </tr>
                                        </thead>
                                        <tbody>  
                                            <?php
                                            foreach ($fas as $ag) {
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo (isset($ag->district_id)? get_data_name_by_id("districts", $ag->district_id)->district_name:"") ?></td>
                                                    <td><?php echo (isset($ag->upz_id)? get_data_name_by_id("upazilas", $ag->upz_id)->upazila_name:"") ?></td>                                                    
                                                    <td><?php echo (isset($ag->area)?$ag->area:"") ?></td>
                                                    <td><?php echo (isset($ag->city_corp_id)? get_data_name_by_id("citycorporations", $ag->city_corp_id)->citycorp_name:"") ?></td>
                                                    <td><?php echo (isset($ag->ward_id)? get_data_name_by_id("wards", $ag->ward_id)->ward_nr:"") ?></td>
                                                    <td><?php echo (isset($ag->roadno) ? $ag->roadno:"") ?></td>
                                                    <td><?php echo (isset($ag->gisobject_id) ?get_data_name_by_id("gisobjects", $ag->gisobject_id)->gisobject_name:"") ?></td>
                                                    <td><?php echo (isset($ag->loc_x)? $ag->loc_x:"") ?></td>
                                                    <td><?php echo (isset($ag->loc_y)? $ag->loc_y:"") ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            
                            <h2>Expenditure Information</h2>
                            <section>
                                <?php
                                    $param['table'] = "projectcosts";
                                    $param['where'] = [
                                        'project_id' => $project_agency_data->project_id
                                    ];
                                    $fas = get_table_data_by_clause($param);
                                    $projectCost    =   ((isset($fas[0]) ? $fas[0]:""));
                                    
                                    ?>
                                <div style="float: lefft;height: auto; margin-bottom: 10px; width: 100%;">
                                    <form class="form-horizontal" action="{{ url('admin/project/project_expenditure_store') }}" method="post">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjctcode">Project code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjctcode" value="{{$project_data->project_app_code}}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname">Project name (English)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname" value="{{ $project_data->project_name_eng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname1" value="{{ $project_data->project_name_bng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjvtype">Project version type</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjvtype" value="New">
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="loctyp">Implementation period<span class="required_star">*</span></label>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="implstartdate">Start</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="implstartdate" name="implstartdate" value="{{ (isset($projectCost->implstartdate)? $projectCost->implstartdate:"")}}">
                                            </div>    
                                            <label class="control-label col-sm-2" for="implenddate">End</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="implenddate" name="implenddate" value="{{ (isset($projectCost->implenddate)? $projectCost->implenddate:"")}}">
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="loctyp">Expenditure (Lac Taka)</label>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="rev">Revenue</label>
                                            <label class="control-label col-sm-2" for="cap">Capital</label>
                                            <label class="control-label col-sm-2" for="con">Contingency</label>
                                            <label class="control-label col-sm-2" for="grnd">Grand Total</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="gob">GOB</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="gob_rev" name="gob[rev]" onkeyup="calculateGrandTotal('gob');" value="{{ (isset($projectCost->expgobrev)? $projectCost->expgobrev:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="gob_cap" name="gob[cap]" onkeyup="calculateGrandTotal('gob');" value="{{ (isset($projectCost->expgobcap)? $projectCost->expgobcap:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="gob_con" name="gob[con]" onkeyup="calculateGrandTotal('gob');" value="{{ (isset($projectCost->expgobcont)? $projectCost->expgobcont:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="gob_grand" name="gob[grand]" onkeyup="calculateGrandTotal('gob');" value="{{ (isset($projectCost->gob_gt)? $projectCost->gob_gt:0)}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="pa">PA(RPA + DPA)</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="pa_rev" name="pa[rev]" onkeyup="calculateGrandTotal('pa');" value="{{ (isset($projectCost->expparev)? $projectCost->expparev:0)}}">
                                            </div> 
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="pa_cap" name="pa[cap]" onkeyup="calculateGrandTotal('pa');" value="{{ (isset($projectCost->exppacap)? $projectCost->exppacap:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="pa_con" name="pa[con]" onkeyup="calculateGrandTotal('pa');" value="{{ (isset($projectCost->exppacont)? $projectCost->exppacont:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="pa_grand" name="pa[grand]" onkeyup="calculateGrandTotal('pa');" onload="calculateGrandTotal('pa');" value="{{ (isset($projectCost->pa_gt)? $projectCost->pa_gt:0)}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="own">Own Fund</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="own_rev" name="own[rev]" onkeyup="calculateGrandTotal('own');" value="{{ (isset($projectCost->expofundrev)? $projectCost->expofundrev:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="own_cap" name="own[cap]" onkeyup="calculateGrandTotal('own');" value="{{ (isset($projectCost->expofundcap)? $projectCost->expofundcap:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="own_con" name="own[con]" onkeyup="calculateGrandTotal('own');" value="{{ (isset($projectCost->expofundcont)? $projectCost->expofundcont:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="own_grand" name="own[grand]" onkeyup="calculateGrandTotal('own');" value="{{ (isset($projectCost->own_gt)? $projectCost->own_gt:0)}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="others">Others</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="others_rev" name="others[rev]" onkeyup="calculateGrandTotal('others');" value="{{ (isset($projectCost->expothersrev)? $projectCost->expothersrev:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="others_cap" name="others[cap]" onkeyup="calculateGrandTotal('others');" value="{{ (isset($projectCost->expotherscap)? $projectCost->expotherscap:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="others_con" name="others[con]" onkeyup="calculateGrandTotal('others');" value="{{ (isset($projectCost->expotherscont)? $projectCost->expotherscont:0)}}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="others_grand" name="others[grand]" onkeyup="calculateGrandTotal('others');" value="{{ (isset($projectCost->oth_gt)? $projectCost->oth_gt:0)}}">
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            </section>
                            
                            <h2>Document Information</h2>
                            <section>
                                <div style="float: lefft;height: auto; margin-bottom: 10px; width: 100%;">
                                    <form class="form-horizontal" action="{{ url('admin/project/project_documents_store') }}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjctcode">Project code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjctcode" value="{{$project_data->project_app_code}}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname">Project name (English)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname" value="{{ $project_data->project_name_eng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname1" value="{{ $project_data->project_name_bng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="doc">Document<span class="required_star">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="file" class="form-control" id="project_docs" name="project_docs">
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="doctyp">Type of document<span class="required_star">*</span></label>
                                            <div class="col-sm-8">
                                                <?php
                                                    $param['table'] = "commonconfs";
                                                    $param['where'] = [
                                                        'commonconf_type' => 1
                                                    ];
                                                    $responseData = get_table_data_by_clause($param);
                                                ?>
                                                <select class="form-control" id="doctype" name="doctype">
                                                    <option value="">Select Type of Document</option>
                                                    <?php foreach($responseData as $data){ ?>
                                                    <option value="<?php echo $data->id; ?>"><?php echo $data->commonconf_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname1">Remarks</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="remarks" name="remarks" value="">
                                            </div>    
                                        </div>
                                        
                                    </form>
                                    <?php
                                    $param['table'] = "projectdocuments";
                                    $param['where'] = [
                                        'project_id' => $project_agency_data->project_id
                                    ];
                                    $fas = get_table_data_by_clause($param);
                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Documents</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>  
                                            <?php
                                            foreach ($fas as $ag) {
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo $ag->docname; ?></td>
                                                    <td><?php echo get_data_name_by_id("commonconfs",$ag->doctype)->commonconf_name; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            
                            <h2>Upload Shape File</h2>
                            <section>
                                <div style="float: lefft;height: auto; margin-bottom: 10px; width: 100%;">
                                    <form class="form-horizontal" action="{{ url('admin/project/project_shapefils_store') }}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjctcode">Project code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjctcode" value="{{$project_data->project_app_code}}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname">Project name (English)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname" value="{{ $project_data->project_name_eng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="prjname1" value="{{ $project_data->project_name_bng }}" readonly>
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="doc">Document<span class="required_star">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="file" class="form-control" id="project_docs" name="project_docs">
                                            </div>    
                                        </div>
                                        
                                    </form>
                                    <?php
                                    $param['table'] = "projectshapefiles";
                                    $param['where'] = [
                                        'project_id' => $project_agency_data->project_id
                                    ];
                                    $psf = get_table_data_by_clause($param);
                                    if(isset($psf) && !empty($psf)){
                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Project name</th>
                                                <th>Short name</th>
                                                <th>Documents</th>
                                            </tr>
                                        </thead>
                                        <tbody>  
                                            <?php
                                            foreach ($psf as $ag) {
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo $project_data->project_name_eng; ?></td>
                                                    <td><?php echo $project_data->project_short_name; ?></td>
                                                    <td><a href="#"><?php echo $ag->docname; ?></a></td>
                                                </tr>
                                    <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                                </div>
                            </section>
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
        <script type="text/javascript">
            function calculateGrandTotal(id){
                var selector        =   id+"_";
                var Revenue         =   parseFloat($("#"+selector+"rev").val());
                var Capital         =   parseFloat($("#"+selector+"cap").val());
                var Contingency     =   parseFloat($("#"+selector+"con").val());
                var grandTotal      =   parseFloat((Revenue+Capital+Contingency));
                parseFloat($("#"+selector+"grand").val(grandTotal));
            }
            $(function (){
                $("#wizard").steps({
                    enableAllSteps  : true,
                    headerTag       : "h2",
                    bodyTag         : "section",
                    transitionEffect: "slideLeft",
                    cssClass: "wizard",
                    stepsOrientation: "vertical"
                });
            });
        </script>
        <script type="text/javascript">
            $( function() {
              $( "#project_entry_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
            });
      </script>
      <script type="text/javascript">
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
        </script>
    @endsection
@endsection