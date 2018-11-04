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
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="date">Date<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('project_entry_date'))
                                        <div class="alert-error">{{ $errors->first('project_entry_date') }}</div>
                                    @endif
                                    <input type="text" autocomplete="off" class="form-control" id="project_entry_date" name="project_entry_date" value="{{ old('project_entry_date') }}" onchange="hideErrorDiv('project_entry_date')">
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
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="prjname">Project name (English)<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('project_name_eng'))
                                        <div class="alert-error">{{ $errors->first('project_name_eng') }}</div>
                                    @endif
                                    <input type="text" class="form-control" id="project_name_eng" name="project_name_eng" value="{{ old('project_name_eng') }}" onkeyup="hideErrorDiv('project_name_eng')">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="prjname1">Project name (Bangla)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="project_name_bng" name="project_name_bng" value="{{ old('project_name_bng') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="short">Short name<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('project_short_name'))
                                        <div class="alert-error">{{ $errors->first('project_short_name') }}</div>
                                    @endif
                                    <input type="text" class="form-control" id="project_short_name" name="project_short_name" value="{{ old('project_short_name') }}" onkeyup="hideErrorDiv('project_short_name')">
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
                                        $result = get_table_data_by_table('pcdivisions',$order_by);//
                                        foreach($result as $data){
                                        ?>
                                        <option value="<?php echo $data->id ?>" {{($data->id == old('pcdivision_id') || $data->id == 4) ? 'selected' : ''}}><?php echo $data->pcdivision_name ?></option>
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
                                        foreach($result as $data){
                                        ?>
                                        <option value="<?php echo $data->id ?>" {{($data->id == old('wing_id')) ? 'selected' : ''}}><?php echo $data->wing_name ?></option>
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
                                        <option value="">Select Ministry</option>
                                        <?php
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "ministry_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('ministries',$order_by);
                                        foreach($result as $data){
                                        ?>
                                        <option value="<?php echo $data->id ?>" {{($data->id == old('ministry_id')) ? 'selected' : ''}}><?php echo $data->ministry_name."(".$data->ministry_name_bn.")" ?></option>
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
                                        <option value="">Select Agency(Lead)</option>
                                        <?php  
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "agency_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('agencies',$order_by);
                                        foreach($result as $data){
                                        ?>
                                        <option value="<?php echo $data->id ?>" {{($data->id == old('agency_id')) ? 'selected' : ''}}><?php echo $data->agency_name."(".$data->agency_name_bn.")" ?></option>
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
                                        $result = get_table_data_by_table('subsectors',$order_by);//
                                        foreach($result as $data){
                                        ?>
                                        <option value="<?php echo $data->id ?>" {{($data->id == old('subsector_id')) ? 'selected' : ''}}><?php echo $data->subsector_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="keyw">Keyword</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="search_keyword" name="search_keyword" value="{{ old('search_keyword') }}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ url($list_url)}}" class="btn btn-info">Menu</a>
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
        $( "#project_entry_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
      }); 
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