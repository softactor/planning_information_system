<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Project</th>
            <th>Ministry</th>
            <th>Agency</th>
            <th>Period</th>
            <th>Project Cost</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $slNo = 1;
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
                $d['table'] = "projectagencies";
                $d['where'] = [
                    'project_id' => $data->id,
                    'lead_agency' => 1,
                ];
                $info = get_table_data_by_clause($d);
                if (isset($info[0]) && !empty($info[0])) {
                    $pinfo = $info[0]; //ministries
                    echo get_data_name_by_id('ministries', $pinfo->ministry_id)->ministry_name;
                } else {
                    echo "No information";
                }
                ?>
            </td>
            <td><?php echo get_data_name_by_id('agencies', $pinfo->agency_id)->agency_name; ?></td>
            <td>
                <?php
                $d = [];
                $d['table'] = "projectcosts";
                $d['where'] = [
                    'project_id' => $data->id
                ];
                $info = get_table_data_by_clause($d);
                if (isset($info[0]) && !empty($info[0])) {
                    $pinfo = $info[0];
                    echo date("d-m-Y", strtotime($pinfo->implstartdate)) . " To " . date("d-m-Y", strtotime($pinfo->implenddate));
                } else {
                    echo "No information";
                }
                ?>
            </td>
            <td>
                <?php
                // get project version id
                    $project_versions   =   get_project_version_id_by_project_id($data->id);
                    $version_id         =   $project_versions->rev_number;
                    $version_id         =   $version_id+1;
                    // get latest projects progress id
                    // get latest projects progress id                            
                    $project_progress   =   get_project_progress_id_by_project_id($project_versions->id);

                    $progress_id        =   $project_progress->id;
                    $param['table']     = "projects";
                    $param['where']     = [
                        'id'    => $data->id
                    ];
                    $pdata              =   get_table_data_by_clause($param);
                    $project_data       =   $pdata[0];
                    // now we have progress id so we can get progress cost data by progress id
                    $param = [];
                    $param['table'] = "projectcosts";
                    $param['where'] = [
                        'project_id' => $progress_id
                    ];
                    $fas = get_table_data_by_clause($param);
                    $projectCost    =   ((isset($fas[0]) ? $fas[0]:""));
                    echo $projectCost->sum_grand_total;
                ?>
            </td>
            <td>
                <?php echo date("d-m-Y", strtotime($data->project_entry_date)); ?>
            </td>

        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7"><div class="no_data_message_style">Sorry, There is no data.</div></td>
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
            <th>Project Cost</th>
            <th>Date</th>
        </tr>
    </tfoot>
</table>