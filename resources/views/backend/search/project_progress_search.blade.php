<div class="search_area" id="project_quality_review">
    <form class="form-horizontal" id="project_progress_search" action="">
        <meta name="csrf-token" content="{{ csrf_token() }}">         
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="lname">Project</label>                                
            <div class="col-sm-6 col-md-6">
                <input type="text" class="form-control" id="search_project" placeholder="Project" name="search_project" value="{{ old('search_project') }}">
            </div>           
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Ministry/ Division</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="ministry_id" name="ministry_id" onchange="hideErrorDiv('ministry_id'), loadAgencyByMinstry(this.value)">
                                        <option value="">Select Ministry</option>
                                        <?php
                                        $order_by   =   [];
                                        $order_by['order_by_column']   =   "ministry_name";
                                        $order_by['order_by']   =   "ASC";
                                        $result = get_table_data_by_table('ministries',$order_by);
                                        foreach($result as $data){
                                        ?>
                                        <option value="<?php echo $data->id ?>" {{($data->id == old('ministry_id')) ? 'selected' : ''}}><?php echo $data->ministry_name."(".$data->ministry_name_bn.")" ?></option>
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
            <label class="control-label col-sm-5 col-md-5" for="div">Division of Bangladesh Planning Commission</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="pcdivision_id" name="pcdivision_id" onchange="hideErrorDiv('pcdivision_id')">
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
            <label class="control-label col-sm-5 col-md-5" for="div">Sub sectors</label>
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
            <label class="control-label col-sm-5 col-md-5" for="div">Project type</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="project_type" name="project_type">
                    <option value="">Select</option>
                    <option value="1">New</option>
                    <option value="2">Revised</option>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Progress type</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="progress_type" name="progress_type">
                    <option value="">Progress type</option>
                    <?php
                    $param['table'] = "commonconfs";
                    $param['where'] = [
                        'commonconf_type' => 10
                    ];
                    $proposal = get_table_data_by_clause($param);
                    foreach ($proposal as $type) {
                        if (isset($submitButtonText) &&  $submitButtonText== "Update") {
                            ?>
                            <option value="<?php echo $type->commonconf_name ?>" <?php
                            if ($project_progress->progresstype == $type->commonconf_name) {
                                echo "selected";
                            }
                            ?>><?php echo $type->commonconf_name ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $type->commonconf_name ?>"><?php echo $type->commonconf_name ?></option>
                    <?php }
                } ?>
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
        <a href="#" style="margin-left: 25% !important" class="btn btn-default col-md-offset-3" onclick="searchFilterData('{{ url('/admin/project/project_progress_search') }}','project_progress_search','example2')">Search</a>
    </form>    
</div>