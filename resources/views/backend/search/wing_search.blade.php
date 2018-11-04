<div class="search_area">
    <form class="form-inline" id="search_wing" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <select class="form-control" id="pcdivision_id" name="pcdivision_id">
                <option value="">Select</option>
                @php
                $pcdivisions    =   get_table_data_by_table('pcdivisions');
                foreach($pcdivisions as $data){
                @endphp
                <option value="{{$data->id}}">{{$data->pcdivision_name}}</option>
                @php
                }
                @endphp
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="wing_name" placeholder="Wing Name">
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/wing/searchWing') }}','search_wing','example2')">Search</a>
    </form>    
</div>