<div class="search_area">
    <form class="form-inline" id="search_citycorporation" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <select class="form-control" id="div_id" name="div_id">
                <option value="">Select</option>
                @php
                $pcdivisions    =   get_table_data_by_table('admdivisions');
                foreach($pcdivisions as $data){
                @endphp
                <option value="{{$data->id}}">{{$data->dvname}}</option>
                @php
                }
                @endphp
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="city1" name="citycorp_name" value="{{ old('citycorp_name') }}">
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/citycorporation/searchCitycorporation') }}','search_citycorporation','example2')">Search</a>
    </form>    
</div>