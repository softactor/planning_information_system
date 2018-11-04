<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Approved Project Details
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
                        <?php
$project_id             =   Session::get('project_id');
$projectClause['table'] =   "projects";   
$projectClause['where'] =   [
    'id'    =>  $project_id
];   
$project_infos      = get_table_data_by_clause($projectClause);
$project_info       =   $project_infos[0]; 

if($project_info->protemp == 1){
    $project_title  =   "New Project Profile";
}elseif($project_info->protemp == 0){
    $project_title  =   "Review Project Profile";
}elseif($project_info->protemp == 2){
    $project_title  =   "Revised Project Profile";
}else{
    $project_title  =   "New Project Profile";
}

/*
 * Project Agency Information
 */

$projectAgClause['table'] =   "projectagencies";   
$projectAgClause['where'] =   [
    'project_id'    =>  $project_id
];   
$project_ag_infos      = get_table_data_by_clause($projectAgClause);
$project_ag_info       =   $project_ag_infos[0];

/*
 * Sector and subsector Information
 */

$projectSubSecClause['table'] =   "subsectors";   
$projectSubSecClause['where'] =   [
    'id'    =>  $project_info->subsector_id
];   
$project_sub_sec_infos      = get_table_data_by_clause($projectSubSecClause);
$project_sub_sec_info       =   $project_sub_sec_infos[0];

/*
 * Project Details
 */
$project_details_param['table'] = "project_details";
$project_details_param['where'] = [
    'project_id' => $project_id
];
$responseData = get_table_data_by_clause($project_details_param);
if (isset($responseData[0]) && !empty($responseData[0])) {
    $project_details = $responseData[0];
}
?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Project name</h4>
                                        <table class="table ">
                                            <tbody class="table-bordered">
                                                <tr>
                                                    <td><?php echo $project_info->project_name_eng; ?></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Ministry</h4>
                                        <table class="table ">
                                            <tbody class="table-bordered">
                                                <tr>
                                                    <td><?php echo get_data_name_by_id("ministries", $project_ag_info->ministry_id)->ministry_name ?></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Sector</h4>
                                        <table class="table ">
                                            <tbody class="table-bordered">
                                                <tr>
                                                    <td><?php echo $project_sub_sec_info->subsector_name; ?></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Sub sector</h4>
                                        <table class="table ">                                    
                                            <tbody class="table-bordered">
                                                <tr>
                                                    <td><?php echo get_data_name_by_id("sectors", $project_sub_sec_info->sector_id)->sector_name; ?></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Executing Agency</h4>
                                <table class="table ">
                                    <tbody class="table-bordered">
                                        <?php
                                        $param = [];
                                        $param['table'] = "projectagencies";
                                        $param['where'] = [
                                            'project_id' => Session::get('project_id')
                                        ];
                                        $pro_agencies = get_table_data_by_clause($param);
                                        foreach ($pro_agencies as $ag) {
                                            ?>
                                            <tr>
                                                <td><?php echo get_data_name_by_id("agencies", $ag->agency_id)->agency_name; ?></td>
                                                <td><?php echo (($ag->lead_agency == 1) ? "Lead" : ""); ?></td>
                                            </tr>
                                        <?php } ?>    
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <?php if (isset($project_details) && !empty($project_details)) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Objectives</h4>
                                    <table class="table ">                            
                                        <tbody class="table-bordered">
                                            <tr>
                                                <td><?php echo $project_details->objectives; ?></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Background</h4>
                                    <table class="table ">
                                        <tbody class="table-bordered">
                                            <tr>
                                                <td><?php echo (isset($project_details->backgrounds) ? $project_details->backgrounds : "No Data Found"); ?></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Main Activities</h4>
                                    <table class="table ">                            
                                        <tbody class="table-bordered">
                                            <tr>
                                                <td><?php echo (isset($project_details->activities) ? $project_details->activities : "No data Found."); ?></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Foreign Assistance</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>Donor</th>
                                            <th>Mode of finance</th>
                                            <th>Amount(Lac Taka)</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                
                                        <?php
                                        $project_fas_param['table'] = "project_fas";
                                        $project_fas_param['where'] = [
                                            'project_id' => $project_id
                                        ];
                                        $fas = get_table_data_by_clause($project_fas_param);
                                        ?>
                                        <?php
                                        foreach ($fas as $ag) {
                                            ?>
                                            <tr>
                                                <td><?php echo get_data_name_by_id("commonconfs", $ag->fa_country)->commonconf_name; ?></td>
                                                <td><?php echo get_data_name_by_id("commonconfs", $ag->fa_donor)->commonconf_name; ?></td>
                                                <td><?php echo get_data_name_by_id("commonconfs", $ag->fa_mof)->commonconf_name; ?></td>
                                                <td><?php echo $ag->fa_amount; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Location</h4>
                                <table  class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Division</th>
                                            <th>District</th>
                                            <th>Upazila</th>
                                            <th>Area</th>
                                            <th>Road</th>
                                            <th>City Corporation</th>
                                            <th>Ward</th>
                                            <th>GIS object</th>
                                            <th>X</th>
                                            <th>Y</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                
                                        <?php
                                        $param['table'] = "projectlocations";
                                        $param['where'] = [
                                            'project_id' => Session::get('project_id')
                                        ];
                                        $fas = get_table_data_by_clause($param);
                                        ?>
                                        <?php
                                        foreach ($fas as $ag) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    if (isset($ag->district_id) && !empty($ag->district_id)) {
                                                        $gisresdata = getDivisionByDistrict($ag->district_id);
                                                        if (isset($gisresdata) && !empty($gisresdata)) {
                                                            echo $gisresdata->dvname;
                                                        }
                                                    }
                                                    if (isset($ag->city_corp_id) && !empty($ag->city_corp_id)) {
                                                        $gisresdata = getDivisionByCC($ag->city_corp_id);
                                                        if (isset($gisresdata) && !empty($gisresdata)) {
                                                            echo $gisresdata->dvname;
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo (isset($ag->district_id) ? get_data_name_by_id("districts", $ag->district_id)->district_name : "") ?></td>
                                                <td><?php echo (isset($ag->upz_id) ? get_data_name_by_id("upazilas", $ag->upz_id)->upazila_name : "") ?></td>                                                    
                                                <td><?php echo (isset($ag->area) ? $ag->area : "") ?></td>
                                                <td><?php echo (isset($ag->city_corp_id) ? get_data_name_by_id("citycorporations", $ag->city_corp_id)->citycorp_name : "") ?></td>
                                                <td><?php echo (isset($ag->ward_id) ? get_data_name_by_id("wards", $ag->ward_id)->ward_nr : "") ?></td>
                                                <td><?php echo (isset($ag->roadno) ? $ag->roadno : "") ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($ag->gisobject_id) && !empty($ag->gisobject_id)) {
                                                        $gisresdata = get_data_name_by_id("gisobjects", $ag->gisobject_id);
                                                        if (isset($gisresdata) && !empty($gisresdata)) {
                                                            echo $gisresdata->gisobject_name;
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo (isset($ag->loc_x) ? $ag->loc_x : "") ?></td>
                                                <td><?php echo (isset($ag->loc_y) ? $ag->loc_y : "") ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Expenditure Information</h4>
                                <?php
                                $param = [];
                                $param['table'] = "projectcosts";
                                $param['where'] = [
                                    'project_id' => Session::get('project_id')
                                ];
                                $fas = get_table_data_by_clause($param);
                                $projectCost = ((isset($fas[0]) ? $fas[0] : ""));
                                ?>
                                <table  class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Revenue</th>
                                            <th>Capital</th>
                                            <th>Contingency</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>GOB</td>
                                            <td>{{ (isset($projectCost->expgobrev)? $projectCost->expgobrev:"")}}</td>
                                            <td>{{ (isset($projectCost->expgobcap) && $projectCost->expgobcap > 0 ? $projectCost->expgobcap:"")}}</td>
                                            <td>{{ (isset($projectCost->expgobcont_ph) && $projectCost->expgobcont_ph > 0 ? $projectCost->expgobcont_ph + $projectCost->expgobcont_pr:"")}}</td>
                                        </tr>
                                        <tr>
                                            <td>PA(RPA+DPA)</td>
                                            <td>{{ (isset($projectCost->expparev) && $projectCost->expparev > 0 ? $projectCost->expparev:"")}}</td>
                                            <td>{{ (isset($projectCost->exppacap) && $projectCost->exppacap > 0 ? $projectCost->exppacap:"")}}</td>
                                            <td>{{ (isset($projectCost->exppacont_ph) && $projectCost->exppacont_ph > 0 ? $projectCost->exppacont_ph + $projectCost->exppacont_pr:"")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Own fund</td>
                                            <td>{{ (isset($projectCost->expofundrev) && $projectCost->expofundrev > 0 ? $projectCost->expofundrev:"")}}</td>
                                            <td>{{ (isset($projectCost->expofundcap) && $projectCost->expofundcap > 0 ? $projectCost->expofundcap:"")}}</td>
                                            <td>{{ (isset($projectCost->expofundcont_ph) && $projectCost->expofundcont_ph > 0 ? $projectCost->expofundcont_ph + $projectCost->expofundcont_pr:"")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Others</td>
                                            <td>{{ (isset($projectCost->expothersrev) && $projectCost->expothersrev > 0 ? $projectCost->expothersrev:"")}}</td>
                                            <td>{{ (isset($projectCost->expotherscap) && $projectCost->expotherscap > 0 ? $projectCost->expotherscap:"")}}</td>
                                            <td>{{ (isset($projectCost->expotherscont_ph) && $projectCost->expotherscont_ph > 0 ? $projectCost->expotherscont_ph + $projectCost->expotherscont_pr:"")}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
</script>
@endsection
@endsection