<?php

namespace App\Http\Controllers\Backend\Subsector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Subsector\SubsectorModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use View;

class Subsector extends Controller {

    public $list_title = "Sub-sector information";
    public $create_url = "admin/subsector/create";
    public $edit_url = "admin/subsector/edit";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "setup";

    public function __construct() {
        
    }

    public function index() {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $list_data  = SubsectorModel::orderBy('subsector_name', 'ASC')->get();
        
        return view('backend.subsector.list', compact('list_title', 'create_url', 'edit_url', 'list_url', 'page','list_data','active_menu'));
    }

    public function create() {
        $list_title = $this->list_title;
        $list_url = $this->list_url;
        $active_menu    =   $this->active_menu;
        $page = "Create";
        return view('backend.subsector.create', compact('list_title', 'list_url', 'page','active_menu'));
    }
    
     // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'sector_id' => 'required',
            'subsector_name' => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/subsector/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "subsectors";
        $checkWhereParam = [
                ['sector_id',       '=', $request->sector_id],
                ['subsector_name',  '=', $request->subsector_name],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/subsector/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   SubsectorModel::create([
            'sector_id'   =>  $request->sector_id,
            'subsector_name'   =>  $request->subsector_name,
            'subsector_name_bn'   =>  $request->subsector_name_bn,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/subsector')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/subsector/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = SubsectorModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.subsector.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'sector_id' => 'required',
            'subsector_name' => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/subsector/edit/' . $request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "subsectors";
        $checkWhereParam = [
                ['sector_id',       '=', $request->sector_id],
                ['subsector_name',  '=', $request->subsector_name],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/subsector/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $commonconf = SubsectorModel::find($request->edit_id);
        $commonconf->update([
            'sector_id'   =>  $request->sector_id,
            'subsector_name'   =>  $request->subsector_name,
            'subsector_name_bn'   =>  $request->subsector_name_bn,
            'user_id'           => Auth::user()->id,
        ]);
        return redirect('admin/subsector')
                        ->with('success', 'Data have saved updated.');
    }

    public function csvToArray($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        $count = 1;
        if (($handle = fopen($filename, 'r')) !== false) {
            while ($row = fgetcsv($handle)) {
                if ($count == 1) {
                    $count++;
                    continue;
                }
                $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }

// end of method

    public function csv_upload() {
        $file = public_path('csv/subsectors.csv');

        $insertData = $this->csvToArray($file);
        foreach ($insertData as $data) {
            SubsectorModel::create([
                'sector_id'         => $data[1],
                'subsector_name'    => $data[2],
                'subsector_name_bn' => $data[3],
                'is_deleted'        => $data[4],
                'user_id'           => $data[5]
            ]);
        }// end of foreach
        exit;
    }

// end of method;

    public function csvCorrection() {

        $rowData = DB::table('org_quest_survey')->offset(0)->limit(400)->get();
        $location_types = DB::table('business_types')->get();
        print '<pre>';
        dd($location_types);
        exit;
        $dataObj = 'location_type';
        $mappingObj = 'name';

        $updatecount = 1;

        foreach ($rowData as $data) {
            $response_data = $this->csvdatamapping($data, $location_types, $dataObj, $mappingObj);
            DB::table('org_quest_survey')
                    ->where('id', $data->id)
                    ->update([$dataObj => $response_data->$dataObj]);

            $updatecount++;
            $last_id = $data->id;
        }

        echo "<h1>Total Update Row: " . $updatecount . " Last ID:" . $last_id . "</h1>";
    }

    public function csvdatamapping($csvData, $mappingData, $dataObj, $mappingObj) {
        foreach ($mappingData as $mapping) {
            if (strtolower($mapping->$mappingObj) == strtolower($csvData->$dataObj)) {
                $csvData->$dataObj = $mapping->id;
            }
        }

        return $csvData;
    }
    
    public function searchSubsector(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query  = SubsectorModel::orderBy('id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {

            if (isset($request->sector_id) && !empty($request->sector_id)) {
                $query->where('sector_id', '=', $request->sector_id);
            }

            if (isset($request->subsector_name) && !empty($request->subsector_name)) {
                $query->where('subsector_name', 'like', '%' . $request->subsector_name . '%');
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
            $search_data = View::make('backend.search.subsector_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
    
}
