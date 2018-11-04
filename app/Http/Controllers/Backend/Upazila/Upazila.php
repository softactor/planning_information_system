<?php

namespace App\Http\Controllers\Backend\Upazila;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Upazila\UpazilaModel;
use App\Model\District\DistrictModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use View;
use DB;

class Upazila extends Controller
{
   public $list_title      =   "Upazila information";
    public $create_url      =   "admin/upazila/create";
    public $edit_url        =   "admin/upazila/edit";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "location";
    
    public function __construct() {
    
    }
    
    public function index(){
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url      =   $this->list_url;
        $edit_url       =   $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page           =   "List";
        // get all table data:
        $list_data  = UpazilaModel::orderBy('upazila_name', 'ASC')->get();
        return view('backend.upazila.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.upazila.create', compact('list_title','list_url','page','active_menu'));
    }
    
     // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'div_id'        => 'required',
            'district_id'   => 'required',
            'upazila_name'  => 'required',
            'geo_code'      => 'required',
            'upz_x'         => 'required',
            'upz_y'         => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/upazila/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']        = "upazilas";
        $checkWhereParam = [
                ['district_id',     '=', $request->district_id],
                ['upazila_name',    '=', $request->upazila_name],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/upazila/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   UpazilaModel::create([
            'div_id'            =>  $request->div_id,
            'district_id'       =>  $request->district_id,
            'upazila_name'      =>  $request->upazila_name,
            'geo_code'          =>  $request->geo_code,
            'upz_x'             =>  $request->upz_x,
            'upz_y'             =>  $request->upz_y,
            'constituency'      =>  $request->constituency,
            'upazila_name_bn'   =>  $request->upazila_name_bn,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/upazila')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/upazila/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data              = UpazilaModel::where('id', $id)->first();
        $division_selected_id   = DistrictModel::where('id', $edit_data->district_id)->first();
        $list_title             =   $this->list_title;
        $list_url               =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page                   =   "Create";
        return view('backend.upazila.edit', compact('list_title','list_url','page','edit_data','division_selected_id','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'div_id'        => 'required',
            'district_id'   => 'required',
            'upazila_name'  => 'required',
            'geo_code'      => 'required',
            'upz_x'         => 'required',
            'upz_y'         => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/upazila/edit/' . $request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']        = "upazilas";
        $checkWhereParam = [
                ['district_id',     '=', $request->district_id],
                ['upazila_name',    '=', $request->upazila_name],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/upazila/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $upazila = UpazilaModel::find($request->edit_id);
        $upazila->update([
            'div_id'            =>  $request->div_id,
            'district_id'       =>  $request->district_id,
            'upazila_name'      =>  $request->upazila_name,
            'geo_code'          =>  $request->geo_code,
            'upz_x'             =>  $request->upz_x,
            'upz_y'             =>  $request->upz_y,
            'constituency'      =>  $request->constituency,
            'upazila_name_bn'   =>  $request->upazila_name_bn,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        return redirect('admin/upazila')
                        ->with('success', 'Data have saved updated.');
    }
    
    public function csvToArray($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        $count  =   1;
        if (($handle = fopen($filename, 'r')) !== false) {
            while ($row = fgetcsv($handle)) {
                if($count==1){
                    $count++;
                    continue;
                }
                //$str = explode(',',str_replace(';', ',', $row[0]));
                
                $data[]     =     $row;
                
            }
            fclose($handle);
        }

        return $data;
    } // end of method
    
    public function csv_upload() {
        $file = public_path('csv/upazila_geocode.csv');

        $insertData = $this->csvToArray($file);
        foreach($insertData as $data) {
            //upazila_ID; Upz_geocode; distr_ID; Upazilla; bn_name; DS_X;DS_Y; Number; Constituency ;Isdelete; UserID;
            UpazilaModel::create([
                'id' => $data[0],
                'district_id' => $data[2],
                'upazila_name' => $data[3],
                'upazila_name_bn' => $data[4],
                'upz_x' => $data[5],
                'upz_y' => $data[6],
                'geo_code' => $data[1],
                'constituency' => $data[8],
                'is_deleted' => 0,
                'user_id' => 1
            ]);
        }// end of foreach
        exit;
    }// end of method;
    
    public function csvCorrection(){
        
        $rowData            =   DB::table('org_quest_survey')->offset(0)->limit(400)->get();
        $location_types     =   DB::table('business_types')->get();
        print '<pre>';
        dd($location_types);
        exit;
        $dataObj            =   'location_type';
        $mappingObj         =   'name';
        
        $updatecount    =   1;
        
        foreach($rowData as $data){
            $response_data  =   $this->csvdatamapping($data, $location_types, $dataObj, $mappingObj);
            DB::table('org_quest_survey')
            ->where('id', $data->id)
            ->update([$dataObj => $response_data->$dataObj]);
            
            $updatecount++;
            $last_id    =   $data->id;
        }
        
        echo "<h1>Total Update Row: ".$updatecount." Last ID:". $last_id."</h1>";
    }
    
    public function csvdatamapping($csvData, $mappingData, $dataObj, $mappingObj){
        foreach($mappingData as $mapping){
            if(strtolower($mapping->$mappingObj) == strtolower($csvData->$dataObj)){
                $csvData->$dataObj     =    $mapping->id;
            }           
        }
        
        return $csvData;
    } 
    
    public function searchUpazila(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu = $this->active_menu;
        $page = "List";
        //$request_all    =   $request->all();
        $query = UpazilaModel::orderBy('upazilas.id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {
            $q  =   DB::table('upazilas');
            $q->select('upazilas.id as id','upazilas.district_id','upazilas.upazila_name','upazilas.upazila_name_bn','upazilas.geo_code','upazilas.upz_x','upazilas.upz_y','upazilas.constituency','upazilas.is_deleted','upazilas.user_id');
            if (isset($request->dis_id) && !empty($request->dis_id)) {
                $q->where('district_id', '=', $request->dis_id);
            }

            if (isset($request->upazila_name) && !empty($request->upazila_name)) {
                $q->where('upazila_name', 'like', '%' . $request->upazila_name . '%');
            }
            
            if (isset($request->div_id) && !empty($request->div_id)) {
                $q->join('districts', function ($join) {
                    $join->on('districts.id', '=', 'upazilas.district_id');
                });
                
                $q->where('districts.div_id', '=', $request->div_id);
            }
            
            $list_data = $q->get();
        }
        if ($list_data->isEmpty()) {
            $feedback_data = [
                'status' => 'error',
                'message' => 'Data Not Found',
                'data' => ''
            ];
        } else {
            $search_data = View::make('backend.search.upazila_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }

}
