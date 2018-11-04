<?php

namespace App\Http\Controllers\Backend;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionsRequest;
use App\Http\Requests\Admin\UpdatePermissionsRequest;
use DB;
use Validator;

class PermissionsController extends Controller
{
    /**
     * Display a listing of Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if (! Gate::allows('users_manage')) {
//            return abort(401);
//        }
        $permissions = Permission::all();

        return view('backend.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating new Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if (! Gate::allows('users_manage')) {
//            return abort(401);
//        }
        return view('backend.permissions.create');
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param  \App\Http\Requests\StorePermissionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        if (! Gate::allows('users_manage')) {
//            return abort(401);
//        }
        
        // Build the validation constraint here:
        $rules  =   [
            'name'  =>  'required|alpha_spaces|unique:permissions,name'
        ];
        
        // Create a new validator instance
        
        $validator  =   Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/permissions/create')
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error','Failed to save data');
        }
        
        Permission::create($request->all());

        return redirect('admin/permissions')->with('success','Item created successfully!');
    }


    /**
     * Show the form for editing Permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        if (! Gate::allows('users_manage')) {
//            return abort(401);
//        }
        $permission = Permission::findOrFail($id);
        return view('backend.permissions.edit', compact('permission'));
    }

    /**
     * Update Permission in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        if (! Gate::allows('users_manage')) {
//            return abort(401);
//        }
        // Build the validation constraint here:
        $rules  =   [
            'name'  =>  'required|alpha_spaces|unique:permissions,name,'.$id
        ];
        
        // Create a new validator instance
        
        $validator  =   Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/permissions/create')
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error','Failed to save data');
        }
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        return redirect('admin/permissions')->with('success','Item updated successfully.');
    }


    /**
     * Remove Permission from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        if (! Gate::allows('users_manage')) {
//            return abort(401);
//        }
        
        $roleCheck = DB::table('role_has_permissions')->where('permission_id', $id)->first();
        if(empty($roleCheck)){
            $permission = Permission::findOrFail($id);
            $permission->delete();
            
            $feedback_data  =   [
                'status'    =>  'success',
                'message'    =>  'Data have successfully Deleted',
            ];
        }else{
            $feedback_data  =   [
                'status'    =>  'error',
                'message'    =>  'Failed to delete, Role has assigned with this permission.',
            ];
        }
        echo json_encode($feedback_data);
    }

    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Permission::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
