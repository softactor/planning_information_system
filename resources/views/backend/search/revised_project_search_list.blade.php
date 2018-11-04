<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Project</th>
            <th>Ministry</th>
            <th>Agency</th>
            <th>Sub Sector</th>
            <th>Period</th>
            <th>Action</th>
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
            <td>{{ $data->project_app_code }}</td>
            <td>{{ $data->project_name_eng }}</td>
            <td>
                <?php
                $d = [];
                $d['table'] = "projectagencies";
                $d['where'] = [
                    'project_id' => $data->id,
                    'lead_agency' => 1,
                ];
                $info = get_table_data_by_clause($d);
                $pinfo = $info[0]; //ministries
                echo get_data_name_by_id('ministries', $pinfo->ministry_id)->ministry_name;
                ?>
            </td>
            <td><?php echo get_data_name_by_id('agencies', $pinfo->agency_id)->agency_name; ?></td>
            <td>{{ ((isset($data->subsector_id) && !empty($data->subsector_id)) ? get_data_name_by_id('subsectors',$data->subsector_id)->subsector_name:"") }}</td>
            <td>
                <?php
                $d = [];
                $d['table'] = "projectcosts";
                $d['where'] = [
                    'project_id' => $data->id
                ];
                $info = get_table_data_by_clause($d);
                $pinfo = $info[0];
                echo date("d-m-Y", strtotime($pinfo->implstartdate)) . " To " . date("d-m-Y", strtotime($pinfo->implenddate));
                ?>
            </td>
            <td>
                <a href="{{ url($edit_url.'/'.$data->id) }}" class="btn btn-xs btn-info">Revised</a>
                <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$data->id}}, 'projects');">Delete</button>
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
            <th>Code</th>
            <th>Project</th>
            <th>Ministry</th>
            <th>Agency</th>
            <th>Sub Sector</th>
            <th>Period</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>