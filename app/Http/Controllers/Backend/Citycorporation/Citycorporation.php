<?php

namespace App\Http\Controllers\Backend\Citycorporation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Citycorporation\CitycorporationModel;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use View;

class Citycorporation extends Controller
{
    public $list_title      =   "City corporation information";
    public $create_url      =   "admin/citycorporation/create";
    public $edit_url        =   "admin/citycorporation/edit";
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
        $list_data  = CitycorporationModel::orderBy('citycorp_name', 'ASC')->get();
        return view('backend.citycorporation.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.citycorporation.create', compact('list_title','list_url','page','active_menu'));
    }
    // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'div_id'        => 'required',
            'citycorp_name' => 'required',
            'citycorp_x'    => 'required',
            'citycorp_y'    => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/citycorporation/create')
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
            return redirect('admin/citycorporation/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $max_id = CitycorporationModel::find(DB::table('citycorporations')->max('id'));
        
        $response   =   CitycorporationModel::create([
            'id'                => $max_id->id+1,
            'div_id'            => $request->div_id,
            'citycorp_name'     => $request->citycorp_name,
            'citycorp_name_bn'  => $request->citycorp_name_bn,
            'citycorp_x'        => $request->citycorp_x,
            'citycorp_y'        => $request->citycorp_y,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        
        if($response){
            return redirect('admin/citycorporation')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/citycorporation/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = CitycorporationModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.citycorporation.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'div_id'        => 'required',
            'citycorp_name' => 'required',
            'citycorp_x'    => 'required',
            'citycorp_y'    => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/citycorporation/edit/' . $request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to Update Item!');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "citycorporations";
        $checkWhereParam = [
                ['div_id',          '=', $request->div_id],
                ['citycorp_name',   '=', $request->citycorp_name],
                ['citycorp_x',      '=', $request->citycorp_x],
                ['citycorp_y',      '=', $request->citycorp_y],
                ['id',              '!=',$request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/citycorporation/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $commonconf = CitycorporationModel::find($request->edit_id);
        $commonconf->update([
            'div_id'            => $request->div_id,
            'citycorp_name'     => $request->citycorp_name,
            'citycorp_name_bn'  => $request->citycorp_name_bn,
            'citycorp_x'        => $request->citycorp_x,
            'citycorp_y'        => $request->citycorp_y,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        return redirect('admin/citycorporation/edit/' . $request->edit_id)
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
        $file = public_path('csv/citycorp.csv');

        $insertData = $this->csvToArray($file);
        foreach($insertData as $data) {
            CitycorporationModel::create([
                'id'                 => $data[0],
                'div_id'             => $data[1],
                'citycorp_name'      => $data[2],
                'citycorp_name_bn'   => $data[3],
                'citycorp_x'         => "",
                'citycorp_y'         => "",
                'is_deleted'         => $data[6],
                'user_id'            => $data[7]
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
    
    public function searchCitycorporation(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query  = CitycorporationModel::orderBy('id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {

            if (isset($request->div_id) && !empty($request->div_id)) {
                $query->where('div_id', '=', $request->div_id);
            }
            if (isset($request->citycorp_name) && !empty($request->citycorp_name)) {
                $query->where('citycorp_name', 'like', '%' . $request->citycorp_name . '%');
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
            $search_data = View::make('backend.search.citycorporation_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
