<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>Update</small>
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
                        $project_id         =   Session::get('project_id');
                        $param['table']     =   "projects";
                        $param['where']     = [
                            'id'    => Session::get('project_id')
                        ];
                        $pdata              =   get_table_data_by_clause($param);
                        $project_data       =   $pdata[0];
                        
                        $param  =   [];
                        
                        $param['table'] = "project_details";
                        $param['where'] = [
                            'project_id' => Session::get('project_id')
                        ];
                        $responseData = get_table_data_by_clause($param);
                        if (isset($responseData[0]) && !empty($responseData[0])) {
                            $project_details = $responseData[0];
                        }
                        ?>
                        <form class="form-horizontal" action="{{ url('admin/project/project_details_store') }}" method="post">
                            {{csrf_field()}}
                            @include("backend.pertial.project_entry_form_fixed_part")
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="obj">Objectives<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('objectives'))
                                        <div class="alert-error">{{ $errors->first('objectives') }}</div>
                                    @endif
                                    <textarea class="form-control" rows="3" id="objectives" name="objectives" onkeyup="hideErrorDiv('objectives')"><?php
                                    if (isset($project_details->objectives) && !empty($project_details->objectives)) {
                                        echo $project_details->objectives;
                                    }
                                    ?></textarea>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="obj">Objectives (Bangla)</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="3" id="objectives_bng" name="objectives_bng"><?php
                                    if (isset($project_details->objectives_bng) && !empty($project_details->objectives_bng)) {
                                        echo $project_details->objectives_bng;
                                    }
                                    ?></textarea>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="bckgrnd">Backgrounds</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="3" id="backgrounds" name="backgrounds"><?php
                                    if (isset($project_details->backgrounds) && !empty($project_details->backgrounds)) {
                                        echo $project_details->backgrounds;
                                    }
                                    ?></textarea>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="obj">Backgrounds (Bangla)</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="3" id="backgrounds_bng" name="backgrounds_bng"><?php
                                    if (isset($project_details->backgrounds_bng) && !empty($project_details->backgrounds_bng)) {
                                        echo $project_details->backgrounds_bng;
                                    }
                                    ?></textarea>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="mainact">Main activities</label>
                                <div class="col-sm-8">                                    
                                    <textarea class="form-control" rows="3" id="activities" name="activities"><?php
                                    if (isset($project_details->activities) && !empty($project_details->activities)) {
                                        echo $project_details->activities;
                                    }
                                    ?></textarea>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="mainact">Main activities (Bangla)</label>
                                <div class="col-sm-8">                                    
                                    <textarea class="form-control" rows="3" id="activities_bng" name="activities_bng"><?php
                                    if (isset($project_details->activities_bng) && !empty($project_details->activities_bng)) {
                                        echo $project_details->activities_bng;
                                    }
                                    ?></textarea>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="mainact">Number Of beneficiaries</label>
                                <div class="col-sm-2">
                                    @if ($errors->has('bnf_male'))
                                        <div class="alert-error">{{ $errors->first('bnf_male') }}</div>
                                    @endif
                                    Male<input type="text" class="form-control" id="bnf_male" name="bnf_male" value="<?php
                                    if (isset($project_details->bnf_male) && !empty($project_details->bnf_male)) {
                                        echo $project_details->bnf_male;
                                    }else{ echo "0"; }
                                    ?>" onkeyup="calculateGrandTotal();">
                                </div>   
                                <div class="col-sm-2">
                                    @if ($errors->has('bnf_female'))
                                        <div class="alert-error">{{ $errors->first('bnf_female') }}</div>
                                    @endif
                                    Female<input type="text" class="form-control" id="bnf_female" name="bnf_female" value="<?php
                                    if (isset($project_details->bnf_female) && !empty($project_details->bnf_female)) {
                                        echo $project_details->bnf_female;
                                    }else{ echo "0"; }
                                    ?>" onkeyup="calculateGrandTotal();">
                                </div>
                                <div class="col-sm-2">
                                    @if ($errors->has('bnf_total'))
                                        <div class="alert-error">{{ $errors->first('bnf_total') }}</div>
                                    @endif
                                    Total<input type="text" class="form-control" id="bnf_total" name="bnf_total" value="<?php
                                    if (isset($project_details->bnf_total) && !empty($project_details->bnf_total)) {
                                        echo $project_details->bnf_total;
                                    }else{ echo "0"; }
                                    ?>" onkeyup="calculateGrandTotal(true);">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="project_id" value="<?php echo Session::get('project_id'); ?>">
                                    <input type="hidden" name="page_type" value="update">
                                    <input type="submit" name="submit" value="{{ (isset($project_details)? "Save":"Save")}}" class="btn btn-success">
                                    <a href="{{ url($back.$project_id)}}" class="btn btn-info"><< Back</a>
                                </div>
                            </div>
                        </form>
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
    function calculateGrandTotal(bnf_total = false){
        if(bnf_total){
           $("#bnf_male").val(0); 
           $("#bnf_female").val(0); 
        }else{
            var bnf_male        =   (($("#bnf_male").val())? parseFloat($("#bnf_male").val()):0);
            var bnf_female      =   (($("#bnf_female").val())? parseFloat($("#bnf_female").val()):0)
            var grandTotal      =   parseInt((bnf_male+bnf_female));
            parseInt($("#bnf_total").val(grandTotal));
        }
    }
</script>
@endsection
@endsection