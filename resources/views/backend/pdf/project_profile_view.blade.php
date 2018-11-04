<?php date_default_timezone_set("Asia/Dhaka");
$project_id = Session::get('project_id');
$projectClause['table'] = "projects";
$projectClause['where'] = [
    'id' => $project_id
];
$project_infos = get_table_data_by_clause($projectClause);
$project_info = $project_infos[0];
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

$projectAgClause['table'] = "projectagencies";
$projectAgClause['where'] = [
    'project_id' => $project_id
];
$project_ag_infos = get_table_data_by_clause($projectAgClause);
$project_ag_info = $project_ag_infos[0];

/*
 * Sector and subsector Information
 */

$projectSubSecClause['table'] = "subsectors";
$projectSubSecClause['where'] = [
    'id' => $project_info->subsector_id
];
$project_sub_sec_infos = get_table_data_by_clause($projectSubSecClause);
$project_sub_sec_info = $project_sub_sec_infos[0];

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
<style type="text/css">
    .main_section_container{
        margin: auto;
        width: 790px;
        padding: 10px;
    }
    #viewProjectProfile{
        width: 720px;
        margin: 5px 5px 5px -5px;  
        float: left;
    }
    .row{
        margin: 0 5px;
    }
    .row .row_full_col{
        width: 720px;
        padding: 5px;
        float: left;
    }
    .row .row_half_col{
        width: 340px;
        padding: 5px;
        float: left;
    }
/*    .row .row_half_col h4{
        margin-top: -1px;
    }*/
    #viewProjectProfile table{
        width: 720px;
        max-width: 720px;
        margin-bottom: 5px;
        background-color: #DEDEDE;
        /*border: 1px solid lightgrey;*/
        border-collapse: collapse;
        font-size: 13px;
    }
    #viewProjectProfile table.half_table{
        width: 340px;
    }
    #viewProjectProfile table tr th{
        padding: 5px;
        font-weight: bold;
        text-align: center;
        font-size: 13px;
    }
    #viewProjectProfile table tr td{
        padding: 10px;
        background-color: #DEDEDE;
        font-size: 12px;
        border-top: 1px solid #f4f4f4;

    }
    #viewProjectProfile table tbody.text_center tr td{
        text-align: center;
    }
    .table-bordered{
        border: 1px solid #f4f4f4;
    }
    #viewProjectProfile h4{
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
        text-transform: capitalize;
    }
    p.project_title{
        text-align: center;
    }
    .clear_fix{
        clear: both;
    }
</style>
<div class="main_section_container">
    <div id="viewProjectProfile">
        <div class="row">
            <div class="row_full_col">
                <!--Project Information-->
                <table class="plain_normal_table">
                    <tr>
                        <td>
                            <p class="project_title"><?php echo $project_title; ?></p>
                        </td>
                    </tr>
                </table>
                
                <h4>Project name</h4>
                <table class="table ">
                    <tbody class="table-bordered">
                        <tr>
                            <td><?php echo $project_info->project_name_eng; ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="clear_fix"></div>
                <!--Ministry Information-->

                <h4>Ministry</h4>
                <table class="table ">
                    <tbody class="table-bordered">
                        <tr>
                            <td><?php echo get_data_name_by_id("ministries", $project_ag_info->ministry_id)->ministry_name ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="clear_fix"></div>
                <table style="background-color: white; border: 0;">
                    <tr style="background-color: white;">
                        <td style="background-color: white;">
                            <h4>Sector</h4>
                            <table class="half_table">
                                <tbody class="table-bordered">
                                    <tr>
                                        <td><?php echo $project_sub_sec_info->subsector_name; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="background-color: white;">
                            <h4>Sub sector</h4>
                            <table class="half_table">                                    
                                <tbody class="table-bordered">
                                    <tr>
                                        <td><?php echo get_data_name_by_id("sectors", $project_sub_sec_info->sector_id)->sector_name; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <!--Executing Agency-->
                <div class="clear_fix"></div>
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
                <div class="clear_fix"></div>
                <h4>Objectives</h4>
                <table class="table ">                            
                    <tbody class="table-bordered">
                        <tr>
                            <td><?php if(isset($project_details->objectives) && !empty($project_details->objectives)){ echo $project_details->objectives; } ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="clear_fix"></div>
                <h4>Background</h4>
                <table class="table ">
                    <tbody class="table-bordered">
                        <tr>
                            <td><?php echo (isset($project_details->backgrounds) ? $project_details->backgrounds : "No Data Found"); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="clear_fix"></div>
                <h4>Main Activities</h4>
                <table class="table ">                            
                    <tbody class="table-bordered">
                        <tr>
                            <td><?php echo (isset($project_details->activities) ? $project_details->activities : "No data Found."); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="clear_fix"></div>
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
                    <tbody class="text_center">                                
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
                <div class="clear_fix"></div>
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
                    <tbody class="text_center">                                
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
                                <td>{{ (isset($ag->district_id)? getDivisionByDistrict($ag->district_id)->dvname    : getDivisionByCC($ag->city_corp_id)->dvname) }}</td>
                                <td><?php echo (isset($ag->district_id) ? get_data_name_by_id("districts", $ag->district_id)->district_name : "") ?></td>
                                <td><?php echo (isset($ag->upz_id) ? get_data_name_by_id("upazilas", $ag->upz_id)->upazila_name : "") ?></td>                                                    
                                <td><?php echo (isset($ag->area) ? $ag->area : "") ?></td>
                                <td><?php echo (isset($ag->city_corp_id) ? get_data_name_by_id("citycorporations", $ag->city_corp_id)->citycorp_name : "") ?></td>
                                <td><?php echo (isset($ag->ward_id) ? get_data_name_by_id("wards", $ag->ward_id)->ward_nr : "") ?></td>
                                <td><?php echo (isset($ag->roadno) ? $ag->roadno : "") ?></td>
                                <td><?php echo (isset($ag->gisobject_id) ? get_data_name_by_id("gisobjects", $ag->gisobject_id)->gisobject_name : "") ?></td>
                                <td><?php echo (isset($ag->loc_x) ? $ag->loc_x : "") ?></td>
                                <td><?php echo (isset($ag->loc_y) ? $ag->loc_y : "") ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="clear_fix"></div>
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
                    <tbody class="text_center">
                        <tr>
                            <td>GOB</td>
                            <td>{{ (isset($projectCost->expgobrev)? $projectCost->expgobrev:"")}}</td>
                            <td>{{ (isset($projectCost->expgobcap) && $projectCost->expgobcap > 0 ? $projectCost->expgobcap:"")}}</td>
                            <td>{{ (isset($projectCost->expgobcont) && $projectCost->expgobcont > 0 ? $projectCost->expgobcont:"")}}</td>
                        </tr>
                        <tr>
                            <td>PA(RPA+DPA)</td>
                            <td>{{ (isset($projectCost->expparev) && $projectCost->expparev > 0 ? $projectCost->expparev:"")}}</td>
                            <td>{{ (isset($projectCost->exppacap) && $projectCost->exppacap > 0 ? $projectCost->exppacap:"")}}</td>
                            <td>{{ (isset($projectCost->exppacont) && $projectCost->exppacont > 0 ? $projectCost->exppacont:"")}}</td>
                        </tr>
                        <tr>
                            <td>Own fund</td>
                            <td>{{ (isset($projectCost->expofundrev) && $projectCost->expofundrev > 0 ? $projectCost->expofundrev:"")}}</td>
                            <td>{{ (isset($projectCost->expofundcap) && $projectCost->expofundcap > 0 ? $projectCost->expofundcap:"")}}</td>
                            <td>{{ (isset($projectCost->expofundcont) && $projectCost->expofundcont > 0 ? $projectCost->expofundcont:"")}}</td>
                        </tr>
                        <tr>
                            <td>Others</td>
                            <td>{{ (isset($projectCost->expothersrev) && $projectCost->expothersrev > 0 ? $projectCost->expothersrev:"")}}</td>
                            <td>{{ (isset($projectCost->expotherscap) && $projectCost->expotherscap > 0 ? $projectCost->expotherscap:"")}}</td>
                            <td>{{ (isset($projectCost->expotherscont) && $projectCost->expotherscont > 0 ? $projectCost->expotherscont:"")}}</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tr>
                        <td>
                            <p style="text-align: center">Design & Developed By <b>PLIS</b> &copy; {{ date('Y')}}. Printed time: <?php echo date("F jS, Y") ?>on <?php echo date("g:i:s A"); ?></p>
                        </td>
                    </tr>
                </table>
                <div class="clear_fix"></div>
            </div>   <!-- End of full col -->
            <!--Sector and subsector information-->
            <div class="clear_fix"></div>
        </div>
        <div class="clear_fix"></div>
    </div>    
    <div class="clear_fix"></div>
</div>