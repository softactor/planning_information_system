<div class="search_area">
    <form class="form-inline" id="search_commonconfig" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <div class="col-sm-8">
                <input type="text" class="form-control" id="commonconf_name" placeholder="Name" name="commonconf_name" value="{{ old('commonconf_name') }}">
            </div>    
        </div>
        <div class="form-group">
            <div class="col-sm-8">
                <select class="form-control" id="commonconf_type" name="commonconf_type">
                    <option value="">Select Type</option>
                    @php
                    $configType =   get_table_data_by_table('configuration_type');
                    foreach($configType as $data){
                    @endphp
                    <option value="{{$data->id}}">{{$data->name}}</option>
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
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/commonconf/searchCommonconf') }}','search_commonconfig','example2')">Search</a>
    </form>    
</div>