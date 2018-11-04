<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small> Update</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashbord')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url($list_url) }}">{{ $list_title }}</a></li>
            <li class="active">{{ $list_title }} Update</li>
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
                            $project_id     =   Session::get('project_id');
                            $param['table']     = "projects";
                            $param['where']     = [
                                'id'    => Session::get('project_id')
                            ];
                            $pdata              =   get_table_data_by_clause($param);
                            $project_data       =   $pdata[0];
                            
                        ?>
                        <form class="form-horizontal" action="{{ url('admin/project/project_agency_store') }}" method="post">
                            {{csrf_field()}}
                            @include("backend.pertial.project_entry_form_fixed_part")
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
                                <label class="control-label col-sm-3" for="agency">Co-agency<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('agency_id'))
                                        <div class="alert-error">{{ $errors->first('agency_id') }}</div>
                                    @endif
                                    <select class="form-control" id="agency_id" name="agency_id" onchange="hideErrorDiv('agency_id')">
                                        <option value="">Select Agency</option>
                                        <?php
                                        $result = get_table_data_by_table('agencies');
                                        foreach ($result as $data) {
                                            ?>
                                            <option value="<?php echo $data->id ?>"><?php echo $data->agency_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group" style="display: none">
                                <label class="control-label col-sm-3" for="page">Lead Agency</label>
                                <div class="col-sm-8">
                                    <div class="checkbox">
                                        <label style="margin-left:15px"><input id="lead_agency" name="lead_agency" type="checkbox" value="1"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" id="lead_agency_edit_id" name="lead_agency_edit_id" value="">
                                    <input type="hidden" id="agency_edit_id" name="agency_edit_id" value="">
                                    <input type="hidden" name="project_id" value="<?php echo $project_data->id; ?>">
                                    <input type="submit" name="submit" value="Save" class="btn btn-success">
                                    <?php
                                        $project_view_as    =   Session::get('project_vew_as');
                                        switch($project_view_as){
                                            case "temporary":
                                                $back_url   =   "admin/project/temporary_project_view/".$project_id;
                                                break;
                                            case "quality_review":
                                                $back_url   =   "admin/project/project_quality_review_view/".$project_id;
                                                break;
                                            case "revised_project":
                                                $back_url   =   "admin/project/revised_projects_view/".$project_id;
                                                break;
                                        }
                                    ?>
                                    <a href="{{ url($back.$project_id)}}" class="btn btn-info"><< Back</a>
                                </div>
                            </div>
                        </form>
                        <?php
                        $param['table'] = "projectagencies";
                        $param['where'] = [
                            'project_id' => Session::get('project_id')
                        ];
                        $agencies = get_table_data_by_clause($param);
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ministry name</th>
                                    <th>Agency name</th>
                                    <th>Lead Agency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>  
                                <?php
                                foreach ($agencies as $ag) {
                                    ?>
                                    <tr>
                                        <td>#</td>
                                        <td><?php echo get_data_name_by_id("ministries", $ag->ministry_id)->ministry_name; ?></td>
                                        <td><?php echo get_data_name_by_id("agencies", $ag->agency_id)->agency_name; ?></td>
                                        <td><?php echo (($ag->lead_agency == 1) ? "Yes" : "No"); ?></td>
                                        <td>
                                            <?php if($ag->lead_agency !=1 ){ ?>
                                            <a href="#" class="btn btn-xs btn-info" onclick="onPageEditData({{$ag->id}}, 'projectagencies')">Edit</a>
                                            <?php } ?>
                                                <?php if($ag->lead_agency !=1 ){ ?>
                                                <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$ag->id}}, 'projectagencies');">Delete</button>
                                            <?php } ?>
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