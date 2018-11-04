<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Name</th>
            <th>Short</th>
            <th>Code</th>
            <th>Wing</th>
            <th>Sub Sector</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
	<?php
			$slNo  =   1;
		?>
        @if(isset($list_data))
        @foreach ($list_data as $data)
        <tr id="data_entry_id_{{$data->id}}">
            <td class="text-center">{{$slNo++}}</td>
            <td>{{ $data->project_entry_date }}</td>
            <td>{{ $data->project_name_eng }}</td>
            <td>{{ $data->project_short_name }}</td>
            <td>{{ $data->project_app_code }}</td>
            <td>{{ get_data_name_by_id('wings',$data->wing_id)->wing_name }}</td>
            <td>{{ ((isset($data->subsector_id) && !empty($data->subsector_id)) ? get_data_name_by_id('subsectors',$data->subsector_id)->subsector_name:"") }}</td>
            <td>
                <a href="{{ url($edit_url.'/'.$data->id) }}" class="btn btn-xs btn-info">View</a>
                <button type="button" class="btn btn-xs btn-info" onclick="#">Delete</button>
            </td>

        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="8"><div class="no_data_message_style">Sorry, There is no data.</div></td>
        </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Name</th>
            <th>Short</th>
            <th>Code</th>
            <th>Wing</th>
            <th>Sub Sector</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>