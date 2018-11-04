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

<div>
    <h4><?php echo $project_title; ?></h4>
    <h4>Project name</h4>
    <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
        <tbody>
            <tr style="border-width: 1px; border-style: solid; border-color: black;">
                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo $project_info->project_name_eng; ?></td>
            </tr>
        </tbody>
    </table>
    <div></div>
    <!--Ministry Information-->

    <h4>Ministry</h4>
    <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
        <tbody>
            <tr style="border-width: 1px; border-style: solid; border-color: black;">
                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo get_data_name_by_id("ministries", $project_ag_info->ministry_id)->ministry_name ?></td>
            </tr>
        </tbody>
    </table>
    <div></div>
    <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
        <tr style="border-width: 1px; border-style: solid; border-color: black;">
            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">
                <h4>Sector</h4>
                <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
                    <tbody>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo $project_sub_sec_info->subsector_name; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">
                <h4>Sub sector</h4>
                <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">                                    
                    <tbody>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo get_data_name_by_id("sectors", $project_sub_sec_info->sector_id)->sector_name; ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <h4>Executing Agency</h4>
    <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
        <tbody>
            <?php
            $param = [];
            $param['table'] = "projectagencies";
            $param['where'] = [
                'project_id' => Session::get('project_id')
            ];
            $pro_agencies = get_table_data_by_clause($param);
            foreach ($pro_agencies as $ag) {
                ?>
                <tr style="border-width: 1px; border-style: solid; border-color: black;">
                    <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo get_data_name_by_id("agencies", $ag->agency_id)->agency_name; ?></td>
                    <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo (($ag->lead_agency == 1) ? "Lead" : ""); ?></td>
                </tr>
            <?php } ?>    
        </tbody>
    </table>
    <div></div>
    <h4>Objectives</h4>
    <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">                            
        <tbody>
            <tr style="border-width: 1px; border-style: solid; border-color: black;">
                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">
                    <?php if(isset($project_details->objectives) && !empty($project_details->objectives)){ echo htmlspecialchars($project_details->objectives, ENT_QUOTES); } ?>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Background</h4>
    <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
        <tbody>
            <tr style="border-width: 1px; border-style: solid; border-color: black;">
                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">
                    <?php if(isset($project_details->backgrounds) && !empty($project_details->backgrounds)){ echo htmlspecialchars($project_details->backgrounds, ENT_QUOTES);} ?>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Main activities</h4>
    <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
        <tbody>
            <tr style="border-width: 1px; border-style: solid; border-color: black;">
                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">
                    <?php if(isset($project_details->activities) && !empty($project_details->activities)){echo htmlspecialchars($project_details->activities, ENT_QUOTES); } ?>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Foreign Assistance</h4>
                <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
                    <thead>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
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
                            <tr style="border-width: 1px; border-style: solid; border-color: black;">
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo get_data_name_by_id("commonconfs", $ag->fa_country)->commonconf_name; ?></td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo get_data_name_by_id("commonconfs", $ag->fa_donor)->commonconf_name; ?></td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo get_data_name_by_id("commonconfs", $ag->fa_mof)->commonconf_name; ?></td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo $ag->fa_amount; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h4>Location</h4>
                <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
                    <thead>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <th>Division</th>
                            <th>District</th>
                            <th>Upazila</th>
                            <th>Union</th>
                            <th>Road</th>
                            <th>City Corporation</th>
                            <th>Ward</th>
                            <th>Cost</th>
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
                            <tr style="border-width: 1px; border-style: solid; border-color: black;">
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($ag->district_id)? getDivisionByDistrict($ag->district_id)->dvname    : getDivisionByCC($ag->city_corp_id)->dvname) }}</td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo (isset($ag->district_id) ? get_data_name_by_id("districts", $ag->district_id)->district_name : "") ?></td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo (isset($ag->upz_id) ? get_data_name_by_id("upazilas", $ag->upz_id)->upazila_name : "") ?></td>                                                    
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo (isset($ag->union_id)? get_data_name_by_id("unions", $ag->union_id)->union_name:"") ?></td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo (isset($ag->city_corp_id) ? get_data_name_by_id("citycorporations", $ag->city_corp_id)->citycorp_name : "") ?></td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo (isset($ag->ward_id) ? get_data_name_by_id("wards", $ag->ward_id)->ward_nr : "") ?></td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo (isset($ag->roadno) ? $ag->roadno : "") ?></td>
                                <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;"><?php echo (isset($ag->estmcost) ? $ag->estmcost : "") ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
    <h4>Expenditure Information</h4>
                        <?php
                            
                            // get project version id
                            $project_versions   =   get_project_version_id_by_project_id(Session::get('project_id'));
                            $version_id         =   $project_versions->rev_number;
                            $version_id         =   $version_id+1;
                            // get latest projects progress id
                            // get latest projects progress id                            
                            $project_progress   =   get_project_progress_id_by_project_id($project_versions->id);
                            
                            $progress_id        =   $project_progress->id;
                            $param['table']     = "projects";
                            $param['where']     = [
                                'id'    => Session::get('project_id')
                            ];
                            $pdata              =   get_table_data_by_clause($param);
                            $project_data       =   $pdata[0];
                            // now we have progress id so we can get progress cost data by progress id
                            $param = [];
                            $param['table'] = "projectcosts";
                            $param['where'] = [
                                'project_id' => $progress_id
                            ];
                            $fas = get_table_data_by_clause($param);
                            $projectCost    =   ((isset($fas[0]) ? $fas[0]:""));
                        ?>
                <table style="width: 100%; border-width: 1px; border-style: solid; border-color: black;">
                    <thead>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <th>Title</th>
                            <th>Revenue</th>
                            <th>Capital</th>
                            <th>Physical</th>
                            <th>Price</th>
                            <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">GOB</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expgobrev)? $projectCost->expgobrev:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expgobcap) && $projectCost->expgobcap > 0 ? $projectCost->expgobcap:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expgobcont_ph)? $projectCost->expgobcont_ph:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expgobcont_pr)? $projectCost->expgobcont_pr:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->gob_gt)? $projectCost->gob_gt:"")}}</td>
                        </tr>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">PA(RPA + DPA)</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expparev) && $projectCost->expparev > 0 ? $projectCost->expparev:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->exppacap) && $projectCost->exppacap > 0 ? $projectCost->exppacap:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->exppacont_ph)? $projectCost->exppacont_ph:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->exppacont_pr)? $projectCost->exppacont_pr:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->pa_gt)? $projectCost->pa_gt:"")}}</td>
                        </tr>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">Own Fund</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expofundrev) && $projectCost->expofundrev > 0 ? $projectCost->expofundrev:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expofundcap) && $projectCost->expofundcap > 0 ? $projectCost->expofundcap:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expofundcont_ph)? $projectCost->expofundcont_ph:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expofundcont_pr)? $projectCost->expofundcont_pr:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->own_gt)? $projectCost->own_gt:"")}}</td>
                        </tr>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">Others</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expothersrev) && $projectCost->expothersrev > 0 ? $projectCost->expothersrev:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expotherscap) && $projectCost->expotherscap > 0 ? $projectCost->expotherscap:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expotherscont_ph)? $projectCost->expotherscont_ph:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->expotherscont_pr)? $projectCost->expotherscont_pr:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->oth_gt)? $projectCost->oth_gt:"")}}</td>
                        </tr>
                        <tr style="border-width: 1px; border-style: solid; border-color: black;">
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">All Total</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->rev_total) && $projectCost->rev_total > 0 ? $projectCost->rev_total:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->cap_total) && $projectCost->cap_total > 0 ? $projectCost->cap_total:"")}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->conph_total)? $projectCost->conph_total:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->conpr_total)? $projectCost->conpr_total:'')}}</td>
                            <td style="margin: 1px; padding: 2px;border-width: 1px; border-style: solid; border-color: black;">{{ (isset($projectCost->sum_grand_total)? $projectCost->sum_grand_total:"")}}</td>
                        </tr>
                    </tbody>
                </table>
</div>   <!-- End of full col -->