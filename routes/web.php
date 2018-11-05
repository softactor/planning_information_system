<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|---------------------------------------------------------------------------
| Landing Url
|---------------------------------------------------------------------------

*/
Route::get('/', function () {
    return view('frontend.home');
});

/*
|---------------------------------------------------------------------------
| Auth
|---------------------------------------------------------------------------

*/
Auth::routes();

/*
|---------------------------------------------------------------------------
| Admin Dashboard
|---------------------------------------------------------------------------

*/
Route::group(['namespace'   =>  'Backend', 'prefix'   =>  'admin', 'middleware' =>  'auth'], function(){
    
    Route::get('dashbord','Dashboard@index')->name('dashbord');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('roles', 'RolesController');
    Route::resource('users', 'UsersController');
    Route::post('users/searchUsers',     'UsersController@searchUsers');
    /*
     * =========================================================================
     * Route Assign
     * =========================================================================
     */
    Route::get('dashbord/role_assign','Dashboard@user_role_assign');
    Route::post('dashbord/role_assign_store','Dashboard@user_role_assign_store');
    Route::get('dashbord/getAllPageAccess','Dashboard@getAllPageAccess');
    Route::get('dashbord/loadDivisionByDistrict',     'Dashboard@loadDivisionByDistrict');
    Route::get('dashbord/loadUpazilaByDistrict',     'Dashboard@loadUpazilaByDistrict');
    Route::get('dashbord/loadConstituencyByUpz',     'Dashboard@loadConstituencyByUpz');
    Route::get('dashbord/loadConstituencyByUnion',     'Dashboard@loadConstituencyByUnion');
    Route::get('dashbord/loadConstituencyByWard',     'Dashboard@loadConstituencyByWard');
    Route::get('dashbord/loadWingByPcDivision',     'Dashboard@loadWingByPcDivision');
    Route::get('dashbord/common_delete',     'Dashboard@common_delete');
    Route::get('dashbord/on_page_edit_data',     'Dashboard@on_page_edit_data');
    Route::get('dashbord/getDivisionByDistrict',     'Dashboard@getDivisionByDistrict');
    Route::get('dashbord/loadUnionByUpazila',     'Dashboard@loadUnionByUpazila');
    Route::get('dashbord/loadAgencyByMinstry',     'Dashboard@loadAgencyByMinstry');
    
    /*
     * =========================================================================
     * Ministry route
     * =========================================================================
     */
    Route::get('ministry',          'Ministry\Ministry@index');
    Route::get('ministry/create',   'Ministry\Ministry@create');
    // store ministry item
    Route::post('ministry/store',     'Ministry\Ministry@store');
    // edit view
    Route::get('ministry/edit/{id}',     'Ministry\Ministry@edit_view');
    Route::post('ministry/update',     'Ministry\Ministry@update');
    Route::get('ministry/csv_upload',   'Ministry\Ministry@csv_upload');
    
    Route::post('ministry/searchMinistry',     'Ministry\Ministry@searchMinistry');
    
    /*
     * =========================================================================
     * Agency route
     * =========================================================================
     */
    Route::get('agency',            'Agency\Agency@index');
    Route::get('agency/create',     'Agency\Agency@create');
    // store agency item
    Route::post('agency/store',     'Agency\Agency@store');
    // edit view
    Route::get('agency/edit/{id}',     'Agency\Agency@edit_view');
    Route::post('agency/update',     'Agency\Agency@update');
    Route::get('agency/csv_upload',   'Agency\Agency@csv_upload');
    Route::post('agency/searchAgency',     'Agency\Agency@searchAgency');
    /*
     * =========================================================================
     * Wing route
     * =========================================================================
     */
    Route::get('wing',            'Wing\Wing@index');
    Route::get('wing/create',     'Wing\Wing@create'); 
    // store wing item
    Route::post('wing/store',     'Wing\Wing@store');
    // edit view
    Route::get('wing/edit/{id}',     'Wing\Wing@edit_view');
    Route::post('wing/update',     'Wing\Wing@update');
    Route::get('wing/csv_upload',   'Wing\Wing@csv_upload');
    
    Route::post('wing/searchWing',     'Wing\Wing@searchWing');
    
    /*
     * =========================================================================
     * Sector route
     * =========================================================================
     */
    Route::get('sector',            'Sector\Sector@index');
    Route::get('sector/create',     'Sector\Sector@create');
    // store sector item
    Route::post('sector/store',     'Sector\Sector@store');
    // edit view
    Route::get('sector/edit/{id}',     'Sector\Sector@edit_view');
    Route::post('sector/update',     'Sector\Sector@update');
    Route::get('sector/csv_upload',   'Sector\Sector@csv_upload');
    
    /*
     * =========================================================================
     * Subsector route
     * =========================================================================
     */
    Route::get('subsector',            'Subsector\Subsector@index');
    Route::get('subsector/create',     'Subsector\Subsector@create');
    // store subsector item
    Route::post('subsector/store',     'Subsector\Subsector@store');
    // edit view
    Route::get('subsector/edit/{id}',     'Subsector\Subsector@edit_view');
    Route::post('subsector/update',     'Subsector\Subsector@update');
    Route::get('subsector/csv_upload',   'Subsector\Subsector@csv_upload');
    
    Route::post('subsector/searchSubsector',     'Subsector\Subsector@searchSubsector');
    
    /*
     * =========================================================================
     * Gisobject route
     * =========================================================================
     */
    Route::get('gisobject',            'Gisobject\Gisobject@index');
    Route::get('gisobject/create',     'Gisobject\Gisobject@create');
    // store gisobject item
    Route::post('gisobject/store',     'Gisobject\Gisobject@store');
    // edit view
    Route::get('gisobject/edit/{id}',     'Gisobject\Gisobject@edit_view');
    Route::post('gisobject/update',     'Gisobject\Gisobject@update');
    
    Route::post('gisobject/searchGisobject',     'Gisobject\Gisobject@searchGisobject');
    /*
     * =========================================================================
     * Commonconf route
     * =========================================================================
     */
    Route::get('commonconf',            'Commonconf\Commonconf@index');
    Route::get('commonconf/create',     'Commonconf\Commonconf@create');
    // store config item
    Route::post('commonconf/store',     'Commonconf\Commonconf@store');
    // edit view
    Route::get('commonconf/edit/{id}',     'Commonconf\Commonconf@edit_view');
    Route::post('commonconf/update',     'Commonconf\Commonconf@update');
    Route::get('commonconf/csv_upload',     'Commonconf\Commonconf@csv_upload');
    
    Route::post('commonconf/searchCommonconf',     'Commonconf\Commonconf@searchCommonconf');
    
    /*
     * =========================================================================
     * Constituency route
     * =========================================================================
     */
    Route::get('constituency',            'Constituency\Constituency@index');
    Route::get('constituency/csv_upload', 'Constituency\Constituency@csv_upload');
    // edit view
    Route::get('constituency/edit/{id}',     'Constituency\Constituency@edit_view');
    Route::post('constituency/update',     'Constituency\Constituency@update');
    Route::post('constituency/store',     'Constituency\Constituency@store');
    Route::get('constituency/create',     'Constituency\Constituency@create');
    Route::post('constituency/searchConstituency',     'Constituency\Constituency@searchConstituency');
    /*
     * =========================================================================
     * Division route
     * =========================================================================
     */
    Route::get('division',            'Division\Division@index');
    Route::get('division/create',     'Division\Division@create');
    // store division item
    Route::post('division/store',     'Division\Division@store');
    // edit view
    Route::get('division/edit/{id}',     'Division\Division@edit_view');
    Route::post('division/update',     'Division\Division@update');
    Route::get('division/csv_upload',     'Division\Division@csv_upload');
    
    Route::post('division/search_division',     'Division\Division@search_division');
    
    /*
     * =========================================================================
     * District route
     * =========================================================================
     */
    Route::get('district',            'District\District@index');
    Route::get('district/create',     'District\District@create');
    // store district item
    Route::post('district/store',     'District\District@store');
    // edit view
    Route::get('district/edit/{id}',     'District\District@edit_view');
    Route::post('district/update',     'District\District@update');
    Route::get('district/csv_upload',     'District\District@csv_upload');
    
    Route::post('district/searchDistrict',     'District\District@searchDistrict');
    
    /*
     * =========================================================================
     * Upazila route
     * =========================================================================
     */
    Route::get('upazila',            'Upazila\Upazila@index');
    Route::get('upazila/create',     'Upazila\Upazila@create');
    // store upazila item
    Route::post('upazila/store',     'Upazila\Upazila@store');
    // edit view
    Route::get('upazila/edit/{id}',     'Upazila\Upazila@edit_view');
    Route::post('upazila/update',     'Upazila\Upazila@update');
    Route::get('upazila/csv_upload',     'Upazila\Upazila@csv_upload');
    
    Route::post('upazila/searchUpazila',     'Upazila\Upazila@searchUpazila');
    
    
    /*
     * =========================================================================
     * Union route
     * =========================================================================
     */
    Route::get('union',            'Union\Union@index');
    Route::get('union/create',     'Union\Union@create');
    // store upazila item
    Route::post('union/store',     'Union\Union@store');
    // edit view
    Route::get('union/edit/{id}',     'Union\Union@edit_view');
    Route::post('union/update',     'Union\Union@update');
    Route::get('union/csv_upload',     'Union\Union@csv_upload');
    
    Route::post('union/searchUnion',     'Union\Union@searchUnion');
    
    
     /*
     * =========================================================================
     * Area route
     * =========================================================================
     */
    Route::get('area',            'Area\Area@index');
    Route::get('area/create',     'Area\Area@create');
    // store area item
    Route::post('area/store',     'Area\Area@store');
    // edit view
    Route::get('area/edit/{id}',     'Area\Area@edit_view');
    Route::post('area/update',     'Area\Area@update');
    
    /*
     * =========================================================================
     * Citycorporation route
     * =========================================================================
     */
    Route::get('citycorporation',            'Citycorporation\Citycorporation@index');
    Route::get('citycorporation/create',     'Citycorporation\Citycorporation@create');
    // store citycorporation item
    Route::post('citycorporation/store',     'Citycorporation\Citycorporation@store');
    // edit view
    Route::get('citycorporation/edit/{id}',     'Citycorporation\Citycorporation@edit_view');
    Route::post('citycorporation/update',     'Citycorporation\Citycorporation@update');
    Route::get('citycorporation/csv_upload',     'Citycorporation\Citycorporation@csv_upload');
    
    Route::post('citycorporation/searchCitycorporation',     'Citycorporation\Citycorporation@searchCitycorporation');
    
    /*
     * =========================================================================
     * Ward route
     * =========================================================================
     */
    Route::get('ward',            'Ward\Ward@index');
    Route::get('ward/create',     'Ward\Ward@create');
    // store ward item
    Route::post('ward/store',     'Ward\Ward@store');
    // edit view
    Route::get('ward/edit/{id}',     'Ward\Ward@edit_view');
    Route::post('ward/update',     'Ward\Ward@update');
    Route::get('ward/csv_upload',     'Ward\Ward@csv_upload');
    
    Route::post('ward/searchWard',     'Ward\Ward@searchWard');
    
    /*
     * =========================================================================
     * Project Information route
     * =========================================================================
     */
    Route::get('project',            'Projectinformation\ProjectInformation@index');
    Route::get('project/project_create/{project_id?}',     'Projectinformation\ProjectInformation@create_project');
    Route::post('project/new_project_store',     'Projectinformation\ProjectInformation@new_project_store');
    Route::get('project/project_agency_create',     'Projectinformation\ProjectInformation@project_agency_create');
    Route::get('project/project_details_create',     'Projectinformation\ProjectInformation@project_details_create');
    Route::get('project/project_foreign_assistance_create',     'Projectinformation\ProjectInformation@project_foreign_assistance_create');
    Route::get('project/project_location_create',     'Projectinformation\ProjectInformation@project_location_create');
    Route::get('project/project_expenditure_information',     'Projectinformation\ProjectInformation@project_expenditure_information');
    Route::get('project/project_document_information',     'Projectinformation\ProjectInformation@project_document_information');
    Route::get('project/project_shapefile_create',     'Projectinformation\ProjectInformation@project_shapefile_create');
    
    Route::post('project/project_agency_store',     'Projectinformation\ProjectInformation@project_agency_store');
    Route::post('project/project_details_store',     'Projectinformation\ProjectInformation@project_details_store');
    Route::post('project/project_fas_store',     'Projectinformation\ProjectInformation@project_fas_store');
    Route::post('project/project_location_store',     'Projectinformation\ProjectInformation@project_location_store');
    Route::post('project/project_expenditure_store',     'Projectinformation\ProjectInformation@project_expenditure_store');
    Route::post('project/project_documents_store',     'Projectinformation\ProjectInformation@project_documents_store');
    Route::post('project/project_shapefils_store',     'Projectinformation\ProjectInformation@project_shapefils_store');
    
    /*
     * =========================================================================
     * Temporary Project Information route
     * =========================================================================
     */
    Route::get('project/temporary_project',     'Projectinformation\ProjectInformation@temporary_project');
    Route::get('project/temporary_project_view/{project_id}',     'Projectinformation\ProjectInformation@temporary_project_view');
    
    /*
     * =========================================================================
     * Existing Approved Project route
     * =========================================================================
     */
    Route::get('project/approved_project',     'Projectinformation\ProjectInformation@approved_project');
    Route::get('project/approved_project_view/{project_id}',     'Projectinformation\ProjectInformation@approved_project_view');
    Route::get('project/approved_projects_landing_view/{project_id}',     'Projectinformation\ProjectInformation@approved_projects_landing_view');
    /*
     * =========================================================================
     * Final Save Project Information route
     * =========================================================================
     */
    Route::get('project/project_agency_update',     'Projectinformation\ProjectInformation@project_agency_update');
    Route::get('project/project_details_update',     'Projectinformation\ProjectInformation@project_details_update');
    Route::get('project/project_foreign_assistance_update',     'Projectinformation\ProjectInformation@project_foreign_assistance_update');
    Route::get('project/project_location_update',     'Projectinformation\ProjectInformation@project_location_update');
    Route::get('project/project_expenditure_information_update',     'Projectinformation\ProjectInformation@project_expenditure_information_update');
    Route::get('project/project_documents_update',     'Projectinformation\ProjectInformation@project_documents_update');
    Route::get('project/project_shapefile_update',     'Projectinformation\ProjectInformation@project_shapefile_update');
    Route::post('project/project_final_save',     'Projectinformation\ProjectInformation@project_final_save');    
    
     /*
     * =========================================================================
     * Project Quality Review Information route
     * =========================================================================
     */
    Route::post('project/project_quality_review_search',     'Projectinformation\ProjectInformation@project_quality_review_search');
    Route::post('project/project_revised_quality_review_search',     'Projectinformation\ProjectInformation@project_revised_quality_review_search');
    Route::get('project/project_quality_review',     'Projectinformation\ProjectInformation@project_quality_review');
    Route::get('project/revised_quality_review',     'Projectinformation\ProjectInformation@revised_quality_review');
    Route::post('project/project_quality_review_update',     'Projectinformation\ProjectInformation@project_quality_review_update');    
    Route::get('project/project_quality_review_view/{project_id}',     'Projectinformation\ProjectInformation@project_quality_review_view');
    Route::get('project/revised_project_quality_review_view/{project_id}',     'Projectinformation\ProjectInformation@revised_project_quality_review_view');
    Route::post('project/revised_project_quality_store',     'Projectinformation\ProjectInformation@revised_project_quality_store');
     /*
     * =========================================================================
     * Revised Project Information route
     * =========================================================================
     */
    
    Route::get('project/revised_projects',     'Projectinformation\ProjectInformation@revised_projects');
    Route::get('project/revised_projects_view/{project_id}',     'Projectinformation\ProjectInformation@revised_projects_view');
    Route::post('project/revised_project_search',     'Projectinformation\ProjectInformation@revised_project_search');
    
    
    Route::get('/project/project_download',     'Projectinformation\ProjectInformation@project_download');
    Route::get('/project/project_doc_download',     'Projectinformation\ProjectInformation@project_doc_download');
    Route::get('/project/plis_gis',     'Projectinformation\ProjectInformation@plis_gis');
    
     /*
     * =========================================================================
     * Revised Project Information Save
     * =========================================================================
     */
    //project_final_revision_store
    Route::post('/project/project_final_revision_store',     'Projectinformation\ProjectInformation@project_final_revision_store');
    Route::get('/project/update_cost_table',     'Projectinformation\ProjectInformation@update_cost_table');
    
     /*
     * =========================================================================
     * Project Progress Information
     * =========================================================================
     */
    //project_progress list
    Route::get('/project/project_progress',     'Projectinformation\ProjectInformation@project_progress');
    //project_progress_details_landing_view.blade
    Route::get('project/project_progress_view/{project_id}/{progress_id?}',     'Projectinformation\ProjectInformation@project_progress_view');
    
    //project_progress_store
    Route::post('/project/project_progress_store',     'Projectinformation\ProjectInformation@project_progress_store');
    // project progress search result
    Route::post('project/project_progress_search',     'Projectinformation\ProjectInformation@project_progress_search');
    // approved project progress search result
    Route::post('project/approved_project_search',     'Projectinformation\ProjectInformation@approved_project_search');
    
    // Get chart data:
    Route::get('/project/get_map_upazila_details',     'Projectinformation\ProjectInformation@get_map_upazila_details');
    
     /*
     * =========================================================================
     * On Project Progress Information
     * =========================================================================
     */
    //project_progress list
    Route::get('/project/on_project_progress',     'Projectinformation\ProjectInformation@on_project_progress');
    //project_progress_details_landing_view.blade
    Route::get('project/on_project_progress_view/{project_id}/{progress_id?}',     'Projectinformation\ProjectInformation@on_project_progress_view');
    Route::post('project/on_progress_project_search',     'Projectinformation\ProjectInformation@on_progress_project_search');
});
//DocumentViewer Library
Route::any('ViewerJS/{all?}', function(){

    return View::make('ViewerJS.index');
});