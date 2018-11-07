<option value=''>select</option>
@foreach ($table_data as $data)
    <option value="{{$data->id}}">{{$data->citycorp_name}}</option>
@endforeach

