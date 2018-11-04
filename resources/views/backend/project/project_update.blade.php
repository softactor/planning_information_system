<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>{{ $list_title }} Create</small>
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
                            @include('backend/project/project_new_entry/next_step_project_enty_decision')
                    </div>
                    <!-- /.box-header -->
                    @if (!$success_message = Session::get('next_success'))
                    <div class="box-body">
                        <form class="form-horizontal" action="{{url('admin/project/new_project_store')}}" method="post">
                            <!--to protect csrf-->
                            {{csrf_field()}}
                            @include("backend.pertial.project_entry_form_fixed_part")
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pcdiv">PC Division<span class="required_star">*</span></label>
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
                                <label class="control-label col-sm-3" for="ministry">Ministry<span class="required_star">*</span></label>
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
                                <label class="control-label col-sm-3" for="agencyl">Agency(Lead)<span class="required_star">*</span></label>
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
                                <label class="control-label col-sm-3" for="adpsector">ADP Sub-Sector</label>
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
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <a href="{{ url($list_url)}}" class="btn btn-info">Menu</a>
                                    <button type="button" class="btn btn-info" onclick="nextPageConfirmation('{{ url("admin/project/project_agency_create") }}', 'Do you want to add Agency Information (Yes/ No)?');">Agency Information</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
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
      $( function() {
        $( "#project_entry_date" ).datepicker();
      });
</script>
@endsection
@endsection