<?php
    $project_id     =   Session::get('project_id');
    $param['table']     = "projects";
    $param['where']     = [
        'id'    => Session::get('project_id')
    ];
    $pdata              =   get_table_data_by_clause($param);
    $project_data       =   $pdata[0];
    
    $param  =   [];
    $param['table']     = "projectagencies";
    $param['where']     = [
        'project_id'             => Session::get('project_id'),
        'lead_agency'    => 1
    ];
    $agdata              =   get_table_data_by_clause($param);
    $project_agency_data  = $agdata[0];
?>
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
    <label class="control-label col-sm-3" for="prjname1">Ministry/ Division</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="prjname1" value="<?php echo get_data_name_by_id("ministries", $project_agency_data->ministry_id)->ministry_name; ?>" readonly>
    </div>    
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="prjname1">Lead Agency</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="prjname1" value="<?php echo get_data_name_by_id("agencies", $project_agency_data->agency_id)->agency_name; ?>" readonly>
    </div>    
</div>