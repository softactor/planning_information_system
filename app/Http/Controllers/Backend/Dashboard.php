<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use View;
use Validator;

class Dashboard extends Controller
{
    public $list_title      =   "Dashboard";
    public $create_url      =   "admin/dashboard";
    public $edit_url        =   "admin/dashboard";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "adminstrator";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //code will start here
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('backend.dashboard');
    }
    
    /**
     * Show the form for assigning role for page.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_role_assign(){
        $list_title     =   "Role Assign";
        $list_url       =   "admin/role_assign";
        $page           =   "Create";
        $active_menu    =   $this->active_menu;
        return view('backend.roles.role_assign', compact('list_title','list_url','page','active_menu'));
    }
    
    
    public function user_role_assign_store(Request $request){
        
        $rules  =   [
            'role'     =>  'required'
        ];
        
        // Create a new validator instance
        
        $validator      =   Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/dashbord/role_assign')
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error','Failed to save data');
        }
        $duplicate['table'] =   'page_access';
        $duplicate['where'] =   [
            'role_id'       =>  $request->role
        ];
        $checkResponse      =   check_duplicate_data($duplicate);
        if($checkResponse){
            $delete_check   =   DB::table('page_access')->where('role_id', '=', $request->role)->delete();
        }
        
        
        
        /*====================================================
         * //get all screen page
         * @param: table name
         * @param: where tble field
         * ===================================================
         */
        $clause['table']    =   'commonconfs';
        $clause['order_by'] = "ASC";
        $clause['order_by_column'] = "commonconf_name";
        $clause['where']    =   [
            'commonconf_type'   =>  8
        ];
        $all_screen_page    = get_table_data_by_clause($clause);
        //end of getting page:
        
        /*
         * ======================================================
         * initialize some array variable
         */        
        
        $page_access['add']        =   ((isset($request->add) && !empty($request->add))         ? $request->add     : []);
        $page_access['edit']       =   ((isset($request->edit) && !empty($request->edit))       ? $request->edit    : []);
        $page_access['delete']     =   ((isset($request->delete) && !empty($request->delete))   ? $request->delete  : []);
        $page_access['view']       =   ((isset($request->view) && !empty($request->view))       ? $request->view    : []);
        $page_access['print']      =   ((isset($request->print) && !empty($request->print))     ? $request->print   : []);
        
        foreach($all_screen_page as $screen){
            $add                =   0;
            $edit               =   0;
            $delete             =   0;
            $view               =   0;
            $print              =   0;
            $page_access_op     =   false;
            
            if(isset($page_access['add']) && !empty($page_access['add']) && in_array($screen->id, $page_access['add'])){
                $add                =   1;
                $page_access_op     =   true;
            }else{
                $add                =   0;
                $page_access_op     =   true;
            }
            
            if(isset($page_access['edit']) && !empty($page_access['edit']) && in_array($screen->id, $page_access['edit'])){
                $edit               =   1;
                $page_access_op     =   true;
            }else{
                $edit                =   0;
                $page_access_op     =   true;
            }
            
            if(isset($page_access['delete']) && !empty($page_access['delete']) && in_array($screen->id, $page_access['delete'])){
                $delete             =   1;
                $page_access_op     =   true;
            }else{
                $delete                =   0;
                $page_access_op     =   true;
            }
            
            if(isset($page_access['view']) && !empty($page_access['view']) && in_array($screen->id, $page_access['view'])){
                $view               =   1;
                $page_access_op     =   true;
            }else{
                $view                =   0;
                $page_access_op     =   true;
            }
            
            if(isset($page_access['print']) && !empty($page_access['print']) && in_array($screen->id, $page_access['print'])){
                $print              =   1;
                $page_access_op     =   true;
            }else{
                $print                =   0;
                $page_access_op     =   true;
            }
            
            if($page_access_op){
                $insert_data    =   [
                  'role_id'     => $request->role,
                  'page_id'     => $screen->id,
                  'add'         => $add,
                  'edit'        => $edit,
                  'delete'      => $delete,
                  'view'        => $view,
                  'print'       => $print
                ]; //end of insert data
                DB::table('page_access')->insert($insert_data);
            }else{
                
            }
        }//end of for each
        
        return redirect('admin/dashbord/role_assign')
                ->with('success', 'Data have been updated successfully.');
    }
    
    public function getAllPageAccess(Request $request) {
        /* ====================================================
         * //get all screen page
         * @param: table name
         * @param: where tble field
         * ===================================================
         */
        $sp_array =   [];
        $sp_array_page_access =   [];
        $sp_name_array =   [];
        $param['table'] = "commonconfs";
        $param['order_by'] = "ASC";
        $param['order_by_column'] = "commonconf_name";
        $param['where'] = [
            'commonconf_type' => 8
        ];            
        $screen_pages = get_table_data_by_clause($param);
        foreach($screen_pages as $sp){
            $sp_array[] =   $sp->id;
            $sp_name_array[$sp->id] =   $sp->commonconf_name;
        }        
        
        $all_screen_page = DB::table('commonconfs')
                ->leftJoin('page_access', 'commonconfs.id', '=', 'page_access.page_id')
                ->select('page_access.*','commonconfs.commonconf_name')
                ->where('page_access.role_id', '=', $request->role_id)
                ->orderBy('commonconfs.commonconf_name', 'ASC')
                ->get();
        if ($all_screen_page->first()) {
            $final_page_data    =   [];
            foreach($all_screen_page as $asp){
                $sp_array_page_access[] =   $asp->page_id;
                $final_page_data[]    =   [
                    'id' => $asp->id,
                    'role_id' => $asp->role_id,
                    'page_id' => $asp->page_id,
                    'add' => $asp->add,
                    'edit' => $asp->edit,
                    'delete' => $asp->delete,
                    'view' => $asp->view,
                    'print' => $asp->print,
                    'created_at' => $asp->created_at,
                    'updated_at' => $asp->updated_at,
                    'commonconf_name' => $asp->commonconf_name,
                ];
            }
            $missing_page   =   array_diff($sp_array,$sp_array_page_access);
            if(isset($missing_page) && !empty($missing_page)){
                foreach($missing_page as $mp){
                    $final_page_data[]    =   [
                    'id' => '',
                    'role_id' => '',
                    'page_id' => $mp,
                    'add' => '',
                    'edit' => '',
                    'delete' => '',
                    'view' => '',
                    'print' => '',
                    'created_at' => '',
                    'updated_at' => '',
                    'commonconf_name' => $sp_name_array[$mp],
                ];
                }
            }
            $all_screen_page =  $final_page_data;
            $view = View::make('backend.pertial.json_page_role_assign', compact('all_screen_page'));
        } else {
            $param['table'] = "commonconfs";
            $param['order_by'] = "ASC";
            $param['order_by_column'] = "commonconf_name";
            $param['where'] = [
                'commonconf_type' => 8
            ];            
            $all_screen_page = get_table_data_by_clause($param);
            $view = View::make('backend.pertial.json_page_role_assign_default', compact('all_screen_page'));
        }
        
        echo json_encode($view->render());
    }
    
    public function loadDivisionByDistrict(Request $request){
        $table_data = DB::table('districts')
                ->where('div_id', '=', $request->division_id)
                ->orderBy('district_name', 'ASC')
                ->get();
        if ($table_data->first()) {
            $view = View::make('pertial.district_by_division', compact('table_data'));
            echo json_encode($view->render());
        }else{
            $view   =   "<option value=''>select</option>";
            echo json_encode($view);
        } 
    }
    public function loadUpazilaByDistrict(Request $request){
        $table_data = DB::table('upazilas')
                ->where('district_id', '=', $request->district_id)
                ->get();
        if ($table_data->first()) {
            $view = View::make('pertial.upazila_by_district', compact('table_data'));
            echo json_encode($view->render());
        }else{
            $view   =   "<option value=''>select</option>";
            echo json_encode($view);
        } 
    }
    public function loadConstituencyByUpz(Request $request){
        $table_data = DB::table('upazilas')
                ->where('id', '=', $request->upz_id)
                ->get();
        if (!$table_data->isEmpty()) {
            $feedbackdata   =   [
                'status'=>'success',
                'message'=>'Found data',
                'data'=>$table_data->first()->constituency
            ];
        }else {
            $feedbackdata   =   [
                'status'=>'error',
                'message'=>'Found not data',
                'data'=>''
            ];
        } 
        
        echo json_encode($feedbackdata);
    }
    public function loadConstituencyByUnion(Request $request){
        $table_data = DB::table('bd_unions')
                ->where('id', '=', $request->union_id)
                ->get();
        if (!$table_data->isEmpty()) {
            $feedbackdata   =   [
                'status'=>'success',
                'message'=>'Found data',
                'data'=>$table_data->first()->constituency
            ];
        }else {
            $feedbackdata   =   [
                'status'=>'error',
                'message'=>'Found not data',
                'data'=>''
            ];
        } 
        
        echo json_encode($feedbackdata);
    }
    public function loadConstituencyByWard(Request $request){
        $table_data = DB::table('wards')
                ->where('id', '=', $request->ward_id)
                ->get();
        if (!$table_data->isEmpty()) {
            $feedbackdata   =   [
                'status'=>'success',
                'message'=>'Found data',
                'data'=>$table_data->first()->constituency
            ];
        }else {
            $feedbackdata   =   [
                'status'=>'error',
                'message'=>'Found not data',
                'data'=>''
            ];
        } 
        
        echo json_encode($feedbackdata);
    }
    
    public function loadWingByPcDivision(Request $request){
        $table_data = DB::table('wings')
                ->where('pcdivision_id', '=', $request->pcdivision_id)
                ->get();
        if ($table_data->first()) {
            $view = View::make('pertial.wing_by_pcDivision', compact('table_data'));
            echo json_encode($view->render());
        }else{
            $view   =   "<option value=''>select</option>";
            echo json_encode($view);
        } 
    }
    
    public function common_delete(Request $request){
        if($request->table == "projects"){
            $this->do_project_delete_operation($request->id);
        }else{
            DB::table($request->table)->where('id', '=', $request->id)->delete();
        }
        $feedback   =   [
            "status"    => "success",
            "message"   => "Data have been deleted successfully."
        ];
        echo json_encode($feedback);
    }
    
    public function do_project_delete_operation($project_id){       
        // check eny entry will found in projectdocuments table
        $param['table'] = "projectdocuments";
        $param['where'] = [
            'project_id'    =>  $project_id,
            'is_deleted'    =>  0
        ];
        $checkEmpty = check_duplicate_data($param); 
        if($checkEmpty){
            $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        }      
        
        // check eny entry will found in projectshapefiles table
        $param['table'] = "projectshapefiles";
        $checkEmpty = check_duplicate_data($param); 
        if($checkEmpty){
            $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        }
        
        // check eny entry will found in projectcosts table
        $param['table'] = "projectcosts";
        $checkEmpty = check_duplicate_data($param); 
        if($checkEmpty){
            $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        }
        
        // check eny entry will found in projectlocations table
        $param['table'] = "projectlocations";
        $checkEmpty = check_duplicate_data($param); 
        if($checkEmpty){
            $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        }
        
        // check eny entry will found in project_fas table
        $param['table'] = "project_fas";
        $checkEmpty = check_duplicate_data($param); 
        if($checkEmpty){
            $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        }
        
        // check eny entry will found in project_details table
        $param['table'] = "project_details";
        $checkEmpty = check_duplicate_data($param); 
        if($checkEmpty){
            $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        }
        
        // check eny entry will found in projectagencies table
        $param['table'] = "projectagencies";
        $checkEmpty = check_duplicate_data($param); 
        if($checkEmpty){
            $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        }
        
        //update the project_versions
        $param          =   [];
        $param['table'] = "project_versions";
        $param['where'] = [
            'project_id'    =>  $project_id
        ];
        $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        
        //update the project_progress
        $param          =   [];
        $param['table'] = "project_progress";
        $param['where'] = [
            'project_id'    =>  $project_id
        ];
        $this->do_project_is_delete_update($param['table'],$project_id,'project_id');
        
        //finally update the projects
        $param  =   [];
        $param['table'] = "projects";
        $param['where'] = [
            'id'    =>  $project_id
        ];
        $this->do_project_is_delete_update($param['table'],$project_id,'id');
        
        return true;
    }
    
    public function do_project_is_delete_update($tablename, $project_id, $column_name){
        DB::table($tablename)
                ->where($column_name, $project_id)
                ->update([
                    'is_deleted' => 1,
                    'updated_at' => date("Y-m-d h:i:s"),
                    'user_id'       => Auth::user()->id,
                    ]);    
        return true;
    }
    
    function on_page_edit_data(Request $request){
        $table_data = DB::table($request->table)
                ->where('id', '=', $request->id)
                ->get();
        if ($table_data->first()) {
            $feedback   =   [
                "status"    => "success",
                "message"   => "Data have been deleted successfully.",
                "data"   => $table_data->first()
            ];
        }else{        
            $feedback   =   [
                "status"    => "error",
                "message"   => "No data found."
            ];
        }
        echo json_encode($feedback);
    }
    
    function getDivisionByDistrict(Request $request){
        $return =   false;
        $table_data = DB::table('admdivisions as div')
                ->join('districts as dis', 'dis.div_id', '=', 'div.id')
                ->where('dis.id','=',$request->district_id)
                ->select('div.*')
                ->get();

        if ($table_data->first()) {
            $feedback   =   [
                "status"    => "success",
                "message"   => "Data have been deleted successfully.",
                "data"   => $table_data->first()
            ];
        }else{        
            $feedback   =   [
                "status"    => "error",
                "message"   => "No data found."
            ];
        }
        echo json_encode($feedback); 
    }
    public function loadUnionByUpazila(Request $request){
        $table_data = DB::table('bd_unions')
                ->where('upz_id', '=', $request->upz_id)
                ->get();
        if ($table_data->first()) {
            $view = View::make('pertial.union_by_upazila', compact('table_data'));
            echo json_encode($view->render());
        }else{
            $view   =   "<option value=''>select</option>";
            echo json_encode($view);
        } 
    }
    public function loadAgencyByMinstry(Request $request){
        $return =   false;
        $table_data = DB::table('ministries as min')
                ->join('agencies as ag', 'ag.min_id', '=', 'min.id')
                ->where('ag.min_id','=',$request->min_id)
                ->select('ag.*')
                ->get();

        if ($table_data->first()) {
            $view = View::make('pertial.agency_by_minstry', compact('table_data'));
            echo json_encode($view->render());
        }else{
            $view   =   "<option value=''>select</option>";
            echo json_encode($view);
        }
    }
}
