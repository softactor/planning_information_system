<div class="search_area">
    <form class="form-inline" id="search_union" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <select class="form-control" id="div_id" name="div_id" onchange="loadDistrict(this.value);hideErrorDiv('div_id')">
                <option value="">Division</option>
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
            <select class="form-control" id="dis_id" name="dis_id" onchange="loadUpazila(this.value);">
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
            <select class="form-control" id="upz_id" name="upz_id">
                <option value="">Upazila</option>
                @php
                $upazilass    =   get_table_data_by_table('upazilas');
                foreach($upazilass as $data){
                @endphp
                <option value="{{$data->id}}">{{$data->upazila_name}}</option>
                @php
                }
                @endphp
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="bd_union_name" placeholder="Union">
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/union/searchUnion') }}','search_union','example2')">Search</a>
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
        function loadUpazila(district_id){
            if(district_id){    
                $.ajax({
                        url         :'{{url("admin/dashbord/loadUpazilaByDistrict")}}',
                        type        :"get",
                        dataType    :"JSON",
                        data        :"district_id="+district_id,
                        success     :function(response){
                            $("#upz_id").html(response);
                        }
                    });
            }
        }
    </script>
@endsection