<?php

namespace App\Http\Controllers\Backend\District;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\District\DistrictModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use View;

class District extends Controller {

    public $list_title = "District information";
    public $create_url = "admin/district/create";
    public $edit_url = "admin/district/edit";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "location";

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
        $list_data  = DistrictModel::orderBy('district_name', 'ASC')->get();
        return view('backend.district.list', compact('list_title', 'create_url', 'edit_url', 'list_url', 'page','list_data','active_menu'));
    }

    public function create() {
        $list_title = $this->list_title;
        $list_url = $this->list_url;
        $active_menu    =   $this->active_menu;
        $page = "Create";
        return view('backend.district.create', compact('list_title', 'list_url', 'page','active_menu'));
    }
    
    // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'div_id'        => 'required',
            'district_name' => 'required',
            'geo_code'      => 'required',
            'dv_x'          => 'required',
            'dv_y'          => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/district/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']         = "districts";
        $checkWhereParam = [
                ['div_id',          '=', $request->div_id],
                ['district_name',   '=', $request->district_name],
        ];
        $checkParam['where']        = $checkWhereParam;
        $duplicateCheck             = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/district/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   DistrictModel::create([
            'div_id'            =>  $request->div_id,
            'district_name'     =>  $request->district_name,
            'geo_code'          =>  $request->geo_code,
            'district_bn'       =>  $request->district_bn,
            'ds_x'              =>  $request->dv_x,
            'ds_y'              =>  $request->dv_y,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/district')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/district/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = DistrictModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.district.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'div_id'        => 'required',
            'district_name' => 'required',
            'geo_code'      => 'required',
            'ds_x'          => 'required',
            'ds_y'          => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/district/edit/' . $request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']         = "districts";
        $checkWhereParam = [
                ['div_id',          '=', $request->div_id],
                ['district_name',   '=', $request->district_name],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/district/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $district = DistrictModel::find($request->edit_id);
        $district->update([
            'div_id'            =>  $request->div_id,
            'district_name'     =>  $request->district_name,
            'geo_code'          =>  $request->geo_code,
            'district_bn'       =>  $request->district_bn,
            'ds_x'              =>  $request->dv_x,
            'ds_y'              =>  $request->dv_y,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        return redirect('admin/district')
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
        $file = public_path('csv/districts.csv');

        $insertData = $this->csvToArray($file);
        foreach ($insertData as $data) {
            DistrictModel::create([
                'div_id' => $data[1],
                'district_name' => $data[2],
                'district_bn' => $data[3],
                'ds_x' => $data[4],
                'ds_y' => $data[5],
                'geo_code' => '',
                'is_deleted' => $data[6],
                'user_id' => $data[7]
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
    
    public function searchDistrict(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query  = DistrictModel::orderBy('id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {

            if (isset($request->div_id) && !empty($request->div_id)) {
                $query->where('div_id', '=', $request->div_id);
            }

            if (isset($request->geo_code) && !empty($request->geo_code)) {
                $query->where('geo_code', 'like', '%' . $request->geo_code . '%');
            }
            if (isset($request->district_name) && !empty($request->district_name)) {
                $query->where('district_name', 'like', '%' . $request->district_name . '%');
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
            $search_data = View::make('backend.search.district_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
