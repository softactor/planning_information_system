<div class="search_area">
    <form class="form-inline" id="search_subsector" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <select class="form-control" id="sector_id" name="sector_id">
                <option value="">Select</option>
                @php
                $pcdivisions    =   get_table_data_by_table('sectors');
                foreach($pcdivisions as $data){
                @endphp
                <option value="{{$data->id}}">{{$data->sector_name}}</option>
                @php
                }
                @endphp
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="subsector_name" placeholder="Subsector Name">
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/subsector/searchSubsector') }}','search_subsector','example2')">Search</a>
    </form>    
</div>