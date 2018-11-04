<?php

namespace App\Http\Controllers\Backend\Gisobject;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GisobjectModel\GisobjectModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use View;

class Gisobject extends Controller
{
    public $list_title      =   "GIS object information";
    public $create_url      =   "admin/gisobject/create";
    public $edit_url        =   "admin/gisobject/edit";
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
        $list_data      =   GisobjectModel::orderBy('id', 'DESC')->get();
//        print "<pre>";
//        print_r($list_data);
//        print "</pre>";
//        exit;
        
        return view('backend.gisobject.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    
    public function create(){
        $list_title     =   $this->list_title;
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.gisobject.create', compact('list_title','list_url','page','active_menu'));
    }
     // config store method:
    public function store(Request $request) {
        //Define Rules
        $rules = [
            'gisobject_name' => 'required',
            'gisobject_type' => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/gisobject/create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "gisobjects";
        $checkWhereParam = [
                ['gisobject_name', '=', $request->gisobject_name],
                ['gisobject_type', '=', $request->gisobject_type],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/gisobject/create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        
        /*----------------------------------------------------------
         *Insert area
         * ---------------------------------------------------------
         */
        $response   =   GisobjectModel::create([
            'gisobject_name'   =>  $request->gisobject_name,
            'gisobject_type'   =>  $request->gisobject_type,
            'is_deleted'        =>  0,
            'user_id'           =>  Auth::user()->id,
        ]);
        if($response){
            return redirect('admin/gisobject')
                            ->with('success', 'Data have been saved successfully.');
        }else{
            return redirect('admin/gisobject/create')
                            ->withInput()
                            ->with('error', 'Failed to save data.');
        }
    }
    
    public function edit_view($id){
        // get all table data:
        $edit_data      =   GisobjectModel::where('id', $id)->first();
        $list_title     =   $this->list_title;
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.gisobject.edit', compact('list_title','list_url','page','edit_data','active_menu'));
    }
    
    // config store method:
    public function update(Request $request) {
        //Define Rules
        $rules = [
            'gisobject_name' => 'required',
            'gisobject_type' => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/gisobject/edit/' . $request->edit_id)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "gisobjects";
        $checkWhereParam = [
                ['gisobject_name', '=', $request->gisobject_name],
                ['gisobject_type', '=', $request->gisobject_type],
                ['id', '!=', $request->edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/gisobject/edit/' . $request->edit_id)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:

        /* ----------------------------------------------------------
         * Update area
         * ---------------------------------------------------------
         */
        $gisobject = GisobjectModel::find($request->edit_id);
        $gisobject->update([
            'gisobject_name'   => trim($request->get('gisobject_name')),
            'gisobject_type'   => $request->get('gisobject_type'),
            'user_id'           => Auth::user()->id,
        ]);
        return redirect('admin/gisobject')
                        ->with('success', 'Data have saved updated.');
    }
    
    public function searchGisobject(Request $request) {
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query  = GisobjectModel::orderBy('id', 'DESC');

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {

            if (isset($request->gisobject_name) && !empty($request->gisobject_name)) {
                $query->where('gisobject_name', 'like', '%' . $request->gisobject_name . '%');
            }

            if (isset($request->gisobject_type) && !empty($request->gisobject_type)) {
                $query->where('gisobject_type', '=', $request->gisobject_type);
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
            $search_data = View::make('backend.search.gisobject_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
