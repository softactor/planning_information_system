<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>Update</small>
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
                        <?php
                        $project_id         =   Session::get('project_id');
                        $param['table']     = "projects";
                        $param['where']     = [
                            'id'    => Session::get('project_id')
                        ];
                        $pdata              =   get_table_data_by_clause($param);
                        $project_data       =   $pdata[0];
                        ?>
                        <form class="form-horizontal" action="{{ url('admin/project/project_fas_store') }}" method="post">
                                {{csrf_field()}}
                            @include("backend.pertial.project_entry_form_fixed_part")
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="cntry">Country<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('fa_country'))
                                        <div class="alert-error">{{ $errors->first('fa_country') }}</div>
                                    @endif
                                    <select class="form-control" id="fa_country" name="fa_country" onchange="hideErrorDiv('fa_country')">
                                        <option value="">Select Country</option>
                                        <?php
                                        $param['table'] = "commonconfs";
                                        $param['where'] = [
                                            'commonconf_type' => 4
                                        ];
                                        $proposal = get_table_data_by_clause($param);
                                        foreach ($proposal as $type) {
                                            ?>
                                            <option value="<?php echo $type->id ?>" {{($type->id == old('fa_country')) ? 'selected' : ''}}><?php echo $type->commonconf_name ?></option>
                                        <?php } ?>
                                    </select>                                                
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="doner">Donor<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('fa_donor'))
                                        <div class="alert-error">{{ $errors->first('fa_donor') }}</div>
                                    @endif
                                    <select class="form-control" id="fa_donor" name="fa_donor" onchange="hideErrorDiv('fa_donor')">                                        
                                        <option value="">Select Donor</option>
                                        <?php
                                        $param['table'] = "commonconfs";
                                        $param['where'] = [
                                            'commonconf_type' => 5
                                        ];
                                        $proposal = get_table_data_by_clause($param);
                                        foreach ($proposal as $type) {
                                            ?>
                                            <option value="<?php echo $type->id ?>" {{($type->id == old('fa_donor')) ? 'selected' : ''}}><?php echo $type->commonconf_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="modefi">Mode of finance<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('fa_mof'))
                                        <div class="alert-error">{{ $errors->first('fa_mof') }}</div>
                                    @endif
                                    <select class="form-control" id="fa_mof" name="fa_mof" onchange="hideErrorDiv('fa_mof')">
                                        <option value="">Select Mode of finance</option>
                                        <?php
                                        $param['table'] = "commonconfs";
                                        $param['where'] = [
                                            'commonconf_type' => 6
                                        ];
                                        $proposal = get_table_data_by_clause($param);
                                        foreach ($proposal as $type) {
                                            ?>
                                            <option value="<?php echo $type->id ?>" {{($type->id == old('fa_mof')) ? 'selected' : ''}}><?php echo $type->commonconf_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="amount">Amount<span class="required_star">*</span></label>
                                <div class="col-sm-6">
                                    @if ($errors->has('fa_amount'))
                                        <div class="alert-error">{{ $errors->first('fa_amount') }}</div>
                                    @endif
                                    <input type="text" class="form-control" id="fa_amount" value="{{ old('fa_amount') }}" name="fa_amount" onkeyup="hideErrorDiv('fa_amount')">(Lac Taka)
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" id="pfa_update_id" name="pfa_update_id" value="">
                                    <input type="hidden" name="project_id" value="<?php echo Session::get('project_id'); ?>">
                                    <input type="hidden" name="page_type" value="update">
                                    <input type="submit" id="submit_button" name="submit" value="Save" class="btn btn-success">
                                    <a href="{{ url($back.$project_id)}}" class="btn btn-info"><< Back</a>
                                </div>
                            </div>
                        </form>
                        <?php
                            $param['table'] = "project_fas";
                            $param['where'] = [
                                'project_id' => Session::get('project_id')
                            ];
                            $fas = get_table_data_by_clause($param);
                            ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Country</th>
                                        <th>Donor</th>
                                        <th>Mode of finance</th>
                                        <th>Amount (Lac Taka)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                    <?php
                                    foreach ($fas as $ag) {
                                        ?>
                                        <tr id="data_entry_id_{{$ag->id}}">
                                            <td>#</td>
                                            <td><?php echo get_data_name_by_id("commonconfs",$ag->fa_country)->commonconf_name; ?></td>
                                            <td><?php echo get_data_name_by_id("commonconfs",$ag->fa_donor)->commonconf_name; ?></td>
                                            <td><?php echo get_data_name_by_id("commonconfs",$ag->fa_mof)->commonconf_name; ?></td>
                                            <td><?php echo $ag->fa_amount; ?></td>
                                            <td>
                                                <a href="#" onclick="onPageEditData({{$ag->id}}, 'project_fas')" class="btn btn-xs btn-info">Edit</a>
                                                <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$ag->id}}, 'project_fas');">Delete</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
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
@endsection