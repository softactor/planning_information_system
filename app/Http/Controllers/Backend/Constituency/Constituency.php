<?php

namespace App\Http\Controllers\Backend\Constituency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Commonconf\CommonconfModel;
use Illuminate\Support\Facades\Auth;
use Validator;
use View;

class Constituency extends Controller{
    
    public $list_title      =   "Common configuration information";
    public $create_url      =   "admin/commonconf/create";
    public $edit_url        =   "admin/commonconf/edit";
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
        $list_data  = CommonconfModel::orderBy('id', 'DESC')->get();
        return view('backend.commonconf.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.commonconf.create', compact('list_title','list_url','page','active_menu'));
    }
    
    // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'commonconf_name' => 'required',
            'commonconf_type' => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/commonconf/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "commonconfs";
        $checkWhereParam = [
                ['commonconf_name', '=', $request->commonconf_name],
                ['commonconf_type', '=', $request->commonconf_type],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/commonconf/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   CommonconfModel::create([
            'commonconf_name'   =>  $request->commonconf_name,
            'commonconf_type'   =>  $request->commonconf_type,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/commonconf')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/commonconf/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = CommonconfModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.commonconf.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'commonconf_name' => 'required',
            'commonconf_type' => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/commonconf/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "commonconfs";
        $checkWhereParam = [
                ['commonconf_name', '=', $request->commonconf_name],
                ['commonconf_type', '=', $request->commonconf_type],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/commonconf/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $commonconf = CommonconfModel::find($request->edit_id);
        $commonconf->update([
            'commonconf_name'   => trim($request->get('commonconf_name')),
            'commonconf_type'   => $request->get('commonconf_type'),
            'user_id'           => Auth::user()->id,
        ]);
        return redirect('admin/commonconf')
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
        $file = public_path('csv/commonconf.csv');

        $insertData = $this->csvToArray($file);
        foreach($insertData as $data) {
            CommonconfModel::create([
                'commonconf_name'                 => $data[1],
                'commonconf_type'                 => $data[2],
                'is_deleted'                    => $data[3],
                'user_id'                       => $data[4]
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
    public function searchCommonconf(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query  = CommonconfModel::orderBy('id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {

            if (isset($request->commonconf_name) && !empty($request->commonconf_name)) {
                $query->where('commonconf_name', 'like', '%' . $request->commonconf_name . '%');
            }

            if (isset($request->commonconf_type) && !empty($request->commonconf_type)) {
                $query->where('commonconf_type', '=', $request->commonconf_type);
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
            $search_data = View::make('backend.search.commonconf_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
