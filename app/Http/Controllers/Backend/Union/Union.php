<?php

namespace App\Http\Controllers\Backend\Union;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Union\UnionModel;
use App\Model\District\DistrictModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use View;
use DB;

class Union extends Controller
{
   public $list_title      =   "Union information";
    public $create_url      =   "admin/union/create";
    public $edit_url        =   "admin/union/edit";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "union";
    
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
        $list_data  = UnionModel::orderBy('bd_union_name', 'ASC')->limit(50)->get();
        return view('backend.union.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.union.create', compact('list_title','list_url','page','active_menu'));
    }
    
     // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'division_id'   => 'required',
            'district_id'   => 'required',
            'upz_id'        => 'required',
            'un_x'         => 'required',
            'un_y'         => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/union/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']        = "bd_unions";
        $checkWhereParam = [
                ['division_id',     '=', $request->division_id],
                ['district_id',     '=', $request->district_id],
                ['upz_id',          '=', $request->upz_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/union/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   UnionModel::create([
            'division_id'       =>  $request->division_id,
            'district_id'       =>  $request->district_id,
            'upz_id'            =>  $request->upz_id,
            'bd_union_name'     =>  $request->bd_union_name,
            'un_x'             =>  $request->un_x,
            'un_y'             =>  $request->un_y,
            'constituent'      =>  $request->constituent,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/union')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/union/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data              = UnionModel::where('id', $id)->first();
        $division_selected_id   = DistrictModel::where('id', $edit_data->district_id)->first();
        $list_title             =   $this->list_title;
        $list_url               =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page                   =   "Create";
        return view('backend.union.edit', compact('list_title','list_url','page','edit_data','division_selected_id','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'division_id'   => 'required',
            'district_id'   => 'required',
            'upz_id'        => 'required',
            'bd_union_name' => 'required',
            'un_x'         => 'required',
            'un_y'         => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/union/edit/' . $request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']        = "bd_unions";
        $checkWhereParam = [
                ['division_id',     '=', $request->division_id],
                ['district_id',     '=', $request->district_id],
                ['upz_id',          '=', $request->upz_id],
                ['bd_union_name',   '=', $request->bd_union_name],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/union/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $unions = UnionModel::find($request->edit_id);
        $result = $unions->update([
            'division_id'       =>  $request->division_id,
            'district_id'       =>  $request->district_id,
            'upz_id'            =>  $request->upz_id,
            'bd_union_name'     =>  $request->bd_union_name,
            'un_x'              =>  $request->un_x,
            'un_y'              =>  $request->un_y,
            'constituent'       =>  $request->constituent,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        return redirect('admin/union')
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
        $file = public_path('csv/unions_geocode.csv');

        $insertData = $this->csvToArray($file);
        foreach($insertData as $data) {
            //unions_ID; Upz_geocode; distr_ID; Upazilla; bn_name; DS_X;DS_Y; Number; Constituency ;Isdelete; UserID;
            UnionModel::create([
                'id' => $data[0],
                'district_id' => $data[2],
                'unions_name' => $data[3],
                'unions_name_bn' => $data[4],
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
    
    public function searchUnion(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu = $this->active_menu;
        $page = "List";
        //$request_all    =   $request->all();
        $query = UnionModel::orderBy('bd_unions.id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {
            $q  =   DB::table('bd_unions');
            $q->select('bd_unions.id as id','bd_unions.division_id','bd_unions.district_id','bd_unions.upz_id','bd_unions.bd_union_name','bd_unions.un_x','bd_unions.un_y','bd_unions.constituent','bd_unions.is_deleted','bd_unions.user_id');
            if (isset($request->dis_id) && !empty($request->dis_id)) {
                $q->where('district_id', '=', $request->dis_id);
            }

            if (isset($request->bd_union_name) && !empty($request->bd_union_name)) {
                $q->where('bd_union_name', 'like', '%' . $request->bd_union_name . '%');
            }
            
            if (isset($request->upz_id) && !empty($request->upz_id)) {
                $q->where('upz_id', '=', $request->upz_id);
            }
            if (isset($request->div_id) && !empty($request->div_id)) {
                $q->where('division_id', '=', $request->div_id);
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
            $search_data = View::make('backend.search.union_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }

}
