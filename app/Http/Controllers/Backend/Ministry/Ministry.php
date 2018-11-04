<?php

namespace App\Http\Controllers\Backend\Ministry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Ministry\MinistryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use View;

class Ministry extends Controller{
    
    public $list_title      =   "Ministry/Division information";
    public $create_url      =   "admin/ministry/create";
    public $edit_url        =   "admin/ministry/edit";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "setup";
    
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
        $list_data  = MinistryModel::orderBy('ministry_name', 'ASC')->get();
        
        return view('backend.ministry.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.ministry.create', compact('list_title','list_url','page','active_menu'));
    }
    // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'ministry_name'         => 'required',
            'ministry_short_name'   => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/ministry/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "ministries";
        $checkWhereParam = [
                ['ministry_name',       '=', $request->ministry_name],
                ['ministry_short_name', '=', $request->ministry_short_name],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/ministry/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   MinistryModel::create([
            'ministry_name'         =>  $request->ministry_name,
            'ministry_name_bn'      =>  $request->ministry_name_bn,
            'ministry_short_name'   =>  $request->ministry_short_name,
            'ministry_code'         =>  $request->ministry_code,
            'is_deleted'            =>  0,
            'user_id'               =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/ministry')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/ministry/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = MinistryModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.ministry.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'ministry_name'         => 'required',
            'ministry_short_name'   => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/ministry/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "ministries";
        $checkWhereParam = [
                ['ministry_name',       '=', $request->ministry_name],
                ['ministry_short_name', '=', $request->ministry_short_name],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/ministry/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $commonconf = MinistryModel::find($request->edit_id);
        $commonconf->update([
            'ministry_name'         =>  $request->ministry_name,
            'ministry_name_bn'      =>  $request->ministry_name_bn,
            'ministry_short_name'   =>  $request->ministry_short_name,
            'ministry_code'         =>  $request->ministry_code,
            'is_deleted'            =>  0,
            'user_id'           => Auth::user()->id,
        ]);
        return redirect('admin/ministry')
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
                $data[]     =     $row;
                
            }
            fclose($handle);
        }

        return $data;
    } // end of method
    
    public function csv_upload() {
        $file = public_path('csv/ministry_information.csv');

        $insertData = $this->csvToArray($file);
        foreach($insertData as $data) {
            MinistryModel::create([
                'ministry_code'                 => $data[0],
                'ministry_name'                 => trim($data[1]),
                'ministry_name_bn'              => trim($data[2]),
                'ministry_short_name_bn'        => trim($data[3]),
                'is_deleted'                    => $data[4],
                'user_id'                       => $data[5]
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
    
    public function searchMinistry(Request $request) {
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url      =   $this->list_url;
        $edit_url       =   $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page           =   "List";
        // get all table data:
        $query  = MinistryModel::orderBy('id', 'DESC');
        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {
            if (isset($request->ministry_code) && !empty($request->ministry_code)) {
                $query->where('ministry_code', '=', $request->ministry_code);
            }

            if (isset($request->ministry_name) && !empty($request->ministry_name)) {
                $query->where('ministry_name',  'like', '%' .$request->ministry_name . '%');
            }
            
            if (isset($request->ministry_short_name) && !empty($request->ministry_short_name)) {
                $query->where('ministry_short_name', 'like', '%' . $request->ministry_short_name . '%');
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
            $search_data = View::make('backend.search.ministry_search_list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
