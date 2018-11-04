<?php

namespace App\Http\Controllers\Backend\Ward;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Ward\WardModel;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use View;

class Ward extends Controller
{
    public $list_title      =   "Ward information";
    public $create_url      =   "admin/ward/create";
    public $edit_url        =   "admin/ward/edit";
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
        $list_data  = WardModel::all();
        return view('backend.ward.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.ward.create', compact('list_title','list_url','page','active_menu'));
    }
    
     // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'citycorp_id'   => 'required',
            'ward_nr'     => 'required',
            'ward_x'        => 'required',
            'ward_y'        => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/ward/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "wards";
        $checkWhereParam = [
                ['citycorp_id', '=', $request->citycorp_id],
                ['ward_nr',   '=', $request->ward_nr],
                ['ward_x',      '=', $request->ward_x],
                ['ward_y',      '=', $request->commonconf_type],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/ward/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $max_id = WardModel::find(DB::table('wards')->max('id'));
        $response           =   WardModel::create([
            'id'            => $max_id->id+1,
            'citycorp_id'   =>  $request->citycorp_id,
            'ward_nr'     =>  $request->ward_nr,
            'ward_x'        =>  $request->ward_x,
            'ward_y'        =>  $request->ward_y,
            'constituency'  =>  $request->constituency,
            'is_deleted'    =>  0,
            'user_id'       =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/ward')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/ward/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = WardModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.ward.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'citycorp_id'   => 'required',
            'ward_nr'     => 'required',
            'ward_x'        => 'required',
            'ward_y'        => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/ward/edit/' . $request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "wards";
        $checkWhereParam = [
                ['citycorp_id', '=', $request->citycorp_id],
                ['ward_nr',   '=', $request->ward_nr],
                ['ward_x',      '=', $request->ward_x],
                ['ward_y',      '=', $request->commonconf_type],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/ward/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $commonconf = WardModel::find($request->edit_id);
        $commonconf->update([
            'citycorp_id'   =>  $request->citycorp_id,
            'ward_nr'     =>  $request->ward_nr,
            'ward_x'        =>  $request->ward_x,
            'ward_y'        =>  $request->ward_y,
            'constituency'      =>  $request->constituency,
            'is_deleted'    =>  0,
            'user_id'       =>  Auth::user()->id,
        ]);
        return redirect('admin/ward/edit/' . $request->edit_id)
                        ->with('success', 'Data have updated.');
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
                $data[]     =     $row;
                
            }
            fclose($handle);
        }

        return $data;
    } // end of method
    
    public function csv_upload() {
        $file = public_path('csv/ward.csv');

        $insertData = $this->csvToArray($file);
        foreach($insertData as $data) {
            WardModel::create([
                'id'                 => $data[0],
                'citycorp_id'             => $data[1],
                'ward_nr'      => $data[2],
                'ward_x'         => $data[3],
                'ward_y'         => $data[4],
                'geo_code'         => "",
                'is_deleted'         => 0,
                'user_id'            => 1
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
    public function searchWard(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query  = WardModel::orderBy('id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {

            if (isset($request->citycorp_id) && !empty($request->citycorp_id)) {
                $query->where('citycorp_id', '=', $request->citycorp_id);
            }
            if (isset($request->ward_nr) && !empty($request->ward_nr)) {
                $query->where('ward_nr', 'like', '%' . $request->ward_nr . '%');
            }
            
            $list_data = $query->get();
        }
        if ($list_data->isEmpty()) {
            $feedback_data = [
                'status' => 'error',
                'message' => 'Data Not Found',
                'data' => ''
            ];
        } else {
            $search_data = View::make('backend.search.ward_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
