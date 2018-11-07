<div class="search_area">
    <form class="form-inline" id="search_ward" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <select class="form-control" id="cat_id" name="cat_id" onchange="loadCityCropByCat(this.value);">
                <option value="">Select</option>
                <option value="1">City corporation</option>
                <option value="2">Municipality</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="citycorp_id" name="citycorp_id">
                <option value="">Select</option>
                @php
                $pcdivisions    =   get_table_data_by_table('citycorporations');
                foreach($pcdivisions as $data){
                @endphp
                <option value="{{$data->id}}">{{$data->citycorp_name}}</option>
                @php
                }
                @endphp
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="ward_nr" placeholder="Name">
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/ward/searchWard') }}','search_ward','example2')">Search</a>
    </form>    
</div>
@section('footer_js_scrip_area')
    @parent
    <script>
        function loadCityCropByCat(cat_id){
            if(cat_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadCityCropByCat")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"cat_id="+cat_id,
                        success     :function(response){
                            $("#citycorp_id").html(response);
                        }
                    });
            }
        }
    </script>
@endsection