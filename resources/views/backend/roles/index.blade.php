<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Role information
            <small>list</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Role</a></li>
            <li class="active">Role List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @include('backend/pertial/operation_message')
                        <div class="pull-right add_edit_delete_link">
                            <a href="{{ url($list_url) }}">
                                <span class="">Menu</span>
                            </a>
                        </div>  
                        <div class="pull-right add_edit_delete_link">
                            <a href="{{ url($create_url) }}">
                                <span class="">Add new record</span>
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ csrf_field() }}
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $slNo   =   1;
                                ?>
                                @if (count($roles) > 0)
                                @foreach ($roles as $role)
                                <tr id="data_entry_id_{{$role->id}}">
                                    <td>{{ $slNo++ }}</td>
                                    <td>{{ $role->name }}</td>                                    
                                    <td>
                                        <a href="{{ url('admin/roles/'.$role->id.'/edit') }}" class="btn btn-xs btn-info">Edit</a>
                                        <button type="button" class="btn btn-xs btn-info" onclick="role_delete({{$role->id}});">Delete</button>                                        
                                    </td>

                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4"><div class="no_data_message_style">Sorry, There is no data.</div></td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@section('footer_js_scrip_area')
@parent
<script type="text/javascript">
    function role_delete(role_id){
        swal({
            title: "Are you sure,want to delete this?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Confirm",
            closeOnConfirm: false
          },
          function(){   
            $.ajax({
                url:'{{url("admin/roles/")}}/'+role_id,
                type:'post',
                dataType:'json',
                data:'_method=DELETE'+'&_token='+$('input[name="_token"]').val(),
                headers: {
                    'X-CSRF-Token':$('input[name="_token"]').val(),
                },
                success: function(response){
                    $('.alert').hide();
                    $('.json_alert_message').hide();
                    if(response.status=='success'){
                        swal.close();
                        $('tr#data_entry_id_'+role_id).remove();
                        $('#success_message').show();
                        $('#success_message > span').html(response.message);
                    }else{
                        swal("Cancelled", response.message, "error");
                    }
                }
            });
          });
    }
</script>
@endsection
@endsection