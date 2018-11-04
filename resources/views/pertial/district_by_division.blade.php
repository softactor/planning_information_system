<option value=''>select</option>
@foreach ($table_data as $data)
    <option value="{{$data->id}}">{{$data->district_name}}</option>
@endforeach

