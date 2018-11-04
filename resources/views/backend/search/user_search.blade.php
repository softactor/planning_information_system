<div class="search_area" style="margin-right: 8%;">
    <form class="form-horizontal" id="search_user" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <label class="control-label col-sm-3" for="div">Division of Bangladesh Planning Commission</label>
            <div class="col-sm-3">
                <select style="width: 300px" class="form-control" id="pcdivision_id" name="pcdivision_id" onchange="loadWingByPcDivision(this.value);">
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
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="wing">Wing</label>
            <div class="col-sm-3">
                <select style="width: 300px" class="form-control" id="wing_id" name="wing_id">
                    <option value="">Select</option>
                    <?php  
                    $order_by   =   [];
                    $order_by['order_by_column']   =   "wing_name";
                    $order_by['order_by']   =   "ASC";
                    $result = get_table_data_by_table('wings',$order_by);
                    foreach($result as $data){
                    ?>
                    <option value="<?php echo $data->id ?>" {{($data->id == old('wing_id')) ? 'selected' : ''}}><?php echo $data->wing_name ?></option>
                    <?php } ?>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="lname">Name</label>                                
            <div class="col-sm-8">
                <input style="width:298px;" type="text" class="form-control" id="last_name" placeholder="Enter name" name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="div"></label>
            <div class="checkbox col-sm-3">
                <label><input type="checkbox" name="all" value="all" > All</label>
            </div>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default col-md-offset-3" onclick="searchFilterData('{{ url('/admin/users/searchUsers') }}','search_user','example2')">Search</a>
    </form>    
</div>
@section('footer_js_scrip_area')
    @parent
    <script>
        function loadWingByPcDivision(pcdivision_id) {
            if (pcdivision_id) {
                $.ajax({
                    url: '{{url("admin/dashbord/loadWingByPcDivision")}}',
                    type: "get",
                    dataType: "JSON",
                    data: "pcdivision_id=" + pcdivision_id,
                    success: function (response) {
                        $("#wing_id").html(response);
                    }
                });
            }
        }
    </script>
@endsection