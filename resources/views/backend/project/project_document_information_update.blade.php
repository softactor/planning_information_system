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
                        
                        $param['table']     = "projects";
                        $param['where']     = [
                            'id'    => Session::get('project_id')
                        ];
                        $pdata              =   get_table_data_by_clause($param);
                        $project_data       =   $pdata[0];
                        $project_protemp    =   $project_data->protemp;
                        
                        $param      =   [];
                        $param['table'] = "projectdocuments";
                        $param['where'] = [
                            'project_id' => $project_data->id
                        ];
                        $fas = get_table_data_by_clause($param);
                        ?>
                        <form class="form-horizontal" action="{{ url('admin/project/project_documents_store') }}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @include("backend.pertial.project_entry_form_fixed_part")
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="doc">Document<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('project_docs'))
                                        <div class="alert-error">{{ $errors->first('project_docs') }}</div>
                                    @endif
                                    <input <?php if($project_protemp==2){ echo 'disabled'; } ?> type="file" class="form-control" id="project_docs" name="project_docs">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="doctyp">Type of document<span class="required_star">*</span></label>
                                <div class="col-sm-8">
                                    @if ($errors->has('doctype'))
                                        <div class="alert-error">{{ $errors->first('doctype') }}</div>
                                    @endif
                                    <?php
                                    $param['table'] = "commonconfs";
                                    $param['where'] = [
                                        'commonconf_type' => 7
                                    ];
                                    $responseData = get_table_data_by_clause($param);
                                    ?>
                                    <select <?php if($project_protemp==2){ echo 'disabled'; } ?> class="form-control" id="doctype" name="doctype" onchange="hideErrorDiv('doctype')">
                                        <option value="">Select Type of Document</option>
                                        <?php foreach ($responseData as $data) { ?>
                                            <option value="<?php echo $data->id; ?>" {{($data->id == old('doctype')) ? 'selected' : ''}}><?php echo $data->commonconf_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="prjname1">Remarks</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="remarks" name="remarks" value="{{ old('remarks')}}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <input type="hidden" name="project_id" value="<?php echo $project_data->id; ?>">
                                    <input type="hidden" name="page_type" value="update">
                                    <input <?php if($project_protemp==2){ echo 'disabled'; } ?> type="submit" name="submit" value="Save" class="btn btn-success">
                                    <a href="{{ url($back.Session::get('project_id'))}}" class="btn btn-info"><< Back</a>
                                </div>
                            </div>
                        </form>
                        <div id="pdf_viwer_section" class="pdf_viwer_section" style="display: none;">
                            <div class="my_pdf_container" id="example1"></div>
                            <button type="button" class="btn btn-xs btn-info pull-right" onclick="hide_pdf_viewer();">Hide PDF</button>
                        </div>                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Documents</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>  
                                <?php
                                foreach ($fas as $ag) {
                                    $path = asset("uploads/project_shape_files/doc_store")."/".$ag->doc_path;
                                    ?>
                                    <tr id="data_entry_id_{{$ag->id}}">
                                        <td>#</td>
                                        <td><a href="{{$path}}"><?php echo $ag->docname; ?></a></td>
                                        <td><?php echo get_data_name_by_id("commonconfs", $ag->doctype)->commonconf_name; ?></td>
                                        <td>
                                            <!--viewTheDocFile-->
                                            <a href="{{$path}}" class="btn btn-xs btn-info">Download</a>
                                            <!--<button type="button" class="btn btn-xs btn-info" onclick="viewTheDocFile('{{$path}}')">View</button>-->
                                            <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$ag->id}}, 'projectdocuments');">Delete</button>
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