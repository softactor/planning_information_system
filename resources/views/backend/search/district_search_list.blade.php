<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Division</th>
            <th>District</th>
            <th>District Bn</th>
            <th>GEO Code</th>
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
            <td>{{ get_data_name_by_id('admdivisions',$data->div_id)->dvname }}</td>
            <td>{{ $data->district_name }}</td>
            <td>{{ $data->district_bn }}</td>
            <td>{{ $data->geo_code }}</td>
            <td>
                <a href="{{ url($edit_url.'/'.$data->id) }}" class="btn btn-xs btn-info">Edit</a>
                <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$data->id}}, 'districts');">Delete</button>
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
            <th>Division</th>
            <th>District</th>
            <th>District Bn</th>
            <th>GEO Code</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>