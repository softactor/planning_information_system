<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Constituency</th>
            <th>Name</th>
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
            <td>{{ $data->const_id }}</td>
            <td>{{ $data->name }}</td>
            <td>
                <a href="{{ url($edit_url.'/'.$data->id) }}" class="btn btn-xs btn-info">Edit</a>
                <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$data->id}}, 'constituency');">Delete</button>
            </td>

        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="3"><div class="no_data_message_style">Sorry, There is no data.</div></td>
        </tr>
        @endif
    </tbody>
</table>