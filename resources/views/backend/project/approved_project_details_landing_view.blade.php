<!--Extends parent app template-->
@extends('backend.layout.app')

<!--Content insert section-->
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $list_title }}
            <small>{{ $list_title }} Update</small>
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
                            // get project version id
                            $project_versions   =   get_project_version_id_by_project_id(Session::get('project_id'));
                            $version_id         =   $project_versions->rev_number;
                            $version_id         =   $version_id+1;
                            // get latest projects progress id
                            $project_progress   =   get_project_progress_id_by_project_id($project_versions->id);
                            $progress_id        =   $project_progress->id;
                            $param['table']     = "projects";
                            $param['where']     = [
                                'id'    => Session::get('project_id')
                            ];
                            $pdata              =   get_table_data_by_clause($param);
                            $project_data       =   $pdata[0];
                            $param = [];
                            $param['table'] = "projectcosts";
                            $param['where'] = [
                                'project_id' => $progress_id
                            ];
                            $fas = get_table_data_by_clause($param);
                            $projectCost    =   ((isset($fas[0]) ? $fas[0]:""));
                        ?>
                        <form class="form-horizontal" action="{{ url('admin/project/project_final_revision_store') }}" method="post">                        
                            {{csrf_field()}}
                            @include("backend.pertial.project_entry_form_fixed_part")
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="prjvtype">Date<span class="required_star">*</span></label>
                                <div class="col-sm-2">
                                    <input disabled type="text" autocomplete="off" class="form-control" id="revised_date" name="revised_date" value="<?php echo date("d-m-Y"); ?>">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="prjvtype">Revision Number</label>
                                <div class="col-sm-1">
                                    <input disabled type="text" class="form-control" id="prjvtype" value="<?php echo $version_id; ?>" readonly>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="loctyp">Implementation period<span class="required_star">*</span></label>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="implstartdate">Start<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('implstartdate'))
                                        <div class="alert-error">{{ $errors->first('implstartdate') }}</div>
                                    @endif
                                    <input disabled onchange="hideErrorDiv('implstartdate')" type="text" class="form-control" id="implstartdate" name="implstartdate" value="{{ old('implstartdate',(isset($projectCost->implstartdate)? date('d-m-Y',strtotime($projectCost->implstartdate)):""))}}">
                                </div>    
                                <label class="control-label col-sm-2" for="implenddate">End<span class="required_star">*</span></label>
                                <div class="col-sm-3">
                                    @if ($errors->has('implenddate'))
                                        <div class="alert-error">{{ $errors->first('implenddate') }}</div>
                                    @endif
                                    <input disabled onchange="checkPeriodValidity();hideErrorDiv('implenddate')" type="text" class="form-control" id="implenddate" name="implenddate" value="{{ old('implenddate',(isset($projectCost->implenddate)? date('d-m-Y',strtotime($projectCost->implenddate)):""))}}">
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="loctyp">Expenditure (Lac Taka)</label>    
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="rev">Revenue</label>
                                <label class="control-label col-sm-2" for="cap">Capital</label>
                                <label class="control-label col-sm-2" for="con">
                                    <div class="row" style="margin-left: 50%; margin-right: -52%;">
                                        <div class="col-sm-6">Physical</div>
                                        <div class="col-sm-6">Price</div>
                                    </div>
                                </label>
                                <label class="control-label col-sm-2" for="grnd">Grand Total</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="gob">GOB</label>
                                <div class="col-sm-2">
                                    @if ($errors->has('gob.rev'))
                                        <div class="alert-error">{{ $errors->first('gob.rev') }}</div>
                                    @endif
                                    <input disabled type="text" class="form-control" id="gob_rev" name="gob[rev]" onkeyup="calculateGrandTotal('gob');hideErrorDiv('gob_rev'); checkNumberOrString('gob_rev')" value="{{ (isset($projectCost->expgobrev)? $projectCost->expgobrev:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="gob_cap" name="gob[cap]" onkeyup="calculateGrandTotal('gob'); checkNumberOrString('gob_cap');" value="{{ (isset($projectCost->expgobcap) && $projectCost->expgobcap > 0 ? $projectCost->expgobcap:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="gob_conph" name="gob[conph]" onkeyup="calculateGrandTotal('gob'); checkNumberOrString('gob_conph')" value="{{ (isset($projectCost->expgobcont_ph)? $projectCost->expgobcont_ph:'')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="gob_conpr" name="gob[conpr]" onkeyup="calculateGrandTotal('gob'); checkNumberOrString('gob_conpr')" value="{{ (isset($projectCost->expgobcont_pr)? $projectCost->expgobcont_pr:'')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="gob_grand" name="gob[grand]" onkeyup="calculateGrandTotal('gob'); checkNumberOrString('gob_grand');" value="{{ (isset($projectCost->gob_gt)? $projectCost->gob_gt:"")}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="pa">PA(RPA + DPA)</label>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="pa_rev" name="pa[rev]" onkeyup="calculateGrandTotal('pa'); checkNumberOrString('pa_rev');" value="{{ (isset($projectCost->expparev) && $projectCost->expparev > 0 ? $projectCost->expparev:"")}}">
                                </div> 
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="pa_cap" name="pa[cap]" onkeyup="calculateGrandTotal('pa'); checkNumberOrString('pa_cap');" value="{{ (isset($projectCost->exppacap) && $projectCost->exppacap > 0 ? $projectCost->exppacap:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="pa_conph" name="pa[conph]" onkeyup="calculateGrandTotal('pa'); checkNumberOrString('pa_conph')" value="{{ (isset($projectCost->exppacont_ph)? $projectCost->exppacont_ph:'')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="pa_conpr" name="pa[conpr]" onkeyup="calculateGrandTotal('pa'); checkNumberOrString('pa_conpr')" value="{{ (isset($projectCost->exppacont_pr)? $projectCost->exppacont_pr:'')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="pa_grand" name="pa[grand]" onkeyup="calculateGrandTotal('pa'); checkNumberOrString('pa_grand');" onload="calculateGrandTotal('pa');" value="{{ (isset($projectCost->pa_gt)? $projectCost->pa_gt:"")}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="own">Own Fund</label>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="own_rev" name="own[rev]" onkeyup="calculateGrandTotal('own'); checkNumberOrString('own_rev');" value="{{ (isset($projectCost->expofundrev) && $projectCost->expofundrev > 0 ? $projectCost->expofundrev:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="own_cap" name="own[cap]" onkeyup="calculateGrandTotal('own'); checkNumberOrString('own_cap');" value="{{ (isset($projectCost->expofundcap) && $projectCost->expofundcap > 0 ? $projectCost->expofundcap:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <div class="row"> 
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="own_conph" name="own[conph]" onkeyup="calculateGrandTotal('own'); checkNumberOrString('own_conph')" value="{{ (isset($projectCost->expofundcont_ph)? $projectCost->expofundcont_ph:'')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="own_conpr" name="own[conpr]" onkeyup="calculateGrandTotal('own'); checkNumberOrString('own_conpr')" value="{{ (isset($projectCost->expofundcont_pr)? $projectCost->expofundcont_pr:'')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="own_grand" name="own[grand]" onkeyup="calculateGrandTotal('own'); checkNumberOrString('own_grand');" value="{{ (isset($projectCost->own_gt)? $projectCost->own_gt:"")}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="others">Others</label>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="others_rev" name="others[rev]" onkeyup="calculateGrandTotal('others'); checkNumberOrString('others_rev');" value="{{ (isset($projectCost->expothersrev) && $projectCost->expothersrev > 0 ? $projectCost->expothersrev:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="others_cap" name="others[cap]" onkeyup="calculateGrandTotal('others'); checkNumberOrString('others_cap');" value="{{ (isset($projectCost->expotherscap) && $projectCost->expotherscap > 0 ? $projectCost->expotherscap:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="others_conph" name="others[conph]" onkeyup="calculateGrandTotal('others'); checkNumberOrString('others_conph')" value="{{ (isset($projectCost->expotherscont_ph)? $projectCost->expotherscont_ph:'')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="others_conpr" name="others[conpr]" onkeyup="calculateGrandTotal('others'); checkNumberOrString('others_conpr')" value="{{ (isset($projectCost->expotherscont_pr)? $projectCost->expotherscont_pr:'')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="others_grand" name="others[grand]" onkeyup="calculateGrandTotal('others'); checkNumberOrString('others_grand');" value="{{ (isset($projectCost->oth_gt)? $projectCost->oth_gt:"")}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="others">All Total</label>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="rev_total" name="all_total[rev]" value="{{ (isset($projectCost->rev_total) && $projectCost->rev_total > 0 ? $projectCost->rev_total:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="cap_total" name="all_total[cap]" value="{{ (isset($projectCost->cap_total) && $projectCost->cap_total > 0 ? $projectCost->cap_total:"")}}">
                                </div>
                                <div class="col-sm-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="conph_total" name="all_total[conph]" value="{{ (isset($projectCost->conph_total)? $projectCost->conph_total:'')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" id="conpr_total" name="all_total[conpr]" value="{{ (isset($projectCost->conpr_total)? $projectCost->conpr_total:'')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input disabled type="text" class="form-control" id="sum_grand_total" name="all_total[grand]" value="{{ (isset($projectCost->sum_grand_total)? $projectCost->sum_grand_total:"")}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <a href="{{ url('admin/project/approved_project')}}" class="btn btn-info"><< Back</a>
                                    <div id="show_calculator" style="display: none;float: right;margin-right: 42%;"></div>
                                </div>
                            </div>
                        </form>
                        <div class="pull-right project_link_information">
                            <ul>
                                <li><a href="#" data-toggle="modal" data-target="#viewProjectProfile"><span class="fa fa-book">&nbsp;View project profile</span></a></li>
                            </ul>
                        </div>
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
    @include('backend/project/approved_project_profile_view')
</div>
@endsection