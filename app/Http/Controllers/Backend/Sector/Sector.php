<?php

namespace App\Http\Controllers\Backend\Sector;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sector\SectorModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Sector extends Controller
{
    public $list_title      =   "Sector information";
    public $create_url      =   "admin/sector/create";
    public $edit_url        =   "admin/sector/edit";
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
        $list_data  = SectorModel::orderBy('sector_name', 'ASC')->get();
        return view('backend.sector.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.sector.create', compact('list_title','list_url','page','active_menu'));
    }
     // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'sector_name' => 'required'
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/sector/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "sectors";
        $checkWhereParam = [
                ['sector_name', '=', $request->sector_name]
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/sector/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   SectorModel::create([
            'sector_name'       =>  $request->sector_name,
            'sector_name_bn'    =>  $request->sector_name_bn,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/sector')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/sector/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = SectorModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.sector.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'sector_name' => 'required'
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/sector/edit/' . $request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "sectors";
        $checkWhereParam = [
                ['sector_name', '=', $request->sector_name]
        ];
        $checkParam['where']    = $checkWhereParam;
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/sector/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $commonconf = SectorModel::find($request->edit_id);
        $commonconf->update([
            'sector_name'       =>  $request->sector_name,
            'sector_name_bn'    =>  $request->sector_name_bn,
            'user_id'           => Auth::user()->id,
        ]);
        return redirect('admin/sector')
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
        $file = public_path('csv/Sectors.csv');

        $insertData = $this->csvToArray($file);
        foreach($insertData as $data) {
            SectorModel::create([
                'sector_name'                 => $data[1],
                'sector_name_bn'                 => trim($data[2]),
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
}
