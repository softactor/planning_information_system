<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Division</th>
            <th>District</th>
            <th>Category</th>
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
            <td>{{ get_data_name_by_id('admdivisions',$data->div_id)->dvname }}</td>
            <td>
                <?php
                if (isset($data->dis_id) && !empty($data->dis_id)) {
                    echo get_data_name_by_id('districts', $data->dis_id)->district_name;
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($data->cat_id) && !empty($data->cat_id)) {
                    if ($data->cat_id == 1) {
                        echo 'City corporation';
                    } elseif ($data->cat_id == 2) {
                        echo 'Municipality';
                    }
                }
                ?>
            </td>
            <td>{{ $data->citycorp_name }}</td>
            <td>
                <a href="{{ url($edit_url.'/'.$data->id) }}" class="btn btn-xs btn-info">Edit</a>
                <button type="button" class="btn btn-xs btn-info" onclick="common_delete({{$data->id}}, 'citycorporations');">Delete</button>
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