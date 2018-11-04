<?php
    $user_type = getRoleIdByUserId(Auth::user()->id);
?>
<div class="search_area" id="project_quality_review">
    <form class="form-horizontal" id="on_progress_project_search" action="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Division of Bangladesh Planning Commission</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="pcdivision_id" name="pcdivision_id" onchange="hideErrorDiv('pcdivision_id'), loadWingByPcdivision(this.value)">
                    <option value="">Select PC Division</option>
                    <?php
                    if ($user_type == 4) {
                    $result = get_table_data_by_table('pcdivisions');
                    foreach ($result as $data) {
                        ?>
                        <option value="<?php echo $data->id ?>"><?php echo $data->pcdivision_name ?></option>
                    <?php }}else{
                        $result         =   get_data_name_by_id('users', Auth::user()->id);
                        $pcdiv_result   =   get_data_name_by_id('pcdivisions', $result->pcdivision_id);
                    ?>
                        <option value="<?php echo $pcdiv_result->id ?>"><?php echo $pcdiv_result->pcdivision_name ?></option>
                    <?php } ?>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">Wing</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="wing_id" name="wing_id">
                    <option value="">Select Wing</option>
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
        <a href="#" style="margin-left: 25% !important" class="btn btn-default col-md-offset-3" onclick="searchFilterData('{{ url('/admin/project/on_progress_project_search') }}','on_progress_project_search','example2')">Search</a>
    </form>    
</div>