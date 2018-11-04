<?php

namespace App\Http\Controllers\Backend\Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Area\AreaModel;
use App\Model\Division\DivisionModel;
use App\Model\Upazila\UpazilaModel;
use App\Model\District\DistrictModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Area extends Controller
{
    public $list_title      =   "Area";
    public $create_url      =   "admin/area/create";
    public $edit_url        =   "admin/area/edit";
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
        $list_data  = AreaModel::orderBy('id', 'DESC')->get();
        return view('backend.area.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.area.create', compact('list_title','list_url','page','active_menu'));
    }
    // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'div_id'        => 'required',
            'district_id'   => 'required',
            'upz_id'        => 'required',
            'area_name'     => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/area/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']    = "areas";
        $checkWhereParam = [
                ['upz_id',      '=', $request->upz_id],
                ['area_name',   '=', $request->area_name],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/area/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   AreaModel::create([
            'upz_id'   =>  $request->upz_id,
            'area_name'   =>  $request->area_name,
            'area_name_bn'   =>  $request->area_name_bn,
            'geo_code'   =>  $request->geo_code,
            'area_x'   =>  $request->area_x,
            'area_y'   =>  $request->area_y,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/area')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/area/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data  = AreaModel::where('id', $id)->first();
        $district_selected_id   = UpazilaModel::where('id', $edit_data->upz_id)->first()->district_id;
        $division_selected_id   = DistrictModel::where('id', $district_selected_id)->first()->div_id;
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.area.edit', compact('list_title','list_url','page','edit_data','division_selected_id','district_selected_id','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'div_id'        => 'required',
            'district_id'   => 'required',
            'upz_id'        => 'required',
            'area_name'     => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/area/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']    = "areas";
        $checkWhereParam = [
                ['upz_id',      '=', $request->upz_id],
                ['area_name',   '=', $request->area_name],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/area/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $area = AreaModel::find($request->edit_id);
        $area->update([
            'upz_id'   =>  $request->upz_id,
            'area_name'   =>  $request->area_name,
            'area_name_bn'   =>  $request->area_name_bn,
            'geo_code'   =>  $request->geo_code,
            'area_x'   =>  $request->area_x,
            'area_y'   =>  $request->area_y,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        return redirect('admin/area')
                        ->with('success', 'Data have saved updated.');
    }
}
