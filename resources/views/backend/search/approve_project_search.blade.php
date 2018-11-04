<div class="search_area" id="project_quality_review">
    <form class="form-horizontal" id="approve_project_search" action="">
        <meta name="csrf-token" content="{{ csrf_token() }}">         
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="lname">Project name</label>                                
            <div class="col-sm-6 col-md-6">
                <input type="text" class="form-control" id="search_project" placeholder="Project" name="search_project" value="{{ old('search_project') }}">
            </div>           
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Ministry/Division</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="ministry_id" name="ministry_id" onchange="hideErrorDiv('ministry_id')">
                    <option value="">Select Ministry</option>
                    <?php
                    $order_by['order_by_column']   =   "ministry_name";
                    $order_by['order_by']          =   "ASC";
                    $result = get_table_data_by_table('ministries', $order_by);
                    foreach ($result as $data) {
                        ?>
                        <option value="<?php echo $data->id ?>" {{($data->id == old('ministry_id')) ? 'selected' : ''}}><?php echo $data->ministry_name ?></option>
                    <?php } ?>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Lead Agency</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="agency_id" name="agency_id" onchange="hideErrorDiv('agency_id')">
                    <option value="">Select Agency(Lead)</option>
                    <?php
                    $result = get_table_data_by_table('agencies');
                    foreach ($result as $data) {
                        ?>
                        <option value="<?php echo $data->id ?>" {{($data->id == old('agency_id')) ? 'selected' : ''}}><?php echo $data->agency_name ?></option>
                    <?php } ?>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Division of Bangladesh Planning Commission</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="pcdivision_id" name="pcdivision_id" onchange="hideErrorDiv('pcdivision_id'), loadWingByPcdivision(this.value)">
                    <option value="">Select PC Division</option>
                    <?php
                    $result = get_table_data_by_table('pcdivisions');
                    foreach ($result as $data) {
                        ?>
                        <option value="<?php echo $data->id ?>"><?php echo $data->pcdivision_name ?></option>
                    <?php } ?>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Wing</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="wing_id" name="wing_id">
                    <option value="">Select Wing</option>
                    <?php
                    $order_by = [];
                    $order_by['order_by_column'] = "wing_name";
                    $order_by['order_by'] = "ASC";
                    $result = get_table_data_by_table('wings', $order_by);
                    foreach ($result as $data) {
                        ?>
                        <option value="<?php echo $data->id ?>" {{($data->id == old('wing_id')) ? 'selected' : ''}}><?php echo $data->wing_name ?></option>
                    <?php } ?>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="lname">Project cost</label>                                
            <div class="col-sm-3 col-md-3">
               <select class="form-control" id="project_cost_filter" name="project_cost_filter">
                    <option value="">Select Filter</option>
                    <option value="=">=</option>
                    <option value=">">></option>
                    <option value=">=">>=</option>
                    <option value="<"><</option>
                    <option value="<="><=</option>
                </select>
            </div>
            <div class="col-sm-3 col-md-3">
                <input type="text" class="form-control" id="cost_filter_amount" placeholder="Figure(Lac)" name="cost_filter_amount" value="{{ old('cost_filter_amount') }}">
            </div>
            
        </div>        
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Sub-sectors</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="subsector_id" name="subsector_id" onchange="hideErrorDiv('subsector_id')">
                    <option value="">Select ADP Sub-Sector</option>
                    <?php
                    $result = get_table_data_by_table('subsectors');
                    foreach ($result as $data) {
                        ?>
                        <option value="<?php echo $data->id ?>" {{($data->id == old('subsector_id')) ? 'selected' : ''}}><?php echo $data->subsector_name ?></option>
                    <?php } ?>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="lname">Implementation period</label>                                
            <div class="col-sm-3 col-md-3">
                From Date <input type="text" class="form-control" id="search_from_date" placeholder="From Date" name="search_from_date" value="{{ old('search_from_date') }}">
            </div>
            <div class="col-sm-3 col-md-3">
                To Date <input type="text" class="form-control" id="search_to_date" placeholder="To Date" name="search_to_date" value="{{ old('search_to_date') }}">
            </div>
            
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="lname">Location</label>                                
            <div class="col-sm-3 col-md-3">
                Division
                <select class="form-control" id="div_id" name="div_id" onchange="loadDistrict(this.value);hideErrorDiv('div_id')">
                    <option value="">Select</option>
                    @php
                    $order_by   =   [];
                    $order_by['order_by_column']   =   "dvname";
                    $order_by['order_by']   =   "ASC";
                    $pcdivisions    =   get_table_data_by_table('admdivisions',$order_by);
                    foreach($pcdivisions as $data){
                    @endphp
                    <option value="{{$data->id}}" {{($data->id == old('div_id') || Session::get('div_id')==$data->id) ? 'selected' : ''}}>{{$data->dvname}}</option>
                    @php
                    }
                    @endphp
                </select>
            </div>
            <div class="col-sm-3 col-md-3">
                District
                <select class="form-control" id="district_id" name="district_id" onchange="loadUpozila(this.value);">
                        <option value="">Select</option>
                    </select>
            </div>            
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="lname"></label>                                
            <div class="col-sm-3 col-md-3">
                Upazila 
                <select class="form-control" id="upz_id" name='upz_id' onchange="loadConstituencyByUpz(this.value), loadUnionByUpazila(this.value);">
                    <option value="">Select</option>                    
                </select>
            </div>
            <div class="col-sm-3 col-md-3">
                Union 
                <select class="form-control" id="union_id" name="union_id" onchange="hideErrorDiv('union_id')">
                    <option value="">Select Union</option>
                    @php
                    $unions    =   get_table_data_by_table('bd_unions');
                    foreach($unions as $data){
                    @endphp
                    <option value="{{$data->id}}" {{($data->id == old('union_id') || Session::get('union_id')==$data->id) ? 'selected' : ''}}>{{$data->bd_union_name}}</option>
                    @php
                    }
                    @endphp
                </select>
            </div>            
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="lname"></label>                                
            <div class="col-sm-3 col-md-3">
                City Corporation
                <select class="form-control" id="city_corp_id" name="city_corp_id" onchange="hideErrorDiv('city_corp_id')">
                    <option value="">Select City Corporation</option>
                    @php
                    $pcdivisions    =   get_table_data_by_table('citycorporations');
                    foreach($pcdivisions as $data){
                    @endphp
                    <option value="{{$data->id}}" {{($data->id == old('city_corp_id') || Session::get('city_corp_id')==$data->id) ? 'selected' : ''}}>{{$data->citycorp_name}}</option>
                    @php
                    }
                    @endphp
                </select>
            </div>
            <div class="col-sm-3 col-md-3">
                Wards
                <select class="form-control" id="ward_id" name="ward_id" onchange="loadConstituencyByWard(this.value);">
                    <option value="">Select Ward</option>
                    @php
                    $pcdivisions    =   get_table_data_by_table('wards');
                    foreach($pcdivisions as $data){
                    @endphp
                    <option value="{{$data->id}}">{{$data->ward_nr}}</option>
                    @php
                    }
                    @endphp
                </select>
            </div>            
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div"></label>
            <div class="checkbox col-sm-6 col-md-6">
                <label><input type="checkbox" name="all" value="all" > All</label>
            </div>
        </div>
        &nbsp;
        <a href="#" style="margin-left: 25% !important" class="btn btn-default col-md-offset-3" onclick="searchFilterData('{{ url('/admin/project/approved_project_search') }}','approve_project_search','example2')">Search</a>
    </form>    
</div>