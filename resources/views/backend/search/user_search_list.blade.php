<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>User name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($users) > 0)
        @foreach ($users as $user)
        <tr id="data_entry_id_{{$user->id}}">
            <td class="text-center">
                @if(!empty($user->image_path))
                <img src="{{ asset('uploads/resize_images/'.$user->image_path)}}" class="img-circle" alt="Cinque Terre"> 
                @else
                <span class="fa fa-user"></span>
                @endif
            </td>
            <td>{{ $user->first_name." ".$user->last_name }}</td>
            <td>{{ $user->email }}</td>                                    
            <td>
                <span class="label label-info label-many">Role</span>
            </td>
            <td>
                <?php
                if ($user->status == 1) {
                    echo "Active";
                } else {
                    echo "Inactive";
                }
                ?>
            </td>
            <td>
                <a href="{{ url('admin/users/'.$user->id.'/edit') }}" class="btn btn-xs btn-info">Edit</a>  
                @if($user->id  !=   Auth::user()->id)
                <button type="button" class="btn btn-xs btn-info" onclick="user_delete({{$user->id}});">Delete</button>
                @endif
            </td>

        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="5"><div class="no_data_message_style">Sorry, There is no data.</div></td>
        </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>User name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>