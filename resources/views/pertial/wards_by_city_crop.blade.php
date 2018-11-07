<option value=''>select</option>
@foreach ($table_data as $data)
    <option value="{{$data->id}}">{{$data->ward_nr}}</option>
@endforeach

