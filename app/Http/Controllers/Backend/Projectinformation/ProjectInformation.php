<?php

namespace App\Http\Controllers\Backend\Projectinformation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Model\Project\ProjectEntryModel;
use App\Model\Project\ProjectAgenciesyModel;
use App\Model\Project\ProjectVersionsModel;
use App\Model\Project\ProjectProgressModel;
use App\Model\Project\ProjectDetailsModel;
use App\Model\Project\ProjectForeignAssistanceModel;
use App\Model\Project\ProjectLocationsModel;
use App\Model\Project\ProjectcostModel;
use App\Model\Project\ProjectdocumentsModel;
use App\Model\Project\ProjectShapeFilesModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use View;
use Barryvdh\DomPDF\PDF;

class ProjectInformation extends Controller
{
    public $list_title      =   "Project";
    public $create_url      =   "admin/project/create";
    public $edit_url        =   "admin/project/edit";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "project";
    
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
        $list_data  = AgencyModel::orderBy('id', 'DESC')->get();
        
        return view('backend.project.list', compact('list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }
    public function create_project($project_id  =   null){
        $project_data           =   "";
        $project_agency_data    =   "";
        $list_title     =   $this->list_title;
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        $yes_link       =   "admin/yes_link";   
        $no_link        =   "admin/no_link";
        
        
        if(isset($project_id) && !empty($project_id)){
            $project_data  = ProjectEntryModel::where('id', $project_id)->first();
            $project_agency_data  = ProjectAgenciesyModel::where('project_id', $project_id)->where('lead_agency',1)->first();
            $view_url   =   "backend.project.project_update";
        }else{
            session(['project_id' => '']);
            $view_url   =   "backend.project.project_new_entry.project_create";
        }
        // this session information will be needed o truck the right back button link address
        Session::put('project_vew_as', "new_project");
        return view($view_url, compact('list_title','list_url','page','active_menu','yes_link','no_link','project_data','project_agency_data'));
    }
    public function project_agency_create(){
        $project_id     =   Session::get('project_id');
        if(empty($project_id)){
            return redirect('admin/project/project_create')
                            ->with('error', 'Page session was not available!');
        }
        $list_title     =   "Project Co-Agency information";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.project.project_agency_create', compact('list_title','list_url','page','active_menu'));
    }    
    public function project_details_create(){
        $project_id     =   Session::get('project_id');
        if(empty($project_id)){
            return redirect('admin/project/project_create')
                            ->with('error', 'Page session was not available!');
        }
        $list_title     =   "Project Details";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.project.project_details_create', compact('list_title','list_url','page','active_menu'));
    }
    public function project_foreign_assistance_create(){
        $project_id     =   Session::get('project_id');
        if(empty($project_id)){
            return redirect('admin/project/project_create')
                            ->with('error', 'Page session was not available!');
        }
        $list_title     =   "Project Foreign Assistance";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Create";
        return view('backend.project.project_foreign_assistance_create', compact('list_title','list_url','page','active_menu'));
    }
    public function project_location_create(){
        $project_id     =   Session::get('project_id');
        if(empty($project_id)){
            return redirect('admin/project/project_create')
                            ->with('error', 'Page session was not available!');
        }
        $list_title     =   "Project Location";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Location";
        return view('backend.project.project_location_create', compact('list_title','list_url','page','active_menu'));
    }
    public function project_expenditure_information(){
        $project_id     =   Session::get('project_id');
        if(empty($project_id)){
            return redirect('admin/project/project_create')
                            ->with('error', 'Page session was not available!');
        }
        $list_title     =   "Project cost information";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Expenditure Information";
        return view('backend.project.project_expenditure_information_create', compact('list_title','list_url','page','active_menu'));
    }
    public function project_document_information(){
        $project_id     =   Session::get('project_id');
        if(empty($project_id)){
            return redirect('admin/project/project_create')
                            ->with('error', 'Page session was not available!');
        }
        $list_title     =   "Project Document Information";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Document Information";
        return view('backend.project.project_document_information_create', compact('list_title','list_url','page','active_menu'));
    }
    public function project_shapefile_create(){
        $project_id     =   Session::get('project_id');
        if(empty($project_id)){
            return redirect('admin/project/project_create')
                            ->with('error', 'Page session was not available!');
        }
        $list_title     =   "Project Shape File";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Project Shape File";
        return view('backend.project.project_shapefile_create', compact('list_title','list_url','page','active_menu'));
    }    
    public function new_project_store(Request $request) {
        //Define Rules
        $rules = [
            'project_entry_date'    => 'required',
            'proposal_type_id'      => 'required',
            'project_name_eng'      => 'required',
            'project_short_name'    => 'required',
            'pcdivision_id'         => 'required',
            'wing_id'               => 'required',
            'ministry_id'           => 'required',
            'agency_id'             => 'required',
            'subsector_id'          => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/project/project_create')
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']    = "projects";
        $checkWhereParam = [
                ['project_name_eng',    '=', $request->project_name_eng],
                ['is_deleted',    '!=', 1],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/project/project_create')
                            ->withInput()
                            ->with('error', 'Failed to save data. Project Name was duplicate.');
        }// end of duplicate checking:
        
        $checkParam             =   [];
        $checkWhereParam        =   [];
        $checkParam['table']    = "projects";
        $checkWhereParam = [
                ['project_short_name',    '=', $request->project_short_name],
                ['is_deleted',    '!=', 1],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/project/project_create')
                            ->withInput()
                            ->with('error', 'Failed to save data.Project Short Name was duplicate.');
        }// end of duplicate checking:
        
        $checkParam             =   [];
        $checkWhereParam        =   [];
        $checkParam['table']    = "projects";
        $checkWhereParam = [
                ['project_app_code',    '=', $request->project_app_code],
                ['is_deleted',    '!=', 1],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect('admin/project/project_create')
                            ->withInput()
                            ->with('error', 'Failed to save data.Project Code was duplicate.');
        }// end of duplicate checking:
        
        DB::beginTransaction();
        try{
        
            /*----------------------------------------------------------
             *Insert new project
             * First table will be project
             * Second table will be project aagency
             * Third Table will be project version
             * Fourth Table will be project progress
             * ---------------------------------------------------------
             */

            // auto generate project code
            // that will be share every table who will need this    
            
            $codeGeneratorParam     =   [
                'ministry_id'           =>$request->ministry_id,
                'pcdivision_id'         =>$request->pcdivision_id,
                'project_entry_year'    =>date('Y', strtotime($request->project_entry_date)),
                'subsector_id'          =>$request->subsector_id,
            ];

            $project_code   = $this->generateProjectcode($codeGeneratorParam);

            // project table as a First Table Insert
            $response   =   ProjectEntryModel::create([
                'proposal_type_id'          =>  $request->proposal_type_id,
                'project_entry_date'        =>  date('Y-m-d', strtotime($request->project_entry_date)),
                'project_app_code'          =>  $project_code,
                'project_name_eng'          =>  $request->project_name_eng,
                'project_short_name'        =>  $request->project_short_name,
                'project_name_bng'          =>  $request->project_name_bng,
                'pcdivision_id'             =>  $request->pcdivision_id,
                'wing_id'                   =>  $request->wing_id,
                'subsector_id'              =>  (isset($request->subsector_id) ? $request->subsector_id:0),
                'search_keyword'            =>  $request->search_keyword,
                'protemp'                   =>  1,
                'is_deleted'                =>  0,
                'user_id'                   =>  Auth::user()->id,
            ])->id;
            if($response){

                // project agency table as a Second Table Insert
                $agresponse   =   ProjectAgenciesyModel::create([
                    'project_id'    =>  $response,
                    'ministry_id'   =>  $request->ministry_id,
                    'agency_id'     =>  $request->agency_id,
                    'lead_agency'   =>  1,
                    'is_deleted'    =>  0,
                    'user_id'       =>  Auth::user()->id,
                ])->id;

                // project Version table as a Third Table Insert            
                $version_response   =   ProjectVersionsModel::create([
                    'project_id'        =>  $response,
                    'project_type_id'   =>  $request->proposal_type_id,
                    'projectcode'       =>  $project_code,
                    'pstatus'           =>  1, // insert as new project so the value is 1 
                    'rev_number'        =>  0, // as a new project the rev_number is 0
                    'statusdate'        =>  date('Y-m-d h:i:s'),
                    'qreview'           =>  0, // as a new project there is no review make so default value is 0;
                    'qrview_date'       =>  null,
                    'is_deleted'        =>  0,
                    'user_id'           =>  Auth::user()->id,
                    'deo_id'            =>  Auth::user()->id,
                    'deo_date'          =>  date('Y-m-d h:i:s'),
                ])->id;

                // project Progress table as a Fourth Table Insert   
                $agresponse   =   ProjectProgressModel::create([
                    'project_id'        =>  $response,
                    'pversion_id'       =>  $version_response,
                    'progresstype'      =>  "Appraisal",
                    'progressdate'      =>  date('Y-m-d h:i:s'),
                    'progressdecision'  =>  null, // as a new project there is no progressdecision make so default value is 0;
                    'proapp'            =>  0,
                    'proapp_date'       =>  null,
                    'is_deleted'        =>  0,
                    'user_id'           =>  Auth::user()->id,
                ]);
                DB::commit();
                Session::put('project_id', $response);
                return redirect('admin/project/project_create/'.$response)
                                ->with('next_success', 'Successfully Saved, Do you want to add Agency Information (Yes/ No)')
                                ->with('no_link', 'admin/project/project_details_create')
                                ->with('yes_link', 'admin/project/project_agency_create');
            }else{
                DB::rollback();
                return redirect('admin/project/project_create')
                                ->withInput()
                                ->with('error', 'Failed to save data.');
            }
        }catch (\Exception $e) {
            dd($e);
            DB::rollback();
            echo "something went wrong";
        }
    }    
    
    public function generateProjectcode($codeData){
        // get ministry code
        $table  =   'ministries';
        $id  =   $codeData['ministry_id'];
        $ministry_code  =   get_data_name_by_id($table, $id)->ministry_code;
        $pattern    =   $ministry_code.$codeData['pcdivision_id'].$codeData['subsector_id'].$codeData['project_entry_year'];
        $query = ProjectEntryModel::select(DB::raw('count(*) as total_project'))
                ->where(DB::raw('substr(project_app_code, 1, 8)'), '=' , $pattern)
                ->first();
        
        return $pattern . $query->total_project + 1;
    }
    public function project_agency_store(Request $request) { 
        
        $project_view_as    =   Session::get('project_vew_as');
        if($project_view_as == 'new_project'){
            $redirect_url   =   "admin/project/project_agency_create";
        }else{
            $redirect_url   =   "admin/project/project_agency_update";
        }
        
        //Define Rules
        $rules = [
            'project_id' => 'required',
            'agency_id' => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect($redirect_url)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "projectagencies";
        if(isset($request->agency_edit_id) && !empty($request->agency_edit_id)){
            $checkWhereParam = [
                ['project_id', '=', $request->project_id],
                ['agency_id', '=', $request->agency_id],
                ['id', '!=', $request->agency_edit_id],
            ];
        }else{
            $checkWhereParam = [
                ['project_id', '=', $request->project_id],
                ['agency_id', '=', $request->agency_id],
            ];
        }
        
        $checkParam['where'] = $checkWhereParam;
        $duplicateCheck = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect($redirect_url)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        //First get the ministry id:
            $ministry_paam['table']  =   'projectagencies';
            $ministry_paam['where']  =   [
                'project_id'=>$request->project_id,
                'lead_agency'=>1,
            ];
            $ministry_data  =   get_table_data_by_clause($ministry_paam);
        if(isset($request->agency_edit_id) && !empty($request->agency_edit_id)){
            $details = ProjectAgenciesyModel::find($request->agency_edit_id);
            $details->update([
                'agency_id' => $request->agency_id,
                'ministry_id' => ((isset($request->ministry_id))? $request->ministry_id: $ministry_data[0]->ministry_id),
                'lead_agency' => ((isset($request->lead_agency) || isset($request->lead_agency_edit_id))? 1: 0),
                'is_deleted' => 0,
                'user_id' => Auth::user()->id,
            ]);
            if(isset($request->lead_agency) && !empty($request->lead_agency)){
                DB::table('projectagencies')
                    ->where('project_id', $request->project_id)
                    ->where('id', "!=",$request->agency_edit_id)
                    ->update(['lead_agency' => 0]);
            }
        }else{           
            
            $agresponse = ProjectAgenciesyModel::create([
                    'project_id' => $request->project_id,
                    'agency_id' => $request->agency_id,
                    'lead_agency' => ((isset($request->lead_agency))? $request->lead_agency: 0),
                    'is_deleted' => 0,
                    'ministry_id' => ((isset($request->ministry_id))? $request->ministry_id: $ministry_data[0]->ministry_id),
                    'user_id' => Auth::user()->id,
                ])->id;
            
            if(isset($request->lead_agency) && !empty($request->lead_agency)){
                DB::table('projectagencies')
                    ->where('project_id', $request->project_id)
                    ->where('id', "!=",$agresponse)
                    ->update(['lead_agency' => 0]);
            }
        }
        
        Session::put('project_id', $request->project_id);
        return redirect($redirect_url)
                        ->with('success', 'Data have been saved successfully.');
    }
    public function project_details_store(Request $request) {        
        if($request->page_type  ==  "update"){
            $redirect_url   =   "admin/project/project_details_update";
        }else{
            $redirect_url   =   "admin/project/project_details_create";
        }
        
        //Define Rules
        $rules = [
            'objectives'    => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect($redirect_url)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }        
        
        /* ----------------------------------------------------------
         * check update or insert
         * ---------------------------------------------------------
         */
        $checkParam =   [];
        $checkParam['table'] = "project_details";
        $checkWhereParam = [
            ['project_id', '=', $request->project_id]
        ];
        $checkParam['where'] = $checkWhereParam;
        $upOrInCheck = check_duplicate_data($checkParam); //check update or insert check:
        
        if($upOrInCheck){
            
            /* ----------------------------------------------------------
            * check duplicate entry
            * ---------------------------------------------------------
            */
           $dupCheckParam['table'] = "project_details";
           $dupCheckWhereParam = [
               ['objectives', '=', $request->objectives],
               ['id',         '!=', $upOrInCheck],
           ];
           $dupCheckParam['where'] = $dupCheckWhereParam;
           $duplicateCheck      = check_duplicate_data($dupCheckParam); //check_duplicate_data is a helper method:
           // check is it duplicate or not
           if ($duplicateCheck) {
               return redirect($redirect_url)
                               ->withInput()
                               ->with('error', 'Failed to save data. Duplicate Entry found.');
           }// end of duplicate checking:
            $details = ProjectDetailsModel::find($upOrInCheck);
            $details->update([
                'project_id'        => $request->project_id,
                'objectives'        => htmlentities($request->objectives),
                'backgrounds'       => htmlentities($request->backgrounds),
                'activities'        => htmlentities($request->activities),
                'objectives_bng'    => $request->objectives_bng,
                'backgrounds_bng'   => $request->backgrounds_bng,
                'activities_bng'    => $request->activities_bng,
                'bnf_male'          => (isset($request->bnf_male) ? (int)$request->bnf_male: 0),
                'bnf_female'        => (isset($request->bnf_female) ? (int)$request->bnf_female: 0),
                'bnf_total'         => (isset($request->bnf_total) ? (int)$request->bnf_total: 0),
                'is_deleted'        => 0,
                'user_id'           => Auth::user()->id,
            ]);
            return redirect($redirect_url)
                            ->with('success', 'Data have been successfully updated.');
        } else {
            /* ----------------------------------------------------------
            * check duplicate entry
            * ---------------------------------------------------------
            */
           $checkParam['table'] = "project_details";
           $checkWhereParam = [
               ['project_id', '=', $request->project_id],
               ['objectives', '=', $request->objectives],
           ];
           $checkParam['where'] = $checkWhereParam;
           $duplicateCheck = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
           // check is it duplicate or not
           if ($duplicateCheck) {
               return redirect($redirect_url)
                               ->withInput()
                               ->with('error', 'Failed to save data. Duplicate Entry found.');
           }// end of duplicate checking:
            $agresponse = ProjectDetailsModel::create([
                        'project_id'        => $request->project_id,
                        'objectives'        => htmlentities($request->objectives),
                        'backgrounds'       => htmlentities($request->backgrounds),
                        'activities'        => htmlentities($request->activities),
                        'objectives_bng'    => $request->objectives_bng,
                        'backgrounds_bng'   => $request->backgrounds_bng,
                        'activities_bng'    => $request->activities_bng,
                        'bnf_male'          => (isset($request->bnf_male) ? (int)$request->bnf_male: 0),
                        'bnf_female'        => (isset($request->bnf_female) ? (int)$request->bnf_female: 0),
                        'bnf_total'         => (isset($request->bnf_total) ? (int)$request->bnf_total: 0),
                        'is_deleted'        => 0,
                        'user_id'           => Auth::user()->id,
                    ])->id;
            return redirect($redirect_url)
                            ->with('success', 'Data have been saved successfully.');
        }
    }
    public function project_fas_store(Request $request) {
        if($request->page_type  ==  "update"){
            $redirect_url   =   "admin/project/project_foreign_assistance_update";
        }else{
            $redirect_url   =   "admin/project/project_foreign_assistance_create";
        }
        //Define Rules
        $rules = [
            'fa_country'    => 'required',
            'fa_donor'      => 'required',
            'fa_mof'        => 'required',
            'fa_amount'     => 'required|numeric',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect($redirect_url)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table'] = "project_fas";
        $checkWhereParam = [
            ['project_id', '=', $request->project_id],
            ['fa_country', '=', $request->fa_country],
            ['fa_donor', '=', $request->fa_donor],
            ['fa_mof', '=', $request->fa_mof],
            ['fa_amount', '=', $request->fa_amount],
        ];
        if(isset($request->pfa_update_id) && !empty($request->pfa_update_id)){
            $checkWhereParam = [
                ['project_id', '=', $request->project_id],
                ['fa_country', '=', $request->fa_country],
                ['fa_donor', '=', $request->fa_donor],
                ['fa_mof', '=', $request->fa_mof],
                ['fa_amount', '=', $request->fa_amount],
                ['id', '!=', $request->pfa_update_id]
            ];
        }
        $checkParam['where'] = $checkWhereParam;
        $duplicateCheck = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect($redirect_url)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.');
        }// end of duplicate checking:
        // project agency table as a Second Table Insert
        if(isset($request->pfa_update_id) && !empty($request->pfa_update_id)){
            $details = ProjectForeignAssistanceModel::find($request->pfa_update_id);
            $details->update([
                'fa_country'    => $request->fa_country,
                'fa_donor'      => $request->fa_donor,
                'fa_mof'        => $request->fa_mof,
                'fa_amount'     => number_format((float)$request->fa_amount, 2, '.', '')
            ]);
            return redirect($redirect_url)
                            ->with('success', 'Data have been successfully updated.');
        }else{
            $agresponse = ProjectForeignAssistanceModel::create([
                        'project_id'    => $request->project_id,
                        'fa_country'    => $request->fa_country,
                        'fa_donor'   => $request->fa_donor,
                        'fa_mof'    => $request->fa_mof,
                        'fa_amount'    => number_format((float)$request->fa_amount, 2, '.', ''),
                        'is_deleted'    => 0,
                        'user_id'       => Auth::user()->id,
                    ])->id;
            return redirect($redirect_url)
                            ->with('success', 'Data have been saved successfully.');
        }
    }
    public function project_location_store(Request $request) {        
        if ($request->page_type == "update") {
            $redirect_url = "admin/project/project_location_update";
        } else {
            $redirect_url = "admin/project/project_location_create";
        }
        // if there is any request for csv location uploader
        if (isset($request->csv_location) && !empty($request->csv_location)) {
            if ($_FILES["csvlocationfile"]["size"] > 0) {
                //Define Rules
                $rules = [
                    'gisobject_id' => 'required'
                ];
                // Create a new validator instance
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect($redirect_url)
                                    ->withErrors($validator)
                                    ->withInput()
                                    ->with('error', 'Failed to save data')
                                    ->with('csv_location', $request->csv_location)
                                    ->with('csv_type', $request->csv_type);
                }
                
                $filename = $_FILES["csvlocationfile"]["tmp_name"];
                $getCsvData = $this->csvToArray($filename);
                if (isset($getCsvData) && !empty($getCsvData)) {
                    if (isset($request->csv_type) && $request->csv_type == 'upz') {
                        $others_data = [
                            'project_id'    => $request->project_id,
                            'gisobject_id'  => $request->gisobject_id,
                            'csv_type'      => $request->csv_type,
                        ];
                        $this->csv_upload($getCsvData, $others_data);
                    }  // csv type
                } // isset get csv data
            } // if file actually exist 
        } // csv location
        $location_type = $request->location_type;

        if ($location_type == 1) {
            // for getting project center coordinates
            $coordinatesParam['table'] = 'upazilas';
            $coordinatesParam['location_type'] = 1;
            $coordinatesParam['where'] = [
                'id' => $request->upz_id
            ];
            if (isset($request->csv_location) && !empty($request->csv_location)) {
                $rules = [
                    'gisobject_id' => 'required'
                ];
            } else {
                //Define Rules
                $rules = [
                    'div_id' => 'required',
                    'district_id' => 'required',
                    'upz_id' => 'required',
                    'gisobject_id' => 'required'
                ];
            }
            /* ----------------------------------------------------------
             * check duplicate entry
             * ---------------------------------------------------------
             */
            $checkWhereParam = [
                ['project_id', '=', $request->project_id],
                ['gisobject_id', '=', $request->gisobject_id],
                ['district_id', '=', $request->district_id],
                ['upz_id', '=', $request->upz_id],
                ['id', '!=', $request->pla_update_id],
            ];
            $checkParam['where'] = $checkWhereParam;
        } else {
            // for getting project center coordinates
            $coordinatesParam['table'] = 'wards';
            $coordinatesParam['location_type'] = 2;
            $coordinatesParam['where'] = [
                'id' => $request->ward_id
            ];
            /* ----------------------------------------------------------
             * check duplicate entry
             * ---------------------------------------------------------
             */
            $checkWhereParam = [
                ['project_id', '=', $request->project_id],
                ['gisobject_id', '=', $request->gisobject_id],
                ['city_corp_id', '=', $request->city_corp_id],
                ['ward_id', '=', $request->ward_id],
                ['id', '!=', $request->pla_update_id],
            ];
            $checkParam['where'] = $checkWhereParam;
            if (isset($request->csv_location) && !empty($request->csv_location)) {
                $rules = [
                    'gisobject_id' => 'required'
                ];
            } else {
                //Define Rules
                $rules = [
                    'gisobject_id' => 'required',
                    'city_corp_id' => 'required'
                ];
            }
        }


        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect($redirect_url)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data')
                            ->with('div_id', $request->div_id)
                            ->with('district_id', $request->district_id)
                            ->with('city_corp_id', $request->city_corp_id)
                            ->with('ward_id', $request->ward_id)
                            ->with('upz_id', $request->upz_id);
        }
        $checkParam['table'] = "projectlocations";
        $duplicateCheck = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect($redirect_url)
                            ->withInput()
                            ->with('error', 'Failed to save data. Duplicate Entry found.')
                            ->with('div_id', $request->div_id)
                            ->with('district_id', $request->district_id)
                            ->with('city_corp_id', $request->city_corp_id)
                            ->with('ward_id', $request->ward_id)
                            ->with('upz_id', $request->upz_id);
        }// end of duplicate checking:

        if ((isset($request->upz_id) && !empty($request->upz_id)) || (isset($request->ward_id) && !empty($request->ward_id)) || (isset($request->union_id) && !empty($request->union_id))) {
            if (empty($request->loc_x) && empty($request->loc_y)) {
                if (isset($request->union_id) && !empty($request->union_id)) {
                    $coordinatesParam = [];
                    $coordinatesParam['table'] = 'bd_unions';
                    $coordinatesParam['location_type'] = 3;
                    $coordinatesParam['where'] = [
                        'id' => $request->union_id
                    ];
                }
                $location_coordinates = getLocationCenterCoordinates($coordinatesParam);
                $request->loc_x = $location_coordinates['location-coordinets']['loc_x'];
                $request->loc_y = $location_coordinates['location-coordinets']['loc_y'];

                if ($location_type == 1) {
                    $lupdate_param['table'] = 'upazilas'; //update_table
                    $lupdate_param['where'] = [
                        'id' => $request->upz_id
                    ];
                    $lupdate_param['updates_value'] = [
                        'number' => $location_coordinates['update_number']
                    ];
                } else {
                    $lupdate_param['table'] = 'wards'; //update_table
                    $lupdate_param['where'] = [
                        'id' => $request->ward_id
                    ];
                    $lupdate_param['updates_value'] = [
                        'number' => $location_coordinates['update_number']
                    ];
                }
                $res_up = update_table($lupdate_param);
            }
        }
        if (isset($request->pla_update_id) && !empty($request->pla_update_id)) {
            $details = ProjectLocationsModel::find($request->pla_update_id);
            $details->update([
                'district_id' => $request->district_id,
                'upz_id' => $request->upz_id,
                'union_id_id' => $request->union_id,
                'union_id' => $request->union_id,
                'city_corp_id' => $request->city_corp_id,
                'ward_id' => $request->ward_id,
                'roadno' => $request->roadno,
                'gisobject_id' => $request->gisobject_id,
                'loc_x' => $request->loc_x,
                'loc_y' => $request->loc_y,
                'estmcost' => number_format((float) $request->estmcost, 2, '.', ''),
                'is_deleted' => 0,
                'user_id' => Auth::user()->id,
                'constituency' => $request->constituency,
            ]);
            return redirect($redirect_url)
                            ->with('success', 'Data have been successfully updated.')
                            ->with('div_id', $request->div_id)
                            ->with('district_id', $request->district_id)
                            ->with('city_corp_id', $request->city_corp_id)
                            ->with('ward_id', $request->ward_id)
                            ->with('upz_id', $request->upz_id);
        } else {
            $agresponse = ProjectLocationsModel::create([
                        'project_id' => $request->project_id,
                        'district_id' => $request->district_id,
                        'upz_id' => $request->upz_id,
                        'union_id' => $request->union_id,
                        'city_corp_id' => $request->city_corp_id,
                        'ward_id' => $request->ward_id,
                        'roadno' => $request->roadno,
                        'gisobject_id' => $request->gisobject_id,
                        'loc_x' => $request->loc_x,
                        'loc_y' => $request->loc_y,
                        'estmcost' => number_format((float) $request->estmcost, 2, '.', ''),
                        'is_deleted' => 0,
                        'user_id' => Auth::user()->id,
                        'constituency' => $request->constituency,
                    ])->id;
            return redirect($redirect_url)
                            ->with('success', 'Data have been saved successfully.')
                            ->with('div_id', $request->div_id)
                            ->with('district_id', $request->district_id)
                            ->with('city_corp_id', $request->city_corp_id)
                            ->with('ward_id', $request->ward_id)
                            ->with('upz_id', $request->upz_id);
        }
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
    
     public function csv_upload($csvDatas, $others_data) {
        /*
         * Array (
          [0] => 1 // Upazila id
          [1] => 1 // District id
          [2] => Barguna // District Name
          [3] => Amtali // Upazila name
          [4] => আমতলী // Upazila Bangla
          [5] => 109 // constituent
          [6] => 0 // amount
          [7] =>  // selected
          [8] =>  // total cost
          [9] => 10 //total cost
          )
         */
        foreach ($csvDatas as $csvData) {
            if (isset($csvData[7]) && $csvData[7] == 1) {
                $checkWhereParam = [
                    ['project_id', '=', $others_data['project_id']],
                    ['gisobject_id', '=', 1],
                    ['district_id', '=', $csvData[1]],
                    ['upz_id', '=', $csvData[0]]
                ];
                $checkParam['where'] = $checkWhereParam;
                $checkParam['table'] = "projectlocations";
                $duplicateCheck = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
                // check is it duplicate or not
                if (!$duplicateCheck) {
                    if (isset($others_data['csv_type']) && $others_data['csv_type'] == 'upz') {
                        $coordinatesParam = [];
                        $coordinatesParam['table'] = 'upazilas';
                        $coordinatesParam['location_type'] = 1;
                        $coordinatesParam['where'] = [
                            'id' => $csvData[0]
                        ];
                    }
                    $location_coordinates = getLocationCenterCoordinates($coordinatesParam);
                    $loc_x = $location_coordinates['location-coordinets']['loc_x'];
                    $loc_y = $location_coordinates['location-coordinets']['loc_y'];
                    $agresponse = ProjectLocationsModel::create([
                                'project_id' => (int)$others_data['project_id'],
                                'district_id' => (int)$csvData[1],
                                'upz_id' => (int)$csvData[0],
                                'union_id' => null,
                                'city_corp_id' => null,
                                'ward_id' => null,
                                'roadno' => null,
                                'gisobject_id' => (int)$others_data['gisobject_id'],
                                'loc_x' => $loc_x,
                                'loc_y' => $loc_y,
                                'estmcost' => number_format((float) $csvData[9], 2, '.', ''),
                                'is_deleted' => 0,
                                'user_id' => Auth::user()->id,
                                'constituency' => $csvData[5],
                            ])->id;
                }
            }
        }// end of foreach
    }

// end of method;

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
    public function project_expenditure_store(Request $request) {
        if($request->page_type  ==  "update"){
            $redirect_url   =   "admin/project/project_expenditure_information_update";
        }else{
            $redirect_url   =   "admin/project/project_expenditure_information";
        }
        $all = $request->all();
        //Define Rules
        $rules = [
//            'gob.rev' => 'required|not_in:0',
            'implstartdate' => 'required',
            'implenddate' => 'required'
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect($redirect_url)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /* ----------------------------------------------------------
         * check update or insert
         * ---------------------------------------------------------
         */
        $checkParam = [];
        $checkParam['table'] = "projectcosts";
        $checkWhereParam = [
                ['project_id', '=', $request->project_id]
        ];
        $checkParam['where'] = $checkWhereParam;
        $upOrInCheck = check_duplicate_data($checkParam); //check update or insert check:        
        if ($upOrInCheck) {
            /* ----------------------------------------------------------
             * check duplicate entry
             * ---------------------------------------------------------
             */
            $checkParam['table'] = "projectcosts";
            $checkWhereParam = [
                    ['implstartdate', '=', date('Y-m-d',strtotime($request->implstartdate))],
                    ['implenddate', '=', date('Y-m-d',strtotime($request->implenddate))],
                    ['id', '!=', $upOrInCheck],
            ];
            $checkParam['where'] = $checkWhereParam;
            $duplicateCheck = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
            // check is it duplicate or not
            if (!$upOrInCheck) {
                return redirect($redirect_url)
                                ->withInput()
                                ->with('error', 'Failed to save data. Duplicate entry found.');
            }// end of duplicate checking:
            $details = ProjectcostModel::find($upOrInCheck);
            $details->update([
                'project_id'        => $request->project_id,
                'implstartdate'     => date('Y-m-d',strtotime($request->implstartdate)),
                'implenddate'       => date('Y-m-d',strtotime($request->implenddate)),
                'expgobrev'         => (isset($all['gob']['rev'])       ?    number_format((float)$all['gob']['rev'], 2, '.', ''):0),
                'expparev'          => (isset($all['pa']['rev'])        ?    number_format((float)$all['pa']['rev'], 2, '.', ''):0),
                'expofundrev'       => (isset($all['own']['rev'])       ?    number_format((float)$all['own']['rev'], 2, '.', ''):0),
                'expothersrev'      => (isset($all['others']['rev'])    ?    number_format((float)$all['others']['rev'], 2, '.', ''):0),
                'expgobcap'         => (isset($all['gob']['cap'])       ?    number_format((float)$all['gob']['cap'], 2, '.', ''):0),
                'exppacap'          => (isset($all['pa']['cap'])        ?    number_format((float)$all['pa']['cap'], 2, '.', ''):0),
                'expofundcap'       => (isset($all['own']['cap'])       ?    number_format((float)$all['own']['cap'], 2, '.', ''):0),
                'expotherscap'      => (isset($all['others']['cap'])    ?    number_format((float)$all['others']['cap'], 2, '.', ''):0),
                
                'expgobcont_ph'        => (isset($all['gob']['conph'])       ?    number_format((float)$all['gob']['conph'], 2, '.', ''):0),
                'exppacont_ph'         => (isset($all['pa']['conph'])        ?    number_format((float)$all['pa']['conph'], 2, '.', ''):0),
                'expofundcont_ph'      => (isset($all['own']['conph'])       ?    number_format((float)$all['own']['conph'], 2, '.', ''):0),
                'expotherscont_ph'     => (isset($all['others']['conph'])    ?    number_format((float)$all['others']['conph'], 2, '.', ''):0),
                
                'expgobcont_pr'        => (isset($all['gob']['conpr'])       ?    number_format((float)$all['gob']['conpr'], 2, '.', ''):0),
                'exppacont_pr'         => (isset($all['pa']['conpr'])        ?    number_format((float)$all['pa']['conpr'], 2, '.', ''):0),
                'expofundcont_pr'      => (isset($all['own']['conpr'])       ?    number_format((float)$all['own']['conpr'], 2, '.', ''):0),
                'expotherscont_pr'     => (isset($all['others']['conpr'])    ?    number_format((float)$all['others']['conpr'], 2, '.', ''):0),
                
                'gob_gt'              => (isset($all['gob']['grand'])     ?    number_format((float)$all['gob']['grand'], 2, '.', ''):0),
                'pa_gt'               => (isset($all['pa']['grand'])      ?    number_format((float)$all['pa']['grand'], 2, '.', ''):0),
                'own_gt'              => (isset($all['own']['grand'])     ?    number_format((float)$all['own']['grand'], 2, '.', ''):0),
                'oth_gt'              => (isset($all['others']['grand'])  ?     number_format((float)$all['others']['grand'], 2, '.', ''):0),
                
                'rev_total'            => (isset($all['all_total']['rev'])  ?  number_format((float)$all['all_total']['rev'], 2, '.', ''):0),
                'cap_total'            => (isset($all['all_total']['cap'])  ?  number_format((float)$all['all_total']['cap'], 2, '.', ''):0),
                'conph_total'          => (isset($all['all_total']['conph'])  ?  number_format((float)$all['all_total']['conph'], 2, '.', ''):0),
                'conpr_total'          => (isset($all['all_total']['conpr'])  ?  number_format((float)$all['all_total']['conpr'], 2, '.', ''):0),
                'sum_grand_total'      => (isset($all['all_total']['grand'])  ?  number_format((float)$all['all_total']['grand'], 2, '.', ''):0),
                
                'is_deleted'        => 0,
                'user_id'           => Auth::user()->id,
            ]);
            return redirect($redirect_url)
                            ->with('success', 'Data have updated successfully.');
        } else {

            /* ----------------------------------------------------------
             * check duplicate entry
             * ---------------------------------------------------------
             */
            $checkParam['table'] = "projectcosts";
            $checkWhereParam = [
                    ['project_id', '=', $request->project_id],
                    ['implstartdate', '=', date('Y-m-d',strtotime($request->implstartdate))],
                    ['implenddate', '=', date('Y-m-d',strtotime($request->implenddate))]
            ];
            $checkParam['where'] = $checkWhereParam;
            $duplicateCheck = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
            // check is it duplicate or not
            if ($duplicateCheck) {
                return redirect($redirect_url)
                                ->withInput()
                                ->with('error', 'Failed to save data. Duplicate Entry found.');
            }// end of duplicate checking:
            // project agency table as a Second Table Insert
            $agresponse = ProjectcostModel::create([
                        'project_id' => $request->project_id,
                        'implstartdate'     => date('Y-m-d',strtotime($request->implstartdate)),
                        'implenddate'       => date('Y-m-d',strtotime($request->implenddate)),
                        'expgobrev'         => (isset($all['gob']['rev'])       ?    number_format((float)$all['gob']['rev'], 2, '.', ''):0),
                        'expparev'          => (isset($all['pa']['rev'])        ?    number_format((float)$all['pa']['rev'], 2, '.', ''):0),
                        'expofundrev'       => (isset($all['own']['rev'])       ?    number_format((float)$all['own']['rev'], 2, '.', ''):0),
                        'expothersrev'      => (isset($all['others']['rev'])    ?    number_format((float)$all['others']['rev'], 2, '.', ''):0),
                        'expgobcap'         => (isset($all['gob']['cap'])       ?    number_format((float)$all['gob']['cap'], 2, '.', ''):0),
                        'exppacap'          => (isset($all['pa']['cap'])        ?    number_format((float)$all['pa']['cap'], 2, '.', ''):0),
                        'expofundcap'       => (isset($all['own']['cap'])       ?    number_format((float)$all['own']['cap'], 2, '.', ''):0),
                        'expotherscap'      => (isset($all['others']['cap'])    ?    number_format((float)$all['others']['cap'], 2, '.', ''):0),

                        'expgobcont_ph'        => (isset($all['gob']['conph'])       ?    number_format((float)$all['gob']['conph'], 2, '.', ''):0),
                        'exppacont_ph'         => (isset($all['pa']['conph'])        ?    number_format((float)$all['pa']['conph'], 2, '.', ''):0),
                        'expofundcont_ph'      => (isset($all['own']['conph'])       ?    number_format((float)$all['own']['conph'], 2, '.', ''):0),
                        'expotherscont_ph'     => (isset($all['others']['conph'])    ?    number_format((float)$all['others']['conph'], 2, '.', ''):0),

                        'expgobcont_pr'        => (isset($all['gob']['conpr'])       ?    number_format((float)$all['gob']['conpr'], 2, '.', ''):0),
                        'exppacont_pr'         => (isset($all['pa']['conpr'])        ?    number_format((float)$all['pa']['conpr'], 2, '.', ''):0),
                        'expofundcont_pr'      => (isset($all['own']['conpr'])       ?    number_format((float)$all['own']['conpr'], 2, '.', ''):0),
                        'expotherscont_pr'     => (isset($all['others']['conpr'])    ?    number_format((float)$all['others']['conpr'], 2, '.', ''):0),

                        'gob_gt'              => (isset($all['gob']['grand'])     ?    number_format((float)$all['gob']['grand'], 2, '.', ''):0),
                        'pa_gt'               => (isset($all['pa']['grand'])      ?    number_format((float)$all['pa']['grand'], 2, '.', ''):0),
                        'own_gt'              => (isset($all['own']['grand'])     ?    number_format((float)$all['own']['grand'], 2, '.', ''):0),
                        'oth_gt'              => (isset($all['others']['grand'])  ?     number_format((float)$all['others']['grand'], 2, '.', ''):0),

                        'rev_total'            => (isset($all['all_total']['rev'])  ?  number_format((float)$all['all_total']['rev'], 2, '.', ''):0),
                        'cap_total'            => (isset($all['all_total']['cap'])  ?  number_format((float)$all['all_total']['cap'], 2, '.', ''):0),
                        'conph_total'          => (isset($all['all_total']['conph'])  ?  number_format((float)$all['all_total']['conph'], 2, '.', ''):0),
                        'conpr_total'          => (isset($all['all_total']['conpr'])  ?  number_format((float)$all['all_total']['conpr'], 2, '.', ''):0),
                        'sum_grand_total'      => (isset($all['all_total']['grand'])  ?  number_format((float)$all['all_total']['grand'], 2, '.', ''):0),
                
                        'is_deleted'        => 0,
                        'user_id'           => Auth::user()->id,
                    ])->id;
            return redirect($redirect_url)
                            ->with('success', 'Data have been saved successfully.');
        }
    }
    public function project_documents_store(Request $request) {  
        $doc_allwoed_upload_size    =   config('app.app_file_size.doc_allowed_file_size');
        if($request->page_type  ==  "update"){
            $redirect_url   =   "admin/project/project_documents_update";
        }else{
            $redirect_url   =   "admin/project/project_document_information";
        }
        //Define Rules
        $rules = [
            'doctype'       => 'required',
            'project_docs'  => "required|max:$doc_allwoed_upload_size",
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect($redirect_url)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        } 
        // project agency table as a Second Table Insert
        $path = $_FILES['project_docs']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $filename = time() . "." . $ext;
        $filepath = public_path('/uploads/project_shape_files/doc_store/');
        $agresponse = ProjectdocumentsModel::create([
                    'project_id'    => $request->project_id,
                    'docname'       => $_FILES['project_docs']['name'],
                    'documents'     => base64_encode($_FILES['project_docs']['name']),
                    'doctype'       => $request->doctype,
                    'remarks'       => $request->remarks,
                    'doc_path'      => $filename,
                    'is_deleted'    => 0,
                    'user_id'       => Auth::user()->id,
                ])->id;
        $checkMove = move_uploaded_file($_FILES['project_docs']['tmp_name'], $filepath . $filename);
        return redirect($redirect_url)
                        ->with('success', 'Data have been saved successfully.');
    }
    public function project_shapefils_store(Request $request) {
        $doc_allwoed_upload_size    =   config('app.app_file_size.shape_allowed_file_size');
        if($request->page_type  ==  "update"){
            $redirect_url   =   "admin/project/project_shapefile_update";
        }else{
            $redirect_url   =   "admin/project/project_shapefile_create";
        }
        //Define Rules
        $rules = [
            'project_docs'    => "required|max:$doc_allwoed_upload_size",
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect($redirect_url)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        // project agency table as a Second Table Insert
        $path = $_FILES['project_docs']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $filename = time() . "." . $ext;
        $filepath = public_path('/uploads/project_shape_files/');
        
        $agresponse = new ProjectShapeFilesModel;
        $agresponse->project_id = $request->project_id;
        $agresponse->docname = $_FILES['project_docs']['name'];
        $agresponse->documents = "";
        $agresponse->is_deleted = 0;
        $agresponse->user_id = Auth::user()->id;
        $agresponse->save();
        $checkMove = move_uploaded_file($_FILES['project_docs']['tmp_name'], $filepath . $filename);
        if ($checkMove) {
            return redirect($redirect_url)
                            ->with('success', 'Data have been saved successfully.');
        } else {
            return redirect($redirect_url)
                            ->with('error', 'Failed to uploaad the file.');
        }
    }
    public function temporary_project(){
        $user_type    =   getRoleIdByUserId(Auth::user()->id);        
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/temporary_project_view";
        $active_menu    =   $this->active_menu;
        $page           =   "List";
        // get all table data:
        if($user_type == 4){
            $list_data      =       ProjectEntryModel::orderBy('updated_at', 'DESC')->where('protemp','=',1)->where('is_deleted','=',0)->get();
        }else{
            $list_data      =       ProjectEntryModel::orderBy('updated_at', 'DESC')->where('protemp','=',1)->where('user_id','=',Auth::user()->id)->get();
        }
        return view('backend.project.temporary_project', compact('list_title','list_data','create_url','edit_url','list_url','page','active_menu'));
    }
    
    public function approved_project_view(Request $request){
        $list_title     =   "Temporary Project";;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/temporary_project_view";
        $active_menu    =   $this->active_menu;
        $page           =   "Temporary Project";
        // get all table data:
        $project_data  = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_agency_data  = ProjectAgenciesyModel::where('project_id', $request->project_id)->first();
        Session::put('project_id', $request->project_id);  
        // this session information will be needed o truck the right back button link address
        Session::put('project_vew_as', "temporary");
//        return view('backend.project.temporary_project_view', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu'));
        return view('backend.project.approved_project_view', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu'));
    }
    
    public function temporary_project_view(Request $request){
        $list_title     =   "Temporary Project";;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/temporary_project_view";
        $active_menu    =   $this->active_menu;
        $page           =   "Temporary Project";
        // get all table data:
        $project_data  = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_agency_data  = ProjectAgenciesyModel::where('project_id', $request->project_id)->first();
        Session::put('project_id', $request->project_id);  
        // this session information will be needed o truck the right back button link address
        Session::put('project_vew_as', "temporary");
//        return view('backend.project.temporary_project_view', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu'));
        return view('backend.project.project_final_save', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu'));
    }
    
    public function project_agency_update(Request $request) {
        $project_id         =   Session::get('project_id');
        $project_data  = ProjectEntryModel::where('id', $project_id)->first();
        if(!isset($project_id) && empty($project_id)){
            return redirect('admin/project/temporary_project')
                                ->withInput()
                                ->with('error', 'Session has time out!.');
        }
        $project_type   = get_project_type_by_project_id($project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_project_quality_review_view/";
        }elseif($project_type->protemp == 3){
            //"progress project";
            $this->active_menu = "project_progress";
            $back   =   "admin/project/project_progress_view/";
        }
        $list_title     =   "Project Co-agency information";
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Update";        
        return view('backend.project.project_agency_update', compact('list_title','list_url','page','active_menu','back'));
    }
    public function project_details_update(Request $request) {
        $project_id         =   Session::get('project_id');
        $project_data       = ProjectEntryModel::where('id', $project_id)->first();
        if(!isset($project_id) && empty($project_id)){
            return redirect('admin/project/temporary_project')
                                ->withInput()
                                ->with('error', 'Session has time out!.');
        }
        $project_type   = get_project_type_by_project_id($project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_project_quality_review_view/";
        }elseif($project_type->protemp == 3){
            //"Project progress";
            $this->active_menu = "project_progress";
            $back   =   "admin/project/project_progress_view/";
        }
        $list_title     =   "Project detail information";
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Update";        
        return view('backend.project.project_details_update', compact('list_title','list_url','page','active_menu','back'));
    }
    public function project_foreign_assistance_update(Request $request) {
        $project_id         =   Session::get('project_id');
        $project_data       = ProjectEntryModel::where('id', $project_id)->first();
        if(!isset($project_id) && empty($project_id)){
            return redirect('admin/project/temporary_project')
                                ->withInput()
                                ->with('error', 'Session has time out!.');
        }
        $project_type   = get_project_type_by_project_id($project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_project_quality_review_view/";
        }elseif($project_type->protemp == 3){
            //"progress project";
            $this->active_menu = "project_progress";
            $back   =   "admin/project/project_progress_view/";
        }
        $list_title     =   "Project foreign assistance information";
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Update";        
        return view('backend.project.project_foreign_assistance_update', compact('list_title','list_url','page','active_menu','back'));
    }
    public function project_location_update(Request $request) {
        $project_id         =   Session::get('project_id');
        if(!isset($project_id) && empty($project_id)){
            return redirect('admin/project/temporary_project')
                                ->withInput()
                                ->with('error', 'Session has time out!.');
        }
        $project_type   = get_project_type_by_project_id($project_id);
        $project_data       = ProjectEntryModel::where('id', $project_id)->first();
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_project_quality_review_view/";
        }elseif($project_type->protemp == 3){
            //"Project progress";
            $this->active_menu = "project_progress";
            $back   =   "admin/project/project_progress_view/";
        }
        $list_title     =   "Project location information";
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Update";        
        return view('backend.project.project_location_update', compact('list_title','list_url','page','active_menu','back'));
    }
    public function project_expenditure_information_update(Request $request) {
        $project_id         =   Session::get('project_id');
        if(!isset($project_id) && empty($project_id)){
            return redirect('admin/project/temporary_project')
                                ->withInput()
                                ->with('error', 'Session has time out!.');
        }
        $project_type   = get_project_type_by_project_id($project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects_view/";
        }elseif($project_type->protemp == 3){
            //"progress project";
            $this->active_menu = "project_progress";
            $back   =   "admin/project/project_progress_view/";
        }
        $list_title     =   "Project cost information";
        $list_url      =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Update";        
        return view('backend.project.project_expenditure_information_update', compact('list_title','list_url','page','active_menu','back'));
    }
    public function project_documents_update(Request $request) {
        $project_id         =   Session::get('project_id');
        $project_data       = ProjectEntryModel::where('id', $project_id)->first();
        if(!isset($project_id) && empty($project_id)){
            return redirect('admin/project/temporary_project')
                                ->withInput()
                                ->with('error', 'Session has time out!.');
        }
        $project_type   = get_project_type_by_project_id($project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_project_quality_review_view/";
        }elseif($project_type->protemp == 3){
            //"Project progress";
            $this->active_menu = "project_progress";
            $back   =   "admin/project/project_progress_view/";
        }
        
        $list_title     =   "Project document information";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Update";        
        return view('backend.project.project_document_information_update', compact('list_title','list_url','page','active_menu','back'));
    }
    public function project_shapefile_update(Request $request) {
        $project_id         =   Session::get('project_id');
        $project_data       = ProjectEntryModel::where('id', $project_id)->first();
        if(!isset($project_id) && empty($project_id)){
            return redirect('admin/project/temporary_project')
                                ->withInput()
                                ->with('error', 'Session has time out!.');
        }
        $project_type   = get_project_type_by_project_id($project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_project_quality_review_view/";
        }
        $list_title     =   "Upload shape file";
        $list_url       =   $this->list_url;
        $active_menu    =   $this->active_menu;
        $page           =   "Update";        
        return view('backend.project.project_shapefile_update', compact('list_title','list_url','page','active_menu','back'));
    }    
    public function project_final_save(Request $request){
        $all_table_check    =   check_all_required_table_has_data($request->project_edit_id);
        if($all_table_check){        
            $redirect_url   =   "admin/project/temporary_project_view/".$request->project_edit_id;
            //Define Rules
            $rules = [
                'project_entry_date'    => 'required',
                'proposal_type_id'      => 'required',
                'project_name_eng'      => 'required',
                'project_short_name'    => 'required',
                'pcdivision_id'         => 'required',
                'wing_id'               => 'required',
                'ministry_id'           => 'required',
                'agency_id'             => 'required',
                'subsector_id'          => 'required',
            ];

            // Create a new validator instance
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect($redirect_url)
                                ->withErrors($validator)
                                ->withInput()
                                ->with('error', 'Failed to save data');
            }
            /*----------------------------------------------------------
             *check duplicate entry
             * ---------------------------------------------------------
             */
            $checkParam['table']    = "projects";
            $checkWhereParam = [
                    ['project_name_eng',    '=', $request->project_name_eng],
                    ['id',         '!=', $request->project_edit_id],
                    ['is_deleted',         '!=', 1],
            ];
            $checkParam['where']    = $checkWhereParam;
            $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
            // check is it duplicate or not
            if ($duplicateCheck) {
                return redirect($redirect_url)
                                ->withInput()
                                ->with('error', 'Failed to save data. Project Name was duplicate.');
            }// end of duplicate checking:

            $checkParam             =   [];
            $checkWhereParam        =   [];
            $checkParam['table']    = "projects";
            $checkWhereParam = [
                    ['project_short_name',    '=', $request->project_short_name],
                    ['id',         '!=', $request->project_edit_id],
                    ['is_deleted',         '!=', 1],
            ];
            $checkParam['where']    = $checkWhereParam;
            $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
            // check is it duplicate or not
            if ($duplicateCheck) {
                return redirect($redirect_url)
                                ->withInput()
                                ->with('error', 'Failed to save data.Project Short Name was duplicate.');
            }// end of duplicate checking:

            $details = ProjectEntryModel::find($request->project_edit_id);
            $details->update([
                    'proposal_type_id'          =>  $request->proposal_type_id,
                    'project_entry_date'        =>  date("Y-m-d", strtotime($request->project_entry_date)),
                    'project_name_eng'          =>  $request->project_name_eng,
                    'project_short_name'        =>  $request->project_short_name,
                    'project_name_bng'          =>  $request->project_name_bng,
                    'pcdivision_id'             =>  $request->pcdivision_id,
                    'wing_id'                   =>  $request->wing_id,
                    'subsector_id'              =>  (isset($request->subsector_id) ? $request->subsector_id:0),
                    'search_keyword'            =>  $request->search_keyword,
                    'protemp'                   =>  0,
                    'is_deleted'                =>  0,
                    'user_id'                   =>  Auth::user()->id,
                ]);
            return redirect("admin/project/temporary_project")
                ->with('success', 'Project Final Save have been done successfully.');
        }else{
            return redirect("admin/project/temporary_project")
                ->with('error', 'Missing mandatory data');
        }
    }// end of main method
    
    
    public function project_quality_review(){
        $list_data      =   [];
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/project_quality_review_view";
        $active_menu    =   "quality_control";
        $page           =   "List";
        // get all table data:
        
        $list_data      =       ProjectEntryModel::orderBy('updated_at', 'DESC')->where('protemp','=',0)->where('quality_review_identity','=',0)->where('is_deleted','=',0)->get();      
        
        return view('backend.project.project_quality_review', compact('list_title','list_data','create_url','edit_url','list_url','page','active_menu'));
    }    
    public function revised_quality_review(){
        $list_data      =   [];
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/revised_project_quality_review_view";
        $active_menu    =   "quality_control";
        $page           =   "List";
        // get all table data:
        
        $list_data      =       ProjectEntryModel::orderBy('updated_at', 'DESC')->where('protemp','=',2)->where('quality_review_identity','=',1)->where('is_deleted','=',0)->get();      
        
        return view('backend.project.project_revised_quality_review', compact('list_title','list_data','create_url','edit_url','list_url','page','active_menu'));
    }    
    public function project_quality_review_view(Request $request){
        $list_title     =   "Project quality review";;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/project_quality_review";
        $active_menu    =   "quality_control";
        $page           =   "Project Quality Review";
        // get all table data:
        $project_data  = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_agency_data  = ProjectAgenciesyModel::where('project_id', $request->project_id)->first();
        Session::put('project_id', $request->project_id);
        // this session information will be needed o truck the right back button link address
        Session::put('project_vew_as', "quality_review");
//        return view('backend.project.temporary_project_view', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu'));
        return view('backend.project.project_quality_review_save', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu'));
    }
    public function project_quality_review_search(Request $request){
        $list_data      =   [];
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/project_quality_review_view";
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query      =     DB::table('projects as p')
                          ->join('projectcosts as pc'       ,'pc.project_id','=','p.id')
                          ->join('projectagencies as pa','pa.project_id','=','p.id')
                          ->join('project_versions as pv','p.id','=','pv.project_id')
                          ->where('p.protemp','=',0);

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {
            if (isset($request->search_from_date) && !empty($request->search_from_date)) {
                $from_date      =   date("Y-m-d", strtotime($request->search_from_date));
                $query->where('pc.implstartdate', '>=', $from_date);
            }
            if (isset($request->search_to_date) && !empty($request->search_to_date)) {
                $to_date      =   date("Y-m-d", strtotime($request->search_to_date));
                $query->where('pc.implenddate', '<=', $to_date);
            }
            if (isset($request->user_id) && !empty($request->user_id)) {
                $query->where('pv.deo_id', '=', $request->user_id);
            }
        }
        $list_data = $query->get();
        if ($list_data->isEmpty()) {
            $search_data = View::make('backend.search.project_quality_review_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'error',
                'message' => 'Data Not Found',
                'data' => $search_data->render()
            ];
        } else {
            $project_ids    =   [];
            foreach($list_data as $pd){
                $project_ids[]      =   $pd->project_id;
            }
            $list_data      =       ProjectEntryModel::orderBy('id', 'ASC')->whereIn('id', $project_ids)->get();
            $search_data = View::make('backend.search.project_quality_review_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
    
    public function project_revised_quality_review_search(Request $request){
        $list_data      =   [];
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/revised_project_quality_review_view";
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query      =     DB::table('projects as p')
                          ->join('projectcosts as pc'       ,'pc.project_id','=','p.id')
                          ->join('projectagencies as pa','pa.project_id','=','p.id')
                          ->where('p.protemp','=',2)
                          ->where('p.quality_review_identity','=',1)
                          ->where('p.is_deleted','=',0);

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->get();
        } else {
            if (isset($request->search_from_date) && !empty($request->search_from_date)) {
                $from_date      =   date("Y-m-d", strtotime($request->search_from_date));
                $query->where('pc.implstartdate', '>=', $from_date);
            }
            if (isset($request->search_to_date) && !empty($request->search_to_date)) {
                $to_date      =   date("Y-m-d", strtotime($request->search_to_date));
                $query->where('pc.implenddate', '<=', $to_date);
            }
            if (isset($request->user_id) && !empty($request->user_id)) {
                $query->where('p.user_id', '=', $request->user_id);
            }
        }
        $list_data = $query->get();
        if ($list_data->isEmpty()) {
            $search_data = View::make('backend.search.project_quality_review_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'error',
                'message' => 'Data Not Found',
                'data' => $search_data->render()
            ];
        } else {
            $project_ids    =   [];
            foreach($list_data as $pd){
                $project_ids[]      =   $pd->project_id;
            }
            $list_data      =       ProjectEntryModel::orderBy('id', 'ASC')->whereIn('id', $project_ids)->get();
            $search_data = View::make('backend.search.project_quality_review_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
    
    public function project_quality_review_update(Request $request){
        $redirect_url   =   "admin/project/project_quality_review_view/".$request->project_edit_id;
        //Define Rules
        $rules = [
            'project_entry_date'    => 'required',
            'proposal_type_id'      => 'required',
            'project_name_eng'      => 'required',
            'project_short_name'    => 'required',
            'pcdivision_id'         => 'required',
            'wing_id'               => 'required',
            'ministry_id'           => 'required',
            'agency_id'             => 'required',
            'subsector_id'          => 'required',
        ];

        // Create a new validator instance
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect($redirect_url)
                            ->withErrors($validator)
                            ->withInput()
                            ->with('error', 'Failed to save data');
        }
        /*----------------------------------------------------------
         *check duplicate entry
         * ---------------------------------------------------------
         */
        $checkParam['table']    = "projects";
        $checkWhereParam = [
                ['project_name_eng',    '=', $request->project_name_eng],
                ['id',         '!=', $request->project_edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect($redirect_url)
                            ->withInput()
                            ->with('error', 'Failed to complete quality review. Project Name was duplicate.');
        }// end of duplicate checking:
        
        $checkParam             =   [];
        $checkWhereParam        =   [];
        $checkParam['table']    = "projects";
        $checkWhereParam = [
                ['project_short_name',    '=', $request->project_short_name],
                ['id',         '!=', $request->project_edit_id],
        ];
        $checkParam['where']    = $checkWhereParam;
        $duplicateCheck         = check_duplicate_data($checkParam); //check_duplicate_data is a helper method:
        // check is it duplicate or not
        if ($duplicateCheck) {
            return redirect($redirect_url)
                            ->withInput()
                            ->with('error', 'Failed to complete quality review.Project Short Name was duplicate.');
        }// end of duplicate checking:
        
        // retrive the current data from version table:
        $reviewData     =   DB::table('project_versions')
                                ->where('project_id','=',$request->project_edit_id)
                                ->where('qreview','=',0)
                                ->first();
        /*
         * project_versions table will be updaed by the following status
         * qreview      = 1 means the quality review has been done
         * qrview_date  = quality review done time
         * qreview_id   = quality review done by whom
         * 
         */
        DB::table('project_versions')
            ->where('id', $reviewData->id)
            ->update([
                'qreview'       => 1,
                'qrview_date'   => date("Y-m-d h:i:s"),
                'qreview_id'    => Auth::user()->id,
                'deo_id'        => Auth::user()->id,
                'deo_date'      => date("Y-m-d h:i:s"),
                ]);
        
        /*
         * table will be updaed by the following status
         * protemp      = 3 means the quality review has been done
         * quality_review_identity  set 0 means if quality review comes from revised project then its updated to 1 and after finish its updated to 0
         * 
         */
        
        DB::table('projects')
            ->where('id', $request->project_edit_id)
            ->update([
                'protemp'       => 3,
                'quality_review_identity'       => 0,
                ]);
        
        return redirect("admin/project/project_quality_review")
            ->with('success', 'Quality review have been done successfully.');
    }
    
    public function revised_project_quality_review_view(Request $request){
        $list_title     =   "Revised Project Quality review";;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/revised_project";        
        $page           =   "Revised Project";
        // get all table data:
        $project_data  = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_type   = get_project_type_by_project_id($request->project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_quality_review/";
        }
        $active_menu    =   $this->active_menu;        
        $project_agency_data  = ProjectAgenciesyModel::where('project_id', $request->project_id)->first();
        Session::put('project_id', $request->project_id);
        // this session information will be needed o truck the right back button link address
        Session::put('project_vew_as', "revised_project");
        return view('backend.project.revised_project_quality_review', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu','back'));
    }
    /*
     * which table will be updated when revised project quality review done
     * 1. project cost table will be updated with the cureent project version id that is project id
     * 2. project table will be updated with the actual project id. quality_review_identity field set to be 0.updated by field and user id will be updated.
     * 3. project version table will be updated 
     */
    public function revised_project_quality_store(Request $request){
        $all = $request->all();
        DB::beginTransaction();
        try {            
            // project cost table will be updated first with the current project version id.            
            
            $details = ProjectcostModel::find($request->project_cost_id);            
            $details->update([
                'project_id'        => $request->project_version_project_id,
                'implstartdate'     => date('Y-m-d',strtotime($request->implstartdate)),
                'implenddate'       => date('Y-m-d',strtotime($request->implenddate)),
                'expgobrev'         => (isset($all['gob']['rev'])       ?    $all['gob']['rev']:0),
                'expparev'          => (isset($all['pa']['rev'])        ?    $all['pa']['rev']:0),
                'expofundrev'       => (isset($all['own']['rev'])       ?    $all['own']['rev']:0),
                'expothersrev'      => (isset($all['others']['rev'])    ?    $all['others']['rev']:0),
                'expgobcap'         => (isset($all['gob']['cap'])       ?    $all['gob']['cap']:0),
                'exppacap'          => (isset($all['pa']['cap'])        ?    $all['pa']['cap']:0),
                'expofundcap'       => (isset($all['own']['cap'])       ?    $all['own']['cap']:0),
                'expotherscap'      => (isset($all['others']['cap'])    ?    $all['others']['cap']:0),
                'expgobcont'        => (isset($all['gob']['con'])       ?    $all['gob']['con']:0),
                'exppacont'         => (isset($all['pa']['con'])        ?    $all['pa']['con']:0),
                'expofundcont'      => (isset($all['own']['con'])       ?    $all['own']['con']:0),
                'expotherscont'     => (isset($all['others']['con'])    ?    $all['others']['con']:0),
                'gob_gt'            => (isset($all['gob']['grand'])     ?    $all['gob']['grand']:0),
                'pa_gt'             => (isset($all['pa']['grand'])      ?    $all['pa']['grand']:0),
                'own_gt'            => (isset($all['own']['grand'])     ?    $all['own']['grand']:0),
                'oth_gt'            => (isset($all['others']['grand'])  ?  $all['others']['grand']:0),
                
                'rev_total'            => (isset($all['all_total']['rev'])  ?  $all['all_total']['rev']:0),
                'cap_total'            => (isset($all['all_total']['cap'])  ?  $all['all_total']['cap']:0),
                'conph_total'          => (isset($all['all_total']['conph'])  ?  $all['all_total']['conph']:0),
                'conpr_total'          => (isset($all['all_total']['conpr'])  ?  $all['all_total']['conpr']:0),
                'sum_grand_total'      => (isset($all['all_total']['grand'])  ?  $all['all_total']['grand']:0),
                
                'is_deleted'        => 0,
                'user_id'           => Auth::user()->id,
            ]);
            
            // project table will be updated with the actual project id
            $project_details = ProjectEntryModel::find($request->project_id);
            $project_details->update([                
                'protemp'   =>  3,
                'quality_review_identity'   =>  0,
                'user_id'                   =>  Auth::user()->id,
            ]);
            
            $version_response = ProjectVersionsModel::find($request->project_version_id);
            $version_response->update([                
                'statusdate'                =>  date('Y-m-d',strtotime($request->revised_date)),
                'qreview'                   =>  1,
                'qrview_date'               =>  date('Y-m-d',strtotime($request->revised_date)),
                'qreview_id'                =>  Auth::user()->id,
                'deo_id'                    =>  Auth::user()->id,
                'deo_date'                  =>  date('Y-m-d h:i:s'),
            ]);
            DB::commit();
            //revised_project_search
            return redirect("admin/project/revised_quality_review")
            ->with('success', 'Data have been revised successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            echo "something went wrong";
        }
    }
    
    public function revised_projects(){
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/revised_projects_view";
        $active_menu    =   "project";
        $page           =   "List";
        $list_data      =       ProjectEntryModel::orderBy('updated_at', 'DESC')->where('protemp','=',2)->where('is_deleted','=',0)->where('quality_review_identity','=',0)->get();//quality_review_identity
// get all table data:
        return view('backend.project.revised_project', compact('list_title','list_data','create_url','edit_url','list_url','page','active_menu'));
    }
    public function revised_projects_view(Request $request){
        $list_title     =   "Revised project";;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/revised_project";
        $active_menu    =   "revised_project";
        $page           =   "Revised Project";
        $project_data  = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_type   = get_project_type_by_project_id($request->project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_project_quality_review_view/";
        }
        $active_menu    =   $this->active_menu;
        // get all table data:
        $project_data  = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_agency_data  = ProjectAgenciesyModel::where('project_id', $request->project_id)->first();
        Session::put('project_id', $request->project_id);
        // this session information will be needed o truck the right back button link address
        Session::put('project_vew_as', "revised_project");
        return view('backend.project.revised_project_details_landing_view', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu','back'));
    }
    public function revised_project_search(Request $request){        
        $list_data  =   [];
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query      =     DB::table('projects as p')
                          ->join('projectcosts as pc'       ,'pc.project_id','=','p.id')
                          ->join('projectagencies as pa'    ,'p.id','=','pa.project_id')
                          ->where('p.protemp','=',2)
                          ->where('p.is_deleted','=',0)
                          ->where('p.quality_review_identity','=',0)
                          ->groupBy('pa.project_id');
        //where('protemp','=',2)->where('is_deleted','=',0)->where('quality_review_identity','=',0)

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->select('pa.project_id')->get();
        } else {
            if (isset($request->search_project) && !empty($request->search_project)) {
                $query->where('p.project_name_eng', 'like', '%' . $request->search_project . '%');
            }
            if (isset($request->search_from_date) && !empty($request->search_from_date)) {
                $from_date      =   date("Y-m-d", strtotime($request->search_from_date));
                $query->where('pc.implstartdate', '>=', $from_date);
            }
            if (isset($request->search_to_date) && !empty($request->search_to_date)) {
                $to_date      =   date("Y-m-d", strtotime($request->search_to_date));
                $query->where('pc.implenddate', '<=', $to_date);
            }
            
            if (isset($request->pcdivision_id) && !empty($request->pcdivision_id)) {
                $query->where('p.pcdivision_id', '=', $request->pcdivision_id);
            }
            if (isset($request->ministry_id) && !empty($request->ministry_id)) {
                $query->where('pa.ministry_id', '=', $request->ministry_id);
            }
            if (isset($request->agency_id) && !empty($request->agency_id)) {
                $query->where('pa.agency_id', '=', $request->agency_id);
            }
            if (isset($request->subsector_id) && !empty($request->subsector_id)) {
                $query->where('p.subsector_id', '=', $request->subsector_id);
            }
            if (isset($request->user_id) && !empty($request->user_id)) {
                $query->where('p.user_id', '=', $request->user_id);
            }
            
            $list_data = $query->select('pa.project_id')->get();
        }
        
        if ($list_data->isEmpty()) {
            $search_data = View::make('backend.search.revised_project_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'error',
                'message' => 'Data Not Found',
                'data' => $search_data->render()
            ];
        } else {
            $project_ids    =   [];
            foreach($list_data as $pd){
                $project_ids[]      =   $pd->project_id;
            }
            $list_data      =       ProjectEntryModel::orderBy('id', 'ASC')->whereIn('id', $project_ids)->get();
            $search_data = View::make('backend.search.revised_project_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data = [
                'status' => 'success',
                'message' => 'Data Found',
                'data' => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
    public function project_final_revision_store(Request $request) {
        $all = $request->all();
        DB::beginTransaction();
        try {

            /* ----------------------------------------------------------
             * Insert a new row into project version table
             * Insert a new row into project progress table
             * Insert a new row into project cost table
             * ---------------------------------------------------------
             */            
            $version_response = ProjectVersionsModel::create([
                        'project_id' => $request->project_id,
                        'project_type_id' => 2,
                        'projectcode' => $request->projectcode,
                        'pstatus' => 2, // insert as new project so the value is 1 
                        'rev_number' => $request->current_revision_number, // as a new project the rev_number is 0
                        'statusdate' => date('Y-m-d h:i:s', strtotime($request->revised_date)),
                        'qreview' => 0, // as a new project there is no review make so default value is 0;
                        'qrview_date' => null,
                        'is_deleted' => 0,
                        'user_id' => Auth::user()->id,
                        'deo_id' => Auth::user()->id,
                        'deo_date' => date('Y-m-d h:i:s'),
                    ])->id;

            // project Progress table as a Fourth Table Insert   
            $progress_response = ProjectProgressModel::create([
                        'project_id' => $request->project_id,
                        'pversion_id' => $version_response,
                        'progresstype' => "Appraisal",
                        'progressdate' => date('Y-m-d h:i:s'),
                        'progressdecision' => null, // as a new project there is no progressdecision make so default value is 0;
                        'proapp' => 0,
                        'proapp_date' => null,
                        'is_deleted' => 0,
                        'user_id' => Auth::user()->id,
            ])->id;

            // project agency table as a Second Table Insert
            $agresponse = ProjectcostModel::create([
                        'project_id' => $progress_response,
                        'implstartdate' => date('Y-m-d', strtotime($request->implstartdate)),
                        'implenddate' => date('Y-m-d', strtotime($request->implenddate)),
                        'expgobrev' => (isset($all['gob']['rev']) ? $all['gob']['rev'] : 0),
                        'expparev' => (isset($all['pa']['rev']) ? $all['pa']['rev'] : 0),
                        'expofundrev' => (isset($all['own']['rev']) ? $all['own']['rev'] : 0),
                        'expothersrev' => (isset($all['others']['rev']) ? $all['others']['rev'] : 0),
                        'expgobcap' => (isset($all['gob']['cap']) ? $all['gob']['cap'] : 0),
                        'exppacap' => (isset($all['pa']['cap']) ? $all['pa']['cap'] : 0),
                        'expofundcap' => (isset($all['own']['cap']) ? $all['own']['cap'] : 0),
                        'expotherscap' => (isset($all['others']['cap']) ? $all['others']['cap'] : 0),
                        'expgobcont' => (isset($all['gob']['con']) ? $all['gob']['con'] : 0),
                        'exppacont' => (isset($all['pa']['con']) ? $all['pa']['con'] : 0),
                        'expofundcont' => (isset($all['own']['con']) ? $all['own']['con'] : 0),
                        'expotherscont' => (isset($all['others']['con']) ? $all['others']['con'] : 0),
                        'gob_gt' => (isset($all['gob']['grand']) ? $all['gob']['grand'] : 0),
                        'pa_gt' => (isset($all['pa']['grand']) ? $all['pa']['grand'] : 0),
                        'own_gt' => (isset($all['own']['grand']) ? $all['own']['grand'] : 0),
                        'oth_gt' => (isset($all['others']['grand']) ? $all['others']['grand'] : 0),
                        'rev_total'            => (isset($all['all_total']['rev'])  ?  $all['all_total']['rev']:0),
                        'cap_total'            => (isset($all['all_total']['cap'])  ?  $all['all_total']['cap']:0),
                        'conph_total'          => (isset($all['all_total']['conph'])  ?  $all['all_total']['conph']:0),
                        'conpr_total'          => (isset($all['all_total']['conpr'])  ?  $all['all_total']['conpr']:0),
                        'sum_grand_total'      => (isset($all['all_total']['grand'])  ?  $all['all_total']['grand']:0),
                        'is_deleted' => 0,
                        'user_id' => Auth::user()->id,
                    ])->id; 
            $details = ProjectEntryModel::find($request->project_id);
            $details->update([                
                'quality_review_identity'   =>  1,
                'user_id'                   =>  Auth::user()->id,
            ]);

            DB::commit();
            //revised_project_search
            return redirect("admin/project/revised_projects")
            ->with('success', 'Data have been revised successfully.');
            
        } catch (\Exception $e) {
            DB::rollback();
            echo "something went wrong";
        }
    }
    
    public function project_download(Request $request){
        
//        return view('backend.pdf.project_profile_view');
        
        $pdf = \PDF::loadView('backend.pdf.project_profile_view');
        
        return $pdf->download('project_profile.pdf');
         
    }
    public function project_doc_download(Request $request) {

        $view = View::make('backend.pdf.ppview');
        $contents = $view->render();
        $pw = new \PhpOffice\PhpWord\PhpWord();

        /* [THE HTML] */
        $section = $pw->addSection();
        $html = "<h1>HELLO WORLD!</h1>";
        $html .= "<p>This is a paragraph of random text</p>";
        $html .= "<table><tr><td>A table</td><td>Cell</td></tr></table>";
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $contents, false, false);

        /* [SAVE FILE ON THE SERVER] */
        // $pw->save("html-to-doc.docx", "Word2007");

        /* [OR FORCE DOWNLOAD] */
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="project_profile.docx"');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, 'Word2007');
        $objWriter->save('php://output');
    }

    public function plis_gis(){
        $list_title     =   "PLIS-GIS";
        $list_url       =   $this->list_url;
        $active_menu    =   "plis_gis";
        $page           =   "Update"; 
        return view('backend.project.project_plis_gis', compact('list_title','list_url','page','active_menu'));
    } 
    
    public function update_cost_table(){
        $updated_ids    =   [];
        $project = ProjectEntryModel::all();
        foreach($project as $p){
            $latest_project_version =   get_project_version_id_by_project_id($p->id);
            if(isset($latest_project_version) && !empty($latest_project_version)){
                $version_id =   $latest_project_version->id;               
                $costData   =   DB::table('projectcosts')
                    ->where('project_id', $p->id)
                    ->first();
                if(isset($costData) && !empty($costData)){
                    DB::table('projectcosts')
                    ->where('id', $costData->id)
                    ->update([
                        'project_id'       => $version_id
                        ]);
                    $updated_ids[]  =  $p->id; 
                }                
            }            
        }// end of project for loop
        print "<pre>";
        print_r($updated_ids);
        print "</pre>";
        exit;
        
    }
    
    // start all project progress related information
    public function project_progress(){
        $list_title     =   "Project Progress List";
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/project_progress_view";
        $active_menu    =   "project_progress";
        $page           =   "List";
        $list_data      =       ProjectEntryModel::orderBy('updated_at', 'DESC')->where('protemp','=',3)->where('is_deleted','=',0)->where('quality_review_identity','=',0)->get();//quality_review_identity       
        
        // get all table data:
        return view('backend.project.project_progress', compact('list_title','list_data','create_url','edit_url','list_url','page','active_menu'));
    }
    
    // project progress view method
    
    public function project_progress_view(Request $request){
        $progress_id    =   null;
        $list_title     =   "Project Progress";;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/project_progress_edit";
        $active_menu    =   "project_progress";
        $page           =   "Project Progress";
        $back           =   "admin/project/project_progress";
        $project_data   = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_type   = get_project_type_by_project_id($request->project_id);
        $project_agency_data  = ProjectAgenciesyModel::where('project_id', $request->project_id)->first();
        if(isset($request->progress_id) && !empty($request->progress_id)){
            $progress_id    =   $request->progress_id;
        }
        Session::put('project_id', $request->project_id);
        return view('backend.project.project_progress_details_landing_view', compact('progress_id','list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu','back'));
    }
    
    //project_progress_store
    
    public function project_progress_store(Request $request) {
        $all = $request->all();
        if ($request->page_type == "Create") {
            
            $redirect_url   =   "admin/project/project_progress_view/".$request->project_id;
            //Define Rules
            $rules = [
                'progress_type'         => 'required',
//                'gob.rev'               => 'required',
                'implstartdate'         => 'required',
                'implenddate'           => 'required'
            ];
            
            if(isset($request->project_approve) && !empty($request->project_approve)){
                $rules = [
                    'progress_type'         => 'required',
//                    'gob.rev'               => 'required',
                    'implstartdate'         => 'required',
                    'implenddate'           => 'required',
                    'approve_date'           => 'required'
                ];
            }
            
            // Create a new validator instance
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect($redirect_url)
                                ->withErrors($validator)
                                ->withInput()
                                ->with('error', 'Failed to save data');
            }
            
            DB::beginTransaction();
            try {

                /* ----------------------------------------------------------
                 * Insert a new row into project progress table
                 * Insert a new row into project cost table
                 * ---------------------------------------------------------
                 */
                $progress_response = ProjectProgressModel::create([
                            'project_id' => $request->project_id,
                            'pversion_id' => $request->project_version_id,
                            'progresstype' => $request->progress_type,
                            'progressdate' => date('Y-m-d', strtotime($request->progress_date)),
                            'progressdecision' => (isset($request->decision) ? $request->decision : null), // as a new project there is no progressdecision make so default value is 0;
                            'proapp' => (isset($request->project_approve) ? $request->project_approve : 0),
                            'proapp_date' => (isset($request->revised_date) ? date('Y-m-d', strtotime($request->revised_date)) : null),
                            'is_deleted' => 0,
                            'user_id' => Auth::user()->id,
                        ])->id;

                // project agency table as a Second Table Insert
                $agresponse = ProjectcostModel::create([
                            'project_id' => $progress_response,
                            'implstartdate' => date('Y-m-d', strtotime($request->implstartdate)),
                            'implenddate' => date('Y-m-d', strtotime($request->implenddate)),
                            'expgobrev' => (isset($all['gob']['rev']) ? $all['gob']['rev'] : 0),
                            'expparev' => (isset($all['pa']['rev']) ? $all['pa']['rev'] : 0),
                            'expofundrev' => (isset($all['own']['rev']) ? $all['own']['rev'] : 0),
                            'expothersrev' => (isset($all['others']['rev']) ? $all['others']['rev'] : 0),
                            'expgobcap' => (isset($all['gob']['cap']) ? $all['gob']['cap'] : 0),
                            'exppacap' => (isset($all['pa']['cap']) ? $all['pa']['cap'] : 0),
                            'expofundcap' => (isset($all['own']['cap']) ? $all['own']['cap'] : 0),
                            'expotherscap' => (isset($all['others']['cap']) ? $all['others']['cap'] : 0),
                            'expgobcont' => (isset($all['gob']['con']) ? $all['gob']['con'] : 0),
                            'exppacont' => (isset($all['pa']['con']) ? $all['pa']['con'] : 0),
                            'expofundcont' => (isset($all['own']['con']) ? $all['own']['con'] : 0),
                            'expotherscont' => (isset($all['others']['con']) ? $all['others']['con'] : 0),
                            'gob_gt' => (isset($all['gob']['grand']) ? $all['gob']['grand'] : 0),
                            'pa_gt' => (isset($all['pa']['grand']) ? $all['pa']['grand'] : 0),
                            'own_gt' => (isset($all['own']['grand']) ? $all['own']['grand'] : 0),
                            'oth_gt' => (isset($all['others']['grand']) ? $all['others']['grand'] : 0),
                    
                            'rev_total'            => (isset($all['all_total']['rev'])  ?  $all['all_total']['rev']:0),
                            'cap_total'            => (isset($all['all_total']['cap'])  ?  $all['all_total']['cap']:0),
                            'conph_total'          => (isset($all['all_total']['conph'])  ?  $all['all_total']['conph']:0),
                            'conpr_total'          => (isset($all['all_total']['conpr'])  ?  $all['all_total']['conpr']:0),
                            'sum_grand_total'      => (isset($all['all_total']['grand'])  ?  $all['all_total']['grand']:0),
                    
                            'is_deleted' => 0,
                            'user_id' => Auth::user()->id,
                        ])->id;
                
                if(isset($request->project_approve) && !empty($request->project_approve)){
                    DB::table('projects')
                        ->where('id', $request->project_id)
                        ->update([
                            'protemp'                       => 2,// 2 means yes project is approved
                            ]);
                }
                
                DB::commit();
                //revised_project_search
                return redirect("admin/project/project_progress")
                                ->with('success', 'Progress data have been saved successfully.');
            } catch (\Exception $e) {
                DB::rollback();
                 print "<pre>";
                dd($e);
                print "<pre>";
                echo "something went wrong";
            }
        } else {
            $redirect_url   =   "admin/project/project_progress_view/".$request->project_id."/".$request->project_progress_id;
            //Define Rules
            $rules = [
                'progress_type'         => 'required',
//                'gob.rev'               => 'required',
                'implstartdate'         => 'required',
                'implenddate'           => 'required'
            ];
            if(isset($request->project_approve) && !empty($request->project_approve)){
                $rules = [
                    'progress_type'         => 'required',
//                    'gob.rev'               => 'required',
                    'implstartdate'         => 'required',
                    'implenddate'           => 'required',
                    'approve_date'           => 'required'
                ];
            }
            // Create a new validator instance
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect($redirect_url)
                                ->withErrors($validator)
                                ->withInput()
                                ->with('error', 'Failed to save data');
            }
            DB::beginTransaction();
            try {
                $project_cost_details = ProjectcostModel::find($request->project_cost_id);
                $project_cost_details->update([
                    'project_id' => $request->project_progress_id,
                    'implstartdate' => date('Y-m-d', strtotime($request->implstartdate)),
                    'implenddate' => date('Y-m-d', strtotime($request->implenddate)),
                    'expgobrev' => (isset($all['gob']['rev']) ? $all['gob']['rev'] : 0),
                    'expparev' => (isset($all['pa']['rev']) ? $all['pa']['rev'] : 0),
                    'expofundrev' => (isset($all['own']['rev']) ? $all['own']['rev'] : 0),
                    'expothersrev' => (isset($all['others']['rev']) ? $all['others']['rev'] : 0),
                    'expgobcap' => (isset($all['gob']['cap']) ? $all['gob']['cap'] : 0),
                    'exppacap' => (isset($all['pa']['cap']) ? $all['pa']['cap'] : 0),
                    'expofundcap' => (isset($all['own']['cap']) ? $all['own']['cap'] : 0),
                    'expotherscap' => (isset($all['others']['cap']) ? $all['others']['cap'] : 0),
                    'expgobcont' => (isset($all['gob']['con']) ? $all['gob']['con'] : 0),
                    'exppacont' => (isset($all['pa']['con']) ? $all['pa']['con'] : 0),
                    'expofundcont' => (isset($all['own']['con']) ? $all['own']['con'] : 0),
                    'expotherscont' => (isset($all['others']['con']) ? $all['others']['con'] : 0),
                    'gob_gt' => (isset($all['gob']['grand']) ? $all['gob']['grand'] : 0),
                    'pa_gt' => (isset($all['pa']['grand']) ? $all['pa']['grand'] : 0),
                    'own_gt' => (isset($all['own']['grand']) ? $all['own']['grand'] : 0),
                    'oth_gt' => (isset($all['others']['grand']) ? $all['others']['grand'] : 0),
                    
                    'rev_total'            => (isset($all['all_total']['rev'])  ?  $all['all_total']['rev']:0),
                    'cap_total'            => (isset($all['all_total']['cap'])  ?  $all['all_total']['cap']:0),
                    'conph_total'          => (isset($all['all_total']['conph'])  ?  $all['all_total']['conph']:0),
                    'conpr_total'          => (isset($all['all_total']['conpr'])  ?  $all['all_total']['conpr']:0),
                    'sum_grand_total'      => (isset($all['all_total']['grand'])  ?  $all['all_total']['grand']:0),
                    'is_deleted' => 0,
                    'user_id' => Auth::user()->id,
                ]);

                $project_progress_details = ProjectProgressModel::find($request->project_progress_id);
                $project_progress_details->update([
                    'project_id' => $request->project_id,
                    'pversion_id' => $request->project_version_id,
                    'progresstype' => $request->progress_type,
                    'progressdate' => date('Y-m-d', strtotime($request->progress_date)),
                    'progressdecision' => (isset($request->decision) ? $request->decision : null), // as a new project there is no progressdecision make so default value is 0;
                    'proapp' => (isset($request->project_approve) ? $request->project_approve : 0),
                    'proapp_date' => (isset($request->revised_date) ? date('Y-m-d', strtotime($request->revised_date)) : null),
                    'is_deleted' => 0,
                    'user_id' => Auth::user()->id,
                ]);
                
                if(isset($request->project_approve) && !empty($request->project_approve)){
                    DB::table('projects')
                        ->where('id', $request->project_id)
                        ->update([
                            'protemp'                       => 2,// 2 means yes project is approved
                            ]);
                }
                DB::commit();
                //revised_project_search
                return redirect("admin/project/project_progress")
                                ->with('success', 'Progress data have been updated successfully.');
            } catch (\Exception $e) {                
                DB::rollback();
                print "<pre>";
                print_r($e);
                print "<pre>";
                echo "something went wrong";
            }
        }// end of eupdate block
    }
    
    // project progress search
    public function project_progress_search(Request $request){
        /*
         * <pre>Array
            (
                [search_project] => ABC = done
                [ministry_id] => 29                 = done
                [agency_id] => 1                    = done
                [project_cost_filter] =>            = done
                [cost_filter_amount] => 1000        = done
                [pcdivision_id] => 1                = done
                [subsector_id] => 1                 = done
                [search_from_date] => 22-09-2018    = done
                [search_to_date] => 30-09-2018      = done
                [project_type] => new
                [progress_type] => PEC
            )
            </pre>
         * 
            * $all_request    =   $request->all();
               print "<pre>";
               print_r($all_request);
               print "</pre>";
               exit;
         */
        $progress_type  =   false; // to findout the actual project progress we eed this param
        $list_data  =   [];
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = "/admin/project/project_progress_view";
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query      =     DB::table('projects as p')
                          ->join('projectcosts as pc'       ,'pc.project_id','=','p.id')
                          ->join('projectagencies as pa'    ,'p.id','=','pa.project_id')
                          ->join('project_versions as pv'    ,'p.id','=','pv.project_id')
                          ->join('project_progress as pp'    ,'p.id','=','pp.project_id')
                          ->where('p.protemp','=',3) // 3 means project is now in progress state 
                          ->where('p.is_deleted','=',0)
                          ->where('p.quality_review_identity','=',0)
                          ->groupBy('pa.project_id');
        //where('protemp','=',2)->where('is_deleted','=',0)->where('quality_review_identity','=',0)

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->select('pa.project_id')->get();
        } else {
            if (isset($request->search_project) && !empty($request->search_project)) {
                $query->where('p.project_name_eng', 'like', '%' . $request->search_project . '%');
            }
            if (isset($request->search_from_date) && !empty($request->search_from_date)) {
                $from_date      =   date("Y-m-d", strtotime($request->search_from_date));
                $query->where('pc.implstartdate', '>=', $from_date);
            }            
            if (isset($request->search_to_date) && !empty($request->search_to_date)) {
                $to_date      =   date("Y-m-d", strtotime($request->search_to_date));
                $query->where('pc.implenddate', '<=', $to_date);
            }
            if (isset($request->project_cost_filter) && !empty($request->project_cost_filter)) {
                if (isset($request->cost_filter_amount) && !empty($request->cost_filter_amount)) {
                    $query->where('pc.sum_grand_total', $request->project_cost_filter, $request->cost_filter_amount);
                }
            }
            if (isset($request->pcdivision_id) && !empty($request->pcdivision_id)) {
                $query->where('p.pcdivision_id', '=', $request->pcdivision_id);
            }
            if (isset($request->ministry_id) && !empty($request->ministry_id)) {
                $query->where('pa.ministry_id', '=', $request->ministry_id);
            }
            if (isset($request->agency_id) && !empty($request->agency_id)) {
                $query->where('pa.agency_id', '=', $request->agency_id);
            }
            if (isset($request->subsector_id) && !empty($request->subsector_id)) {
                $query->where('p.subsector_id', '=', $request->subsector_id);
            }
            if (isset($request->subsector_id) && !empty($request->subsector_id)) {
                $query->where('p.subsector_id', '=', $request->subsector_id);
            }
            if (isset($request->progress_type) && !empty($request->progress_type)) {
                $progress_type  =   true;
                $query->where('pp.progresstype', '=', $request->progress_type);
            }   
        }
        $list_data = $query->select('pa.project_id')->get();
        if ($list_data->isEmpty()) {            
            $search_data    = View::make('backend.search.project_progress_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data  = [
                'status'    => 'error',
                'message'   => 'Data Not Found',
                'data'      => $search_data->render()
            ];
        } else {
            $project_ids    =   [];
            foreach($list_data as $pd){
                // get project version id
                $project_versions   =   get_project_version_id_by_project_id($pd->project_id);
                // get latest projects progress id

                $project_progress   =   get_project_progress_id_by_project_id($project_versions->id); 
                if($progress_type){
                    if($project_progress->progresstype == $request->progress_type){
                        $project_ids[]      =   $pd->project_id;
                    }
                }else{
                    $project_ids[]      =   $pd->project_id;
                }
            }
            $list_data      =       ProjectEntryModel::orderBy('id', 'ASC')->whereIn('id', $project_ids)->get();
            $search_data    =       View::make('backend.search.project_progress_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data  = [
                'status'    => 'success',
                'message'   => 'Data Found',
                'data'      => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
    // project progress view method
    
    public function on_project_progress(Request $request){
        $progress_id    =   null;
        $list_title     =   "Project Progress";;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/project_progress_edit";
        $active_menu    =   "project_progress";
        $page           =   "Project Progress";
        $back           =   "admin/project/project_progress";
        $project_data   = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_type   = get_project_type_by_project_id($request->project_id);
        $project_agency_data  = ProjectAgenciesyModel::where('project_id', $request->project_id)->first();
        if(isset($request->progress_id) && !empty($request->progress_id)){
            $progress_id    =   $request->progress_id;
        }
        Session::put('project_id', $request->project_id);
        return view('backend.project.on_project_progress', compact('progress_id','list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu','back'));
    }
    public function approved_project(){
        $user_type    =   getRoleIdByUserId(Auth::user()->id);        
        $list_title     =   'Approved project';
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/revised_projects_view";
        $active_menu    =   'approved';
        $page           =   "List";
        
        return view('backend.project.approved_project_list', compact('list_title','list_data','create_url','edit_url','list_url','page','active_menu'));
    }
    // project progress search
    public function approved_project_search(Request $request){
        $user_type    =   getRoleIdByUserId(Auth::user()->id);
        /*
         * <pre>Array
            (
                [search_project] => ABC = done
                [ministry_id] => 29                 = done
                [agency_id] => 1                    = done
                [project_cost_filter] =>            = done
                [cost_filter_amount] => 1000        = done
                [pcdivision_id] => 1                = done
                [subsector_id] => 1                 = done
                [search_from_date] => 22-09-2018    = done
                [search_to_date] => 30-09-2018      = done
                [project_type] => new
                [progress_type] => PEC
            )
            </pre>
         * 
            * $all_request    =   $request->all();
               print "<pre>";
               print_r($all_request);
               print "</pre>";
               exit;
         */
        $progress_type  =   false; // to findout the actual project progress we eed this param
        $list_data  =   [];
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = "/admin/project/approved_projects_landing_view";
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query      =     DB::table('projects as p')
                          ->join('projectcosts as pc'       ,'pc.project_id','=','p.id')
                          ->join('projectagencies as pa'    ,'p.id','=','pa.project_id')
                          ->join('project_versions as pv'    ,'p.id','=','pv.project_id')
                          ->join('project_progress as pp'    ,'p.id','=','pp.project_id')
                          ->join('projectlocations as pl'    ,'p.id','=','pl.project_id')
                          ->where('p.protemp','=',2) // 2 means project is now approved 
                          ->where('p.is_deleted','=',0)
                          ->where('p.quality_review_identity','=',0)
                          ->groupBy('pa.project_id');
        //where('protemp','=',2)->where('is_deleted','=',0)->where('quality_review_identity','=',0)

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->select('pa.project_id')->get();
        } else {
            if (isset($request->search_project) && !empty($request->search_project)) {
                $query->where('p.project_name_eng', 'like', '%' . $request->search_project . '%');
            }
            if (isset($request->search_from_date) && !empty($request->search_from_date)) {
                $from_date      =   date("Y-m-d", strtotime($request->search_from_date));
                $query->where('pc.implstartdate', '>=', $from_date);
            }            
            if (isset($request->search_to_date) && !empty($request->search_to_date)) {
                $to_date      =   date("Y-m-d", strtotime($request->search_to_date));
                $query->where('pc.implenddate', '<=', $to_date);
            }
            if (isset($request->project_cost_filter) && !empty($request->project_cost_filter)) {
                if (isset($request->cost_filter_amount) && !empty($request->cost_filter_amount)) {
                    $query->where('pc.sum_grand_total', $request->project_cost_filter, $request->cost_filter_amount);
                }
            }
            if (isset($request->pcdivision_id) && !empty($request->pcdivision_id)) {
                $query->where('p.pcdivision_id', '=', $request->pcdivision_id);
            }
            if (isset($request->wing_id) && !empty($request->wing_id)) {
                $query->where('p.wing_id', '=', $request->wing_id);
            }
            if (isset($request->ministry_id) && !empty($request->ministry_id)) {
                $query->where('pa.ministry_id', '=', $request->ministry_id);
            }
            if (isset($request->agency_id) && !empty($request->agency_id)) {
                $query->where('pa.agency_id', '=', $request->agency_id);
            }
            if (isset($request->subsector_id) && !empty($request->subsector_id)) {
                $query->where('p.subsector_id', '=', $request->subsector_id);
            }
            if (isset($request->subsector_id) && !empty($request->subsector_id)) {
                $query->where('p.subsector_id', '=', $request->subsector_id);
            }
            if (isset($request->progress_type) && !empty($request->progress_type)) {
                $progress_type  =   true; 
                $query->where('pp.progresstype', '=', $request->progress_type);
            }
            if (isset($request->district_id) && !empty($request->district_id)) {
                $query->where('pl.district_id', '=', $request->district_id);
            }
            if (isset($request->upz_id) && !empty($request->upz_id)) {
                $query->where('pl.upz_id', '=', $request->upz_id);
            }
            if (isset($request->city_corp_id) && !empty($request->city_corp_id)) {
                $query->where('pl.city_corp_id', '=', $request->city_corp_id);
            }
            if (isset($request->ward_id) && !empty($request->ward_id)) {
                $query->where('pl.ward_id', '=', $request->ward_id);
            }
            if (isset($request->union_id) && !empty($request->union_id)) {
                $query->where('pl.union_id', '=', $request->union_id);
            }
            // get all table data:
            if($user_type != 4){
                $query->where('p.user_id', '=', Auth::user()->id);
            }   
        }
        $list_data = $query->select('pa.project_id')->get();
        if ($list_data->isEmpty()) {            
            $search_data    = View::make('backend.search.approve_project_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data  = [
                'status'    => 'error',
                'message'   => 'Data Not Found',
                'data'      => $search_data->render()
            ];
        } else {
            $project_ids    =   [];
            foreach($list_data as $pd){
                // get project version id
                $project_versions   =   get_project_version_id_by_project_id($pd->project_id);
                // get latest projects progress id

                $project_progress   =   get_project_progress_id_by_project_id($project_versions->id); 
                if($progress_type){
                    if($project_progress->progresstype == $request->progress_type){
                        $project_ids[]      =   $pd->project_id;
                    }
                }else{
                    $project_ids[]      =   $pd->project_id;
                }
                
            }
            $list_data      =       ProjectEntryModel::orderBy('id', 'ASC')->whereIn('id', $project_ids)->get();
            $search_data    =       View::make('backend.search.approve_project_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data  = [
                'status'    => 'success',
                'message'   => 'Data Found',
                'data'      => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
    // temporary map data 
    public function approved_projects_landing_view(Request $request){
        $list_title     =   "Approved project";;
        $create_url     =   $this->create_url;
        $list_url       =   $this->list_url;
        $edit_url       =   "/admin/project/approved_projects_landing_view";
        $active_menu    =   "revised_project";
        $page           =   "Revised Project";
        $project_data  = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_type   = get_project_type_by_project_id($request->project_id);
        //"quality_control";
        if($project_type->protemp == 0){
            $this->active_menu = "quality_control";
            $back   =   "admin/project/project_quality_review_view/";
        }elseif($project_type->protemp == 1){
            //"temporary project";
            $this->active_menu = "project";
            $back   =   "admin/project/temporary_project_view/";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==0){
            //"revised project";
            $this->active_menu = "project";
            $back   =   "admin/project/revised_projects";
        }elseif($project_type->protemp == 2 && $project_data->quality_review_identity==1){
            //"revised project";
            $this->active_menu = "quality_control";
            $back   =   "admin/project/revised_project_quality_review_view/";
        }
        $active_menu    =   $this->active_menu;
        // get all table data:
        $project_data  = ProjectEntryModel::where('id', $request->project_id)->first();
        $project_agency_data  = ProjectAgenciesyModel::where('project_id', $request->project_id)->first();
        Session::put('project_id', $request->project_id);
        // this session information will be needed o truck the right back button link address
        Session::put('project_vew_as', "revised_project");
        return view('backend.project.approved_project_details_landing_view', compact('list_title','project_data','project_agency_data','create_url','edit_url','list_url','page','active_menu','back'));
    }
    public function get_map_upazila_details(Request $request){
        $all    =   $request->all();
        switch($all['upz_id']){
            case "302672":
                $location   =   '/map/upazila/Dhaka/Dhaka-Dhaka-Dhaka-Savar.json';
                break;
            case "302614":
                $location   =   '/map/upazila/Dhaka/Dhaka-Dhaka-Dhaka-Dhamrai.json';
                break;
            case "302618":
                $location   =   '/map/upazila/Dhaka/Dhaka-Dhaka-Dhaka-Dohar.json';
                break;
            case "302638":
                $location   =   '/map/upazila/Dhaka/Dhaka-Dhaka-Dhaka-Keraniganj.json';
                break;
            case "302662":
                $location   =   '/map/upazila/Dhaka/Dhaka-Dhaka-Dhaka-Nawabganj.json';
                break;
            default:
                $location   =   '/map/upazila/Dhaka/Dhaka-Dhaka-Dhaka-Savar.json';
                break;
        } // end of switch case
        $feedback_data  =   [
            'status'    => "success",
            'data'      => asset($location),
            'message'   => "Found Upazila"
        ];
        
        echo json_encode($feedback_data);
    }
    
    public function on_progress_project_search(Request $request){
        /*
         * <pre>Array
            (
                [search_project] => ABC = done
                [ministry_id] => 29                 = done
                [agency_id] => 1                    = done
                [project_cost_filter] =>            = done
                [cost_filter_amount] => 1000        = done
                [pcdivision_id] => 1                = done
                [subsector_id] => 1                 = done
                [search_from_date] => 22-09-2018    = done
                [search_to_date] => 30-09-2018      = done
                [project_type] => new
                [progress_type] => PEC
            )
            </pre>
         * 
            * $all_request    =   $request->all();
               print "<pre>";
               print_r($all_request);
               print "</pre>";
               exit;
         */
        $progress_type  =   false; // to findout the actual project progress we eed this param
        $list_data  =   [];
        $list_title = $this->list_title;
        $create_url = $this->create_url;
        $list_url = $this->list_url;
        $edit_url = "/admin/project/project_progress_view";
        $active_menu    =   $this->active_menu;
        $page = "List";
        // get all table data:
        $query      =     DB::table('projects as p')
                          ->join('projectcosts as pc'       ,'pc.project_id','=','p.id')
                          ->join('projectagencies as pa'    ,'p.id','=','pa.project_id')
                          ->join('project_versions as pv'    ,'p.id','=','pv.project_id')
                          ->join('project_progress as pp'    ,'p.id','=','pp.project_id')
                          ->where('p.protemp','=',3) // 3 means project is now in progress state 
                          ->where('p.is_deleted','=',0)
                          ->where('p.quality_review_identity','=',0)
                          ->groupBy('pa.project_id');
        //where('protemp','=',2)->where('is_deleted','=',0)->where('quality_review_identity','=',0)

        if (isset($request->all) && !empty($request->all)) {
            $list_data = $query->select('pa.project_id')->get();
        } else {
            if (isset($request->search_project) && !empty($request->search_project)) {
                $query->where('p.project_name_eng', 'like', '%' . $request->search_project . '%');
            }
            if (isset($request->search_from_date) && !empty($request->search_from_date)) {
                $from_date      =   date("Y-m-d", strtotime($request->search_from_date));
                $query->where('pc.implstartdate', '>=', $from_date);
            }            
            if (isset($request->search_to_date) && !empty($request->search_to_date)) {
                $to_date      =   date("Y-m-d", strtotime($request->search_to_date));
                $query->where('pc.implenddate', '<=', $to_date);
            }
            if (isset($request->project_cost_filter) && !empty($request->project_cost_filter)) {
                if (isset($request->cost_filter_amount) && !empty($request->cost_filter_amount)) {
                    $query->where('pc.sum_grand_total', $request->project_cost_filter, $request->cost_filter_amount);
                }
            }
            if (isset($request->pcdivision_id) && !empty($request->pcdivision_id)) {
                $query->where('p.pcdivision_id', '=', $request->pcdivision_id);
            }
            if (isset($request->wing_id) && !empty($request->wing_id)) {
                $query->where('p.wing_id', '=', $request->wing_id);
            }
            if (isset($request->ministry_id) && !empty($request->ministry_id)) {
                $query->where('pa.ministry_id', '=', $request->ministry_id);
            }
            if (isset($request->agency_id) && !empty($request->agency_id)) {
                $query->where('pa.agency_id', '=', $request->agency_id);
            }
            if (isset($request->subsector_id) && !empty($request->subsector_id)) {
                $query->where('p.subsector_id', '=', $request->subsector_id);
            }
            if (isset($request->subsector_id) && !empty($request->subsector_id)) {
                $query->where('p.subsector_id', '=', $request->subsector_id);
            }
            if (isset($request->progress_type) && !empty($request->progress_type)) {
                $progress_type  =   true;
                $query->where('pp.progresstype', '=', $request->progress_type);
            }   
        }
        $list_data = $query->select('pa.project_id')->get();
        if ($list_data->isEmpty()) {            
            $search_data    = View::make('backend.search.project_progress_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data  = [
                'status'    => 'error',
                'message'   => 'Data Not Found',
                'data'      => $search_data->render()
            ];
        } else {
            $project_ids    =   [];
            foreach($list_data as $pd){
                // get project version id
                $project_versions   =   get_project_version_id_by_project_id($pd->project_id);
                // get latest projects progress id

                $project_progress   =   get_project_progress_id_by_project_id($project_versions->id); 
                if($progress_type){
                    if($project_progress->progresstype == $request->progress_type){
                        $project_ids[]      =   $pd->project_id;
                    }
                }else{
                    $project_ids[]      =   $pd->project_id;
                }
            }
            $list_data      =       ProjectEntryModel::orderBy('id', 'ASC')->whereIn('id', $project_ids)->get();
            $search_data    =       View::make('backend.search.on_progress_project_search_list', compact('list_data', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data  = [
                'status'    => 'success',
                'message'   => 'Data Found',
                'data'      => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }

}
