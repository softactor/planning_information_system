<?php

namespace App\Http\Controllers\Backend\Constituency;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Constituency\ConstituencyModel;
use Illuminate\Support\Facades\Auth;
use Validator;
use View;

class Constituency extends Controller{
    
    public $list_title      =   "Constituency";
    public $create_url      =   "admin/constituency/create";
    public $edit_url        =   "admin/constituency/edit";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "setup";
    
    public function __construct() {
    
    }
    
    public function index(){
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page           =   "List";
        // get all table data:
        $list_data  = ConstituencyModel::orderBy('id', 'DESC')->get();
        return view('backend.constituency.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.constituency.create', compact('list_title','list_url','page','active_menu'));
    }
    
    // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'const_id'  => 'required',
            'name'      => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/constituency/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "constituency";
        $checkWhereParam = [
                ['const_id', '=', $request->const_id],
                ['name', '=', $request->name],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/constituency/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   ConstituencyModel::create([
            'const_id'   =>  $request->const_id,
            'name'       =>  $request->name,
            'latitude'   =>  $request->latitude,
            'longitude'  =>  $request->longitude
        ]);
        if($response){
            return redirect('admin/constituency')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/constituency/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = ConstituencyModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.constituency.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'const_id'  => 'required',
            'name'      => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/constituency/edit/'.$request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to Update data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "constituency";
        $checkWhereParam = [
                ['const_id',    '=', $request->const_id],
                ['name',        '=', $request->name],
                ['id',          '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/constituency/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $commonconf = ConstituencyModel::find($request->edit_id);
        $commonconf->update([
            'const_id'      => trim($request->get('const_id')),
            'latitude'      =>  $request->latitude,
            'longitude'     =>  $request->longitude,
            'name'          => trim($request->get('name'))
        ]);
        return redirect('admin/constituency')
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
        $file           = public_path('csv/const_areas.csv');
        $insertData     = $this->csvToArray($file);
        foreach($insertData as $data) {
            ConstituencyModel::create([
                'const_id'  => $data[0],
                'name'      => $data[1]
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
    public function searchConstituency(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query  = ConstituencyModel::orderBy('id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {

            if (isset($request->const_id) && !empty($request->const_id)) {
                $query->where('const_id', 'like', '%' . $request->const_id . '%');
            }

            if (isset($request->name) && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
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
            $search_data = View::make('backend.search.constituency_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
