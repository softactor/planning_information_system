<div class="search_area">
    <form class="form-inline" id="search_gisobject" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <div class="col-sm-8">
                <input type="text" class="form-control" id="gis" placeholder="Name" name="gisobject_name" value="{{ old('gisobject_name') }}">
            </div>    
        </div>
        <div class="form-group">
            <div class="col-sm-8">
                <select class="form-control" id="gisobject_type" name="gisobject_type">
                    <option value="">Select Type</option>
                    @php
                    $param['table']  =  "commonconfs";   
                    $param['where']  =  [
                    'commonconf_type'   =>  9
                    ];   
                    $all_pages = get_table_data_by_clause($param);
                    foreach($all_pages as $data){
                    @endphp
                    <option value="{{$data->commonconf_name}}">{{$data->commonconf_name}}</option>
                    @php
                    }
                    @endphp
                </select>
            </div>    
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/gisobject/searchGisobject') }}','search_gisobject','example2')">Search</a>
    </form>    
</div>