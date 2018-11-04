<?php
$project_id             =   Session::get('project_id');
$projectClause['table'] =   "projects";   
$projectClause['where'] =   [
    'id'    =>  $project_id
];   
$project_infos      = get_table_data_by_clause($projectClause);
$project_info       =   $project_infos[0]; 

if($project_info->protemp == 1){
    $project_title  =   "Project profile";
}elseif($project_info->protemp == 0){
    $project_title  =   "Project profile";
}elseif($project_info->protemp == 2){
    $project_title  =   "Project profile";
}else{
    $project_title  =   "Project profile";
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
<div id="viewProjectProfile" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 class="modal-title">{{ $project_title }}</h1>
            </div>
            <div class="modal-body">
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
                    <div class="col-md-4">
                        <p><a href="{{ url('/admin/project/approved_project')}}" target="_blank">Existing approved project</a></p>
                        <p><a href="{{ url('/admin/project/project_agency_update')}}">Co-agency information</a></p>
                        <p><a href="{{ url('/admin/project/project_details_update')}}">Detail information</a></p>
                        <p><a href="{{ url('/admin/project/project_foreign_assistance_update')}}">Foreign assistance information</a></p>
                        <p><a href="{{ url('/admin/project/project_location_update')}}">Location information</a></p>
                        <p><a href="{{ url('/admin/project/project_expenditure_information_update')}}">Project cost information</a></p>
                        <p><a href="{{ url('/admin/project/project_documents_update')}}">Document information</a></p>
                        <p><a href="{{ url('/admin/project/project_shapefile_update')}}">Upload shape file</a></p>
                        <p><a href="{{ url('/admin/project/project_download')}}">Download (PDF format)</a></p>
                        <p><a href="{{ url('/admin/project/project_doc_download')}}">Download (DOC format)</a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Executing agency</h4>
                        <table class="table ">
                            <tbody class="table-bordered">
                                <?php
                                $param          =   [];
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
				<?php if(isset($project_details) && !empty($project_details)){ ?>
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
                        <h4>Main activities</h4>
                        <table class="table ">                            
                            <tbody class="table-bordered">
                                <tr>
                                    <td><?php echo (isset($project_details->activities) ? $project_details->activities:"No data Found."); ?></td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                </div>
				<?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Foreign assistance</h4>
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
                                    <th>Union</th>
                                    <th>Road</th>
                                    <th>City corporation</th>
                                    <th>Ward</th>
                                    <th>Cost</th>
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
                                                if(isset($ag->district_id) && !empty($ag->district_id)){
                                                    $gisresdata =   getDivisionByDistrict($ag->district_id);
                                                    if(isset($gisresdata) && !empty($gisresdata)){
                                                        echo $gisresdata->dvname;  
                                                    }
                                                }
                                                if(isset($ag->city_corp_id) && !empty($ag->city_corp_id)){
                                                    $gisresdata =   getDivisionByCC($ag->city_corp_id);
                                                    if(isset($gisresdata) && !empty($gisresdata)){
                                                        echo $gisresdata->dvname;  
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo (isset($ag->district_id)? get_data_name_by_id("districts", $ag->district_id)->district_name:"") ?></td>
                                        <td><?php echo (isset($ag->upz_id)? get_data_name_by_id("upazilas", $ag->upz_id)->upazila_name:"") ?></td>                                                    
                                        <td><?php echo (isset($ag->union_id)? get_data_name_by_id("bd_unions", $ag->union_id)->bd_union_name:"") ?></td>
                                        <td><?php echo (isset($ag->city_corp_id)? get_data_name_by_id("citycorporations", $ag->city_corp_id)->citycorp_name:"") ?></td>
                                        <td><?php echo (isset($ag->ward_id)? get_data_name_by_id("wards", $ag->ward_id)->ward_nr:"") ?></td>
                                        <td><?php echo (isset($ag->roadno) ? $ag->roadno:"") ?></td>
                                        <td>
                                            <?php echo (isset($ag->estmcost) ? $ag->estmcost:"") ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Project cost information</h4>
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
                            <div class="table-responsive">          
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Revenue</th>
                                            <th>Capital</th>
                                            <th>Physical</th>
                                            <th>Price</th>
                                            <th>Grand Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>GOB</td>
                                            <td>{{ (isset($projectCost->expgobrev)? $projectCost->expgobrev:"")}}</td>
                                            <td>{{ (isset($projectCost->expgobcap) && $projectCost->expgobcap > 0 ? $projectCost->expgobcap:"")}}</td>
                                            <td>{{ (isset($projectCost->expgobcont_ph)? $projectCost->expgobcont_ph:'')}}</td>
                                            <td>{{ (isset($projectCost->expgobcont_pr)? $projectCost->expgobcont_pr:'')}}</td>
                                            <td>{{ (isset($projectCost->gob_gt)? $projectCost->gob_gt:"")}}</td>
                                        </tr>
                                        <tr>
                                            <td>PA(RPA + DPA)</td>
                                            <td>{{ (isset($projectCost->expparev) && $projectCost->expparev > 0 ? $projectCost->expparev:"")}}</td>
                                            <td>{{ (isset($projectCost->exppacap) && $projectCost->exppacap > 0 ? $projectCost->exppacap:"")}}</td>
                                            <td>{{ (isset($projectCost->exppacont_ph)? $projectCost->exppacont_ph:'')}}</td>
                                            <td>{{ (isset($projectCost->exppacont_pr)? $projectCost->exppacont_pr:'')}}</td>
                                            <td>{{ (isset($projectCost->pa_gt)? $projectCost->pa_gt:"")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Own fund</td>
                                            <td>{{ (isset($projectCost->expofundrev) && $projectCost->expofundrev > 0 ? $projectCost->expofundrev:"")}}</td>
                                            <td>{{ (isset($projectCost->expofundcap) && $projectCost->expofundcap > 0 ? $projectCost->expofundcap:"")}}</td>
                                            <td>{{ (isset($projectCost->expofundcont_ph)? $projectCost->expofundcont_ph:'')}}</td>
                                            <td>{{ (isset($projectCost->expofundcont_pr)? $projectCost->expofundcont_pr:'')}}</td>
                                            <td>{{ (isset($projectCost->own_gt)? $projectCost->own_gt:"")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Others</td>
                                            <td>{{ (isset($projectCost->expothersrev) && $projectCost->expothersrev > 0 ? $projectCost->expothersrev:"")}}</td>
                                            <td>{{ (isset($projectCost->expotherscap) && $projectCost->expotherscap > 0 ? $projectCost->expotherscap:"")}}</td>
                                            <td>{{ (isset($projectCost->expotherscont_ph)? $projectCost->expotherscont_ph:'')}}</td>
                                            <td>{{ (isset($projectCost->expotherscont_pr)? $projectCost->expotherscont_pr:'')}}</td>
                                            <td>{{ (isset($projectCost->oth_gt)? $projectCost->oth_gt:"")}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{ (isset($projectCost->rev_total) && $projectCost->rev_total > 0 ? $projectCost->rev_total:"")}}</td>
                                            <td>{{ (isset($projectCost->cap_total) && $projectCost->cap_total > 0 ? $projectCost->cap_total:"")}}</td>
                                            <td>{{ (isset($projectCost->conph_total)? $projectCost->conph_total:'')}}</td>
                                            <td>{{ (isset($projectCost->conpr_total)? $projectCost->conpr_total:'')}}</td>
                                            <td>{{ (isset($projectCost->sum_grand_total)? $projectCost->sum_grand_total:"")}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>