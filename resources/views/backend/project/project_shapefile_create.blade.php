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
                        <?php
                        
                        $param['table']     = "projects";
                        $param['where']     = [
                            'id'    => Session::get('project_id')
                        ];
                        $pdata              =   get_table_data_by_clause($param);
                        $project_data       =   $pdata[0];
                        ?>
                        <form class="form-horizontal" action="{{ url('admin/project/project_shapefils_store') }}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @include("backend.pertial.project_entry_form_fixed_part")
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="doc">Document<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('project_docs'))
                                        <div class="alert-error">{{ $errors->first('project_docs') }}</div>
                                    @endif
                                    <input type="file" class="form-control" id="project_docs" name="project_docs">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="project_id" value="<?php echo $project_data->id; ?>">
                                    <input type="submit" name="submit" value="Upload" class="btn btn-success">
                                    <a href="{{ url('admin/project/project_document_information')}}" class="btn btn-info">Back</a>
                                    <a href="{{ url('admin/project/temporary_project_view/'.$project_data->id)}}" class="btn btn-info">Review</a>
                                </div>
                            </div>
                        </form>
                        <?php
                        $param['table'] = "projectshapefiles";
                        $param['where'] = [
                            'project_id' => $project_data->id
                        ];
                        $psf = get_table_data_by_clause($param);
                        if (isset($psf) && !empty($psf)) {
                            ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Project Name</th>
                                        <th>Short Name</th>
                                        <th>Documents</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                    <?php
                                    foreach ($psf as $ag) {
                                        ?>
                                        <tr id="data_entry_id_{{$ag->id}}">
                                            <td>#</td>
                                            <td><?php echo $project_data->project_name_eng; ?></td>
                                            <td><?php echo $project_data->project_short_name; ?></td>
                                            <td><a href="#"><?php echo $ag->docname; ?></a></td>
                                            <td>
                                            <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$ag->id}}, 'projectshapefiles');">Delete</button>
                                        </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
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