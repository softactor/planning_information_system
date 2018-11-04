<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>{{ $list_title }} Create</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashbord')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url($list_url) }}">{{ $list_title }}</a></li>
            <li class="active">{{ $list_title }} Create</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        @include('backend/pertial/operation_message')
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="form-horizontal" action="{{url('admin/dashbord/role_assign_store/')}}" method="post">
                            <!--to protect csrf-->
                             {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sector">Role</label>
                                <div class="col-sm-8">
                                    @if ($errors->has('role'))
                                        <div class="alert-error">{{ $errors->first('role') }}</div>
                                    @endif
                                    <select class="form-control" id="role" name="role" onchange="getPagePreAssignAccessValue(this.value);">
                                        <option value="">Select Role</option>
                                        <?php
                                        $all_role = get_table_data_by_table('roles');
                                        if (isset($all_role) && !empty($all_role)) {
                                            foreach ($all_role as $data) {
                                                ?>

                                                <option value="{{$data->id}}">{{$data->name}}</option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sector">Page details</label>
                                <br>
                                <div class="col-sm-8">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Page name</th>
                                                <th>Add</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                                <th>View</th>
                                                <th>Print</th>
                                            </tr>
                                        </thead>
                                        <tbody id='page_assign_body'>
                                            <?php
                                            $param['table']  =  "commonconfs";
                                            $param['order_by'] = "ASC";
                                            $param['order_by_column'] = "commonconf_name";
                                            $param['where']  =  [
                                                'commonconf_type'   =>  8
                                            ];   
                                        $all_pages = get_table_data_by_clause($param);
                                        if (isset($all_pages) && !empty($all_pages)) {
                                            foreach ($all_pages as $data) {
                                                ?>
                                            <tr>
                                                <td>{{$data->commonconf_name}}</td>
                                                <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="add[]" value="{{$data->id}}">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="edit[]" value="{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="delete[]" value="{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="view[]" value="{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" name="print[]" value="{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-6">
                                    <a href="{{ url('admin/dashbord')}}" class="btn btn-info pull-right">Menu</a>
                                    <input type="submit" class="btn btn-success pull-right" style="margin-right: 5px;" name="submit" value="Update">
                                </div>
                            </div>
                        </form>
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
<script>
    function getPagePreAssignAccessValue(role_id){
        if(role_id){
            $.ajax({
                type        :   'get',
                url         :  '{{url("admin/dashbord/getAllPageAccess")}}',
                dataType    :   'json',
                data        :   'role_id='+role_id,
                success     :   function(response){
                    $("#page_assign_body").html(response);
                }
            });
        }
    }
</script>
@endsection
@endsection