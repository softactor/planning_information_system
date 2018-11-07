<div class="search_area">
    <form class="form-inline" id="search_citycorporation" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <select class="form-control" id="div_id" name="div_id" onchange="loadDistrict(this.value);hideErrorDiv('div_id')">
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
            <select class="form-control" id="dis_id" name="dis_id">
                <option value="">District</option>
                @php
                $pcdivisions    =   get_table_data_by_table('districts');
                foreach($pcdivisions as $data){
                @endphp
                <option value="{{$data->id}}">{{$data->district_name}}</option>
                @php
                }
                @endphp
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="cat_id" name="cat_id">
                <option value="">Select</option>
                <option value="1">City corporation</option>
                <option value="2">Municipality</option>
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
@section('footer_js_scrip_area')
    @parent
    <script>
        function loadDistrict(division_id) {
            if (division_id) {
                $.ajax({
                    url: '{{url("admin/dashbord/loadDivisionByDistrict")}}',
                    type: "get",
                    dataType: "JSON",
                    data: "division_id=" + division_id,
                    success: function (response) {
                        $("#dis_id").html(response);
                    }
                });
            }
        }
    </script>
@endsection