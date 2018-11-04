<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <!--<small>Project Progress List</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashbord')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url($list_url) }}">{{ $list_title }}</a></li>
            <li class="active">{{ $list_title }} List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box">
                    <div class="box-header">
                        @include('backend/pertial/operation_message') 
                        <div class="pull-left add_edit_delete_link" style="width: 100%;">
                            @include('backend/search/project_progress_search')
                        </div>
                    </div>
                    
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ csrf_field() }}                        
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Ministry/ Division</th>
                                    <th>Lead Agency</th>
                                    <th>Period</th>
                                    <th>Proposal type</th>
                                    <th>Progress type</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $slNo  =   1;
                                ?>
                                @if(isset($list_data))
                                @foreach ($list_data as $data)
                                <tr id="data_entry_id_{{$data->id}}">
                                    <td class="text-center">{{ $slNo++}}</td>
                                    <td style="word-wrap: break-word;" title="{{ $data->project_name_eng }}">
                                        <a href="{{ url($edit_url.'/'.$data->id) }}">
                                            {{ $data->project_name_eng }}
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        $d = [];
                                        $d['table'] =   "projectagencies";
                                        $d['where'] =   [
                                            'project_id'=>$data->id,
                                            'lead_agency'=>1,
                                        ];
                                        $info   =   get_table_data_by_clause($d);
                                        if(isset($info[0]) && !empty($info[0])){
                                            $pinfo  =   $info[0];//ministries
                                            echo get_data_name_by_id('ministries',$pinfo->ministry_id)->ministry_name;
                                        }else{
                                            echo "No information";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo get_data_name_by_id('agencies',$pinfo->agency_id)->agency_name; ?></td>
                                    <td>
                                        <?php
                                        $d = [];
                                        $d['table'] =   "projectcosts";
                                        $d['where'] =   [
                                            'project_id'=>$data->id
                                        ];
                                        $info   =   get_table_data_by_clause($d);
                                        if(isset($info[0]) && !empty($info[0])){
                                            $pinfo  =   $info[0];
                                            echo date("d-m-Y", strtotime($pinfo->implstartdate))." To ".date("d-m-Y", strtotime($pinfo->implenddate)); 
                                        }else{
                                            echo "No information";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $proposal = get_data_name_by_id("commonconfs", $data->proposal_type_id);
                                            echo $proposal->commonconf_name;
                                            
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            // get project version id
                                            $project_versions   =   get_project_version_id_by_project_id($data->id);
                                            // get latest projects progress id

                                            $project_progress   =   get_project_progress_id_by_project_id($project_versions->id); 
                                            echo $project_progress->progresstype;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date("d-m-Y", strtotime($data->project_entry_date)); ?>
                                    </td>

                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3"><div class="no_data_message_style">Sorry, There is no data.</div></td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Ministry</th>
                                    <th>Agency</th>
                                    <th>Period</th>
                                    <th>Proposal Type</th>
                                    <th>Progress Type</th>
                                    <th>Date</th>
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
    $( function() {
      $( "#search_from_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
      $( "#search_to_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
    });
    function loadAgencyByMinstry(min_id){
            if(min_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadAgencyByMinstry")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"min_id="+min_id,
                        success     :function(response){
                            $('#agency_id').html(response)
                        }
                    });
            }
        }
</script> 
@endsection
@endsection