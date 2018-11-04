<?php

namespace App\Http\Controllers\Backend\Agency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Agency\AgencyModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use View;

class Agency extends Controller
{
    public $list_title      =   "Agency information";
    public $create_url      =   "admin/agency/create";
    public $edit_url        =   "admin/agency/edit";
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
        $list_data  = AgencyModel::orderBy('agency_name', 'ASC')->get();
        
        return view('backend.agency.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.agency.create', compact('list_title','list_url','page','active_menu'));
    }
    // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'ministry_id'         => 'required',
            'agency_name'         => 'required',
            'agency_short_name'   => 'required',
            'agency_code'         => 'max:3',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/agency/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "agencies";
        $checkWhereParam = [
                ['min_id',         '=', $request->ministry_id],
                ['agency_name',         '=', $request->agency_name],
                ['agency_short_name',   '=', $request->agency_short_name],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/agency/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   AgencyModel::create([
            'min_id'                =>  (($request->ministry_id) ? $request->ministry_id: 0),
            'agency_code'           =>  (($request->agency_code) ? $request->agency_code: 0),
            'agency_name'           =>  $request->agency_name,
            'agency_name_bn'        =>  $request->agency_name_bn,
            'agency_short_name'     =>  $request->agency_short_name,
            'is_deleted'            =>  0,
            'user_id'               =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/agency')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/agency/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = AgencyModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.agency.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'ministry_id'         => 'required',
            'agency_name'         => 'required',
            'agency_short_name'   => 'required',
            'agency_code'         => 'max:3',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/agency/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "agencies";
        $checkWhereParam = [
                ['min_id',         '=', $request->ministry_id],
                ['agency_name',         '=', $request->agency_name],
                ['agency_short_name',   '=', $request->agency_short_name],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/agency/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $commonconf = AgencyModel::find($request->edit_id);
        $commonconf->update([
            'min_id'           =>  (($request->ministry_id) ? $request->ministry_id: 0),
            'agency_code'           =>  (($request->agency_code) ? $request->agency_code: 0),
            'agency_name'           =>  $request->agency_name,
            'agency_name_bn'        =>  $request->agency_name_bn,
            'agency_short_name'     =>  $request->agency_short_name,
            'is_deleted'            =>  0,
            'user_id'               => Auth::user()->id,
        ]);
        return redirect('admin/agency')
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
        $file = public_path('csv/Agency_information.csv');

        $insertData = $this->csvToArray($file);
        foreach($insertData as $data) {
            AgencyModel::create([
                'agency_code'                   => $data[0],
                'agency_name'                   => trim($data[1]),
                'agency_name_bn'                => trim($data[2]),
                'agency_short_name'             => trim($data[3]),
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
    
    public function searchAgency(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query  = AgencyModel::orderBy('id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {

            if (isset($request->agency_name) && !empty($request->agency_name)) {
                $query->where('agency_name', 'like', '%' . $request->agency_name . '%');
            }

            if (isset($request->agency_short_name) && !empty($request->agency_short_name)) {
                $query->where('agency_short_name', 'like', '%' . $request->agency_short_name . '%');
            }
            if (isset($request->agency_code) && !empty($request->agency_code)) {
                $query->where('agency_code', 'like', '%' . $request->agency_short_name . '%');
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
            $search_data = View::make('backend.search.agency_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
