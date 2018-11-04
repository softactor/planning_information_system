<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>{{ $list_title }} Final Save</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashbord')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url($list_url) }}">{{ $list_title }}</a></li>
            <li class="active">{{ $list_title }} Final Save</li>
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
                        <form class="form-horizontal" id="project_final_save" action="{{ url('/admin/project/project_final_save') }}" method="post">
                            <!--to protect csrf-->
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="date">Date<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('project_entry_date'))
                                        <div class="alert-error">{{ $errors->first('project_entry_date') }}</div>
                                    @endif
                                    <input type="text"  autocomplete="off" class="form-control" id="project_entry_date" name="project_entry_date" value="{{ $project_data->project_entry_date }}" onchange="hideErrorDiv('project_entry_date')">
                                </div>    
                                <!-- </div>
                                 <div class="form-group">-->
                                <label class="control-label col-sm-2" for="prptyp">Proposal type<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('proposal_type_id'))
                                        <div class="alert-error">{{ $errors->first('proposal_type_id') }}</div>
                                    @endif
                                    <select class="form-control" id="proposal_type_id" name="proposal_type_id" onchange="hideErrorDiv('proposal_type_id')">
                                        <option value="">Select proposal type</option>
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
                                    @if ($errors->has('project_name_eng'))
                                        <div class="alert-error">{{ $errors->first('project_name_eng') }}</div>
                                    @endif
                                    <input type="text" class="form-control" id="project_name_eng" name="project_name_eng" value="{{ $project_data->project_name_eng }}" onkeyup="hideErrorDiv('project_name_eng')">
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
                                    @if ($errors->has('project_short_name'))
                                        <div class="alert-error">{{ $errors->first('project_short_name') }}</div>
                                    @endif
                                    <input type="text" class="form-control" id="project_short_name" name="project_short_name" value="{{ $project_data->project_short_name }}" onkeyup="hideErrorDiv('project_short_name')">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pcdiv">Division of Bangladesh Planning Commission<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('pcdivision_id'))
                                        <div class="alert-error">{{ $errors->first('pcdivision_id') }}</div>
                                    @endif
                                    <select class="form-control" id="pcdivision_id" name="pcdivision_id" onchange="hideErrorDiv('pcdivision_id')">
                                        <option value="">Select PC Division</option>
                                        <?php
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "pcdivision_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('pcdivisions',$order_by);
                                        foreach ($result as $data) {
                                            ?>
                                            <option value="<?php echo $data->id ?>"<?php if (isset($project_data->pcdivision_id) && $project_data->pcdivision_id == $data->id) {
                                            echo "selected";
                                        } ?>><?php echo $data->pcdivision_name ?></option>
<?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="wing">Wing<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('wing_id'))
                                        <div class="alert-error">{{ $errors->first('wing_id') }}</div>
                                    @endif
                                    <select class="form-control" id="wing_id" name="wing_id" onchange="hideErrorDiv('wing_id')">
                                        <option value="">Select Wing</option>
                                        <?php
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "wing_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('wings',$order_by);
                                        foreach ($result as $data) {
                                            ?>
                                            <option value="<?php echo $data->id ?>"<?php if (isset($project_data->wing_id) && $project_data->wing_id == $data->id) {
                                                echo "selected";
                                            } ?>><?php echo $data->wing_name ?></option>
<?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="ministry">Ministry/ Division<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('ministry_id'))
                                        <div class="alert-error">{{ $errors->first('ministry_id') }}</div>
                                    @endif
                                    <select class="form-control" id="ministry_id" name="ministry_id" onchange="hideErrorDiv('ministry_id'), loadAgencyByMinstry(this.value)">
                                        <option>Select Ministry</option>
                                        <?php
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "ministry_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('ministries',$order_by);
                                        foreach ($result as $data) {
                                            ?>
                                            <option value="<?php echo $data->id ?>"<?php if (isset($project_agency_data->ministry_id) && $project_agency_data->ministry_id == $data->id) {
        echo "selected";
    } ?>><?php echo $data->ministry_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="agencyl">Lead Agency<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('agency_id'))
                                        <div class="alert-error">{{ $errors->first('agency_id') }}</div>
                                    @endif
                                    <select class="form-control" id="agency_id" name="agency_id" onchange="hideErrorDiv('agency_id')">
                                        <option>Select Agency(Lead)</option>
                                        <?php
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "agency_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('agencies',$order_by);
                                        foreach ($result as $data) {
                                            ?>
                                            <option value="<?php echo $data->id ?>"<?php if (isset($project_agency_data->agency_id) && $project_agency_data->agency_id == $data->id) {
        echo "selected";
    } ?>><?php echo $data->agency_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="adpsector">ADP Sub-sector<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('subsector_id'))
                                        <div class="alert-error">{{ $errors->first('subsector_id') }}</div>
                                    @endif
                                    <select class="form-control" id="subsector_id" name="subsector_id" onchange="hideErrorDiv('subsector_id')">
                                        <option value="">Select ADP Sub-Sector</option>
                                        <?php
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "subsector_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('subsectors',$order_by);
                                        foreach ($result as $data) {
                                            ?>
                                            <option value="<?php echo $data->id ?>"<?php if (isset($project_data->subsector_id) && $project_data->subsector_id == $data->id) {
        echo "selected";
    } ?>><?php echo $data->subsector_name ?></option>
                    <?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="keyw">Keyword<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="search_keyword" name="search_keyword" value="{{ $project_data->search_keyword }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="project_edit_id" value="{{$project_data->id}}">
                                    <button type="button" class="btn btn-success" onclick="projectFinalSaveAction('project_final_save');">Final Save</button>
                                    <a href="{{ url('admin/project/temporary_project')}}" class="btn btn-info">Menu</a>
                                </div>
                            </div>
                        </form>
                        <div class="pull-right project_link_information">
                            <ul>
                                <li><a href="#" data-toggle="modal" data-target="#viewProjectProfile"><span class="fa fa-book">&nbsp;View project profiles</span></a></li>
                                <li><a href="{{ url('/admin/project/project_agency_update')}}"><span class="fa fa-book">&nbsp;Project Co-agency information</span></a></li>
                                <li><a href="{{ url('/admin/project/project_details_update')}}"><span class="fa fa-book">&nbsp;Project Detail information</span></a></li>
                                <li><a href="{{ url('/admin/project/project_foreign_assistance_update')}}"><span class="fa fa-book">&nbsp;Project Foreign assistance information</span></a></li>
                                <li><a href="{{ url('/admin/project/project_location_update')}}"><span class="fa fa-book">&nbsp;Project Location information</span></a></li>
                                <li><a href="{{ url('/admin/project/project_expenditure_information_update')}}"><span class="fa fa-book">&nbsp;Project cost information</span></a></li>
                                <li><a href="{{ url('/admin/project/project_documents_update')}}"><span class="fa fa-book">&nbsp;Project Document information</span></a></li>
                                <li><a href="{{ url('/admin/project/project_shapefile_update')}}"><span class="fa fa-book">&nbsp;Upload Project Shape file</span></a></li>
                            </ul>
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
    @include('backend/project/project_profile_view')
</div>
@section('footer_js_scrip_area')
@parent
<script type="text/javascript">
            $( function() {
              $( "#project_entry_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
            });
      </script>
<script type="text/javascript">
    function projectFinalSaveAction(form_id){
        swal({
            title: "Confirmation Final Save?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: 'No',
            closeOnConfirm: false
          },
          function(){
            $("#"+form_id).trigger('submit');
          });
    }
    function loadAgencyByMinstry(min_id){
            if(min_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadAgencyByMinstry")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"min_id="+min_id,
                        success     :function(response){
                            $('#agency_id').html(response)
                        }
                    });
            }
        }
</script>
@endsection
@endsection