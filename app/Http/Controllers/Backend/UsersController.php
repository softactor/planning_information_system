<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Image;
use View;

class UsersController extends Controller
{
    public $list_title      =   "User information";
    public $create_url      =   "admin/users/create";
    public $edit_url        =   "admin/users/edit";
    public $list_url        =   "admin/dashbord";
    public $active_menu     =   "adminstrator";
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url      =   $this->list_url;
        $edit_url       =   $this->edit_url;
        $active_menu       =   $this->active_menu;
        $page           =   "List";

        $users = User::all();

        return view('backend.users.index', compact('users','list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url      =   $this->list_url;
        $edit_url       =   $this->edit_url;
        $active_menu       =   $this->active_menu;
        $page           =   "List";
        $roles = Role::get();

        return view('backend.users.create', compact('roles','list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        if (! Gate::allows('users_manage')) {
//            return abort(401);
//        }
        // Defalult value for $profileImageChange
        $profileImageChange     =   false;
        $rules  =   [
            'email'                 =>  'required|unique:users,email',
            'password'              =>  'required|confirmed|min:6|max:15|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}\S+$/',
            'password_confirmation' => 'required|min:6',
            'first_name'            =>  'required',
            'last_name'             =>  'required',
            'roles'                 =>  'required'
        ];
        
        // Create a new validator instance
        
        $validator      =   Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('admin/users/create')
                        ->withErrors($validator)
                        ->withInput()
                        ->with('error','Failed to save data');
        }
        
        /*
        * ---------------------------------------------------------------------
        * Profile image upload area
        * for image resizing we use: Intervention Image Package
        * ---------------------------------------------------------------------
        */
        if($request->hasFile('profile_image')) {
            $profileImageChange     =       true;
            $image = $request->file('profile_image');
            // file re name
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            // resize file destination path
            $destinationPath = public_path('uploads\resize_images');
            // actual path for the file
            $img = Image::make($request->file('profile_image')->getRealPath());
            $img->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $image_name);
            $destinationPath = public_path('uploads\profile_images');

            // Image upload method
            $image->move($destinationPath, $image_name);
            
            // Delete Existing Image
            $main_image_path    =   'uploads\profile_images';
            $resize_image_path    =   'uploads\resize_images';
            if(!empty($user->image_path)){

                unlink(public_path($main_image_path.'\\'.$user->image_path));

                unlink(public_path($resize_image_path.'\\'.$user->image_path));
            }
			$users_input_array   =  [
				'name'          =>  $request->name,
				'email'         =>  $request->email,
				'password'      =>  $request->password,
				'first_name'    =>  $request->first_name,
				'last_name'     =>  $request->last_name,
				'pcdivision_id' =>  $request->pcdivision_id,
				'wing_id'       =>  $request->wing_id,
				'designation'   =>  $request->designation,
				'mobile'        =>  $request->mobile,
				'image_path'    =>  $image_name,
			];
        }
        $user = User::create((($profileImageChange) ? $users_input_array   :   $request->all()));    
        $roles  =   $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);
        return redirect('admin/users')
                            ->with('success', 'Data have been saved successfully.');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $user_type    =   getRoleIdByUserId(Auth::user()->id);  
        $list_title     =   $this->list_title;
        $create_url     =   $this->create_url;
        $list_url      =   $this->list_url;
        $edit_url       =   $this->edit_url;
        $active_menu       =   $this->active_menu;
        $page           =   "List";
        $roles = Role::get();

        $user = User::findOrFail($id);
        $check  =   $user->roles()->pluck('name', 'name')->all();
        if($user_type == 4){
            $page      =       "backend.users.edit";
        }else{
            $page      =       "backend.users.gen_edit";
        }
        return view($page, compact('user', 'roles','list_title','create_url','edit_url','list_url','page','list_data','active_menu'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // Defalult value for $profileImageChange
        $profileImageChange     =   false;
        $user                   =   User::findOrFail($id); 
        $user_type = getRoleIdByUserId(Auth::user()->id);
        if ($user_type == 4) {
            // admin area          

            $rules = [
                'email' => 'required|unique:users,email,' . $id,
                'first_name' => 'required',
                'last_name' => 'required',
                'roles' => 'required'
            ];

            // Create a new validator instance

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('admin/users/' . $id . '/edit')
                                ->withErrors($validator)
                                ->withInput()
                                ->with('error', 'Failed to Update Item!');
            }
            /*
             * ---------------------------------------------------------------------
             * Profile image upload area
             * for image resizing we use: Intervention Image Package
             * ---------------------------------------------------------------------
             */
            if ($request->hasFile('profile_image')) {
                $profileImageChange = true;
                $image = $request->file('profile_image');
                // file re name
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                // resize file destination path
                $destinationPath = public_path('uploads\resize_images');
                // actual path for the file
                $img = Image::make($request->file('profile_image')->getRealPath());
                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $image_name);
                $destinationPath = public_path('uploads\profile_images');

                // Image upload method
                $image->move($destinationPath, $image_name);

                // Delete Existing Image
                $main_image_path = 'uploads\profile_images';
                $resize_image_path = 'uploads\resize_images';
                if (!empty($user->image_path)) {

                    unlink(public_path($main_image_path . '\\' . $user->image_path));

                    unlink(public_path($resize_image_path . '\\' . $user->image_path));
                }
                $users_input_array = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'pcdivision_id' => $request->pcdivision_id,
                    'wing_id' => $request->wing_id,
                    'designation' => $request->designation,
                    'mobile' => $request->mobile,
                    'image_path' => $image_name,
                    'status' => $request->status,
                ];
            }

            $user->update((($profileImageChange) ? $users_input_array : $request->all()));
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->syncRoles($roles);
            return redirect('admin/users')
                ->with('success', 'Data have Updated successfully.');
        } else {
            // gen user area
            $rules = [
                'old_password' => 'required|old_password:' . Auth::user()->password,
                'password'              =>  'required|confirmed|min:6|max:15|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}\S+$/',
                'password_confirmation' => 'required|min:6',
            ];

            // Create a new validator instance

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('admin/users/' . $id . '/edit')
                                ->withErrors($validator)
                                ->withInput()
                                ->with('error', 'Failed to Update Item!');
            }
            $user->update((($profileImageChange) ? $users_input_array : $request->all()));
            return redirect('admin/users/' . $id . '/edit')
                ->with('success', 'Data have Updated successfully.');
        }
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
//        if (! Gate::allows('users_manage')) {
//            return abort(401);
//        }

        $roleCheck = DB::table('model_has_roles')->where('model_id', $id)->first();

        if (!empty($roleCheck)) {
            $roleCheck = DB::table('model_has_roles')->where('model_id', '=', $id)->delete();
        }
        $user = User::findOrFail($id);
        $user->delete();

        $feedback_data = [
            'status' => 'success',
            'message' => 'Data have successfully Deleted',
        ];
        echo json_encode($feedback_data);
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
    
    public function searchUsers(Request $request) {
        $list_title     = $this->list_title;
        $create_url     = $this->create_url;
        $list_url       = $this->list_url;
        $edit_url       = $this->edit_url;
        $active_menu    =   $this->active_menu;
        $page           = "List";
        // get all table data:
        
        $query          = DB::table('users as u');

        if (isset($request->all) && !empty($request->all)) {
            $users = $query->get();
        } else {

            if (isset($request->pcdivision_id) && !empty($request->pcdivision_id)) {
                $query->where('u.pcdivision_id', '=', $request->pcdivision_id);
            }

            if (isset($request->wing_id) && !empty($request->wing_id)) {
                $query->where('u.wing_id', '=', $request->wing_id);
            }
            if (isset($request->name) && !empty($request->name)) {
                $query->where('u.first_name', 'like', '%' . $request->name . '%')
                    ->orWhere('u.last_name', 'like', '%' . $request->name . '%');
            }
            
            $users          = $query->get();
        }
        if ($users->isEmpty()) {
            $feedback_data  = [
                'status'    => 'error',
                'message'   => 'Data Not Found',
                'data'      => ''
            ];
        } else {
            $search_data    = View::make('backend.search.user_search_list', compact('users', 'list_title', 'create_url', 'edit_url', 'list_url', 'page', 'list_data', 'active_menu'));
            $feedback_data  = [
                'status'    => 'success',
                'message'   => 'Data Found',
                'data'      => $search_data->render()
            ];
        }
        echo json_encode($feedback_data);
    }
}
