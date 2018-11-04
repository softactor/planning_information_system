<?php

/* 
 * utilities method will be use for access frequently data from every where.
 * there will be custom method for custom result
 * @author: Tanveer Qureshee
 * Date: 01/01/2018
 */

//-----------------------------------------------
//Use model and all facad area
//-----------------------------------------------
use Illuminate\Support\Facades\DB;

// GET TABLE DATA BY TABLE NAME:

function get_table_data_by_table($table, $order_by  =   null){
    $result     =    DB::table($table);
    if(isset($order_by['order_by'])){
        $result->orderBy($order_by['order_by_column'], $order_by['order_by']);
    }
    return $result->get();
}

// GET TABLE DATA BY TABLE NAME:

function get_data_name_by_id($table,$id){
    return DB::table($table)->where('id', '=', $id)->first();
}

// CHECK DUPLICATE DATA ENTRY:

function check_duplicate_data($data){
    $result     =    DB::table($data['table'])->where($data['where'])->first();
    if(isset($result) && !empty($result)){
        return $result->id;
    }else{
        return false;
    }
}
// GET TABLE DATA BY TABLE NAME:

function get_table_data_by_clause($data){
    $result     =    DB::table($data['table'])
            ->where($data['where']);
    if(isset($data['order_by'])){
        $result->orderBy($data['order_by_column'], $data['order_by']);
    }
    $result_data    =   $result->get();
    if(isset($result_data) && !empty($result_data)){
        return $result_data;
    }else{
        return false;
    }
} 

function hasAccessPermission($user_id, $page_id, $accessType){
    $return =   false;
    $access = DB::table('page_access as pa')
            ->join('model_has_roles as mhr', 'pa.role_id', '=', 'mhr.role_id')
            ->where('mhr.model_id','=',$user_id)
            ->where('pa.page_id','=',$page_id)
            ->where('pa.'.$accessType,'=',1)
            ->select('pa.*')
            ->get();
    
    if($access->first()){
        $return =   true;
    }
    
    return $return;
}

function getDivisionByDistrict($district_id){
   $return =   false;
    $access = DB::table('admdivisions as div')
            ->join('districts as dis', 'dis.div_id', '=', 'div.id')
            ->where('dis.id','=',$district_id)
            ->select('div.*')
            ->get();
    
    if($access->first()){
        $return =   $access->first();
    }
    
    return $return; 
}

function getDivisionByCC($cc_id){
   $return =   false;
    $access = DB::table('admdivisions as div')
            ->join('citycorporations as dis', 'dis.div_id', '=', 'div.id')
            ->where('dis.id','=',$cc_id)
            ->select('div.*')
            ->get();
    
    if($access->first()){
        $return =   $access->first();
    }
    
    return $return; 
}

function getRoleWiseUser($role_id){
    $users = DB::table('users as u')
            ->join('model_has_roles as mhr', 'u.id', '=', 'mhr.model_id')
            ->join('roles as r', 'r.id', '=', 'mhr.role_id')
            ->where('r.id','=',$role_id)
            ->select(DB::raw('CONCAT(u.first_name,u.last_name) AS name'), "u.id")
            ->get();
    return $users;
}

function getRoleIdByUserId($user_id){
    $role   =   DB::table('model_has_roles as hr')
                ->where('hr.model_id',$user_id)
                ->first();
    return  $role->role_id;
}

function get_project_type_by_project_id($project_id){
    $project_type_data   =   DB::table('projects')
                            ->select('protemp')
                            ->where('id',$project_id)
                            ->first();
    return $project_type_data;    
}

function get_project_progress_id_by_project_id($project_id){
    $project_type_data   =   DB::table('project_progress')
                            ->where('pversion_id',$project_id)
                            ->orderBy('updated_at', 'desc')
                            ->limit(1)
                            ->first();
    return $project_type_data; 
}

function get_project_version_id_by_project_id($project_id){
    $project_type_data   =   DB::table('project_versions')
                            ->where('project_id',$project_id)
                            ->orderBy('updated_at', 'desc')
                            ->limit(1)
                            ->first();
    return $project_type_data; 
}

function check_all_required_table_has_data($project_id){
    $check_result   =   true;
    $table_arrays   =   ['projectdocuments','projectlocations','project_details','projectcosts'];
    foreach($table_arrays as $table){
        if($table == "projectcosts"){
            $latest_project_version =   get_project_version_id_by_project_id($project_id);
            if(isset($latest_project_version) && !empty($latest_project_version)){
                $version_id =   $latest_project_version->id;
                $project_progress   =   get_project_progress_id_by_project_id($version_id);                            
                $progress_id        =   $project_progress->id;
                $data['table']  =   $table;
                $data['where']  =   [
                    'project_id'=>$progress_id
                ];
                $r  =   check_duplicate_data($data);
                if(!$r){
                    return false;
                }
            }
        }else{
            $data['table']  =   $table;
            $data['where']  =   [
                'project_id'=>$project_id
            ];
            $r  =   check_duplicate_data($data);
            if(!$r){
                return false;
            }
        }        
    }// end of foreach
    
    return $check_result;
}

function getLocationCenterCoordinates($data) {
    // get location center coordinates:
    $ceterCordinates    =   DB::table($data['table'])->where($data['where'])->first();
    if($data['location_type']  ==   1) {
        $centerCoordinates_x    =   $ceterCordinates->upz_x;
        $centerCoordinates_y    =   $ceterCordinates->upz_y;
    }elseif($data['location_type']  ==   3){
        $centerCoordinates_x    =   $ceterCordinates->un_x;
        $centerCoordinates_y     =   $ceterCordinates->un_y;
    }else{
        $centerCoordinates_x    =   $ceterCordinates->ward_x;
        $centerCoordinates_y    =   $ceterCordinates->ward_y;
    }
    $calNumber      =   (int)($ceterCordinates->number/72);
    $radious        =   (0.002+0.002*$calNumber);
    $angle          =   $ceterCordinates->number * 5;
    $new_co_of_x    =   $centerCoordinates_x + cos($angle) * $radious;
    $new_co_of_y    =   $centerCoordinates_y + sin($angle) * $radious;
    
    $feedback_data  =   [
        'status'                =>  true,//means location has project
        'message'               =>  'Center Coordinates',
        'location-coordinets'   =>  [
            'loc_x' =>  number_format((float)$new_co_of_x, 6, '.', ''),
            'loc_y' =>  number_format((float)$new_co_of_y, 6, '.', '')
        ],
        'update_number' =>  $ceterCordinates->number+1
    ];
    return $feedback_data;
}

function update_table($data) {
    $result =   DB::table($data['table'])
            ->where($data['where'])
            ->update($data['updates_value']);
    return $result;
    
}

function getTableTotalRows($data){
    $field  =   $data['field'];
    $total_row   =   DB::table($data['table'])
                            ->select(DB::raw("count($field) as total"))
                            ->where($data['where'])
                            ->first();
    return $total_row;
}