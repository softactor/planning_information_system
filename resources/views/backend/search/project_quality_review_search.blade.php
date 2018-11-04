<div class="search_area" id="project_quality_review">
    <form class="form-horizontal" id="project_quality_review_search_form" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="lname">Status Date</label>                                
            <div class="col-sm-3 col-md-3">
                From Date <input type="text" class="form-control" id="search_from_date" placeholder="From Date" name="search_from_date" value="{{ old('search_from_date') }}">
            </div>
            <div class="col-sm-3 col-md-3">
                To Date <input type="text" class="form-control" id="search_to_date" placeholder="To Date" name="search_to_date" value="{{ old('search_to_date') }}">
            </div>
            
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5 col-md-5" for="div">User (Data Entry Operator)</label>
            <div class="col-sm-6 col-md-6">
                <select class="form-control" id="user_id" name="user_id">
                    <option value="">Select</option>
                    @php
                    $pcdivisions    =   getRoleWiseUser(9);
                    foreach($pcdivisions as $data){
                    @endphp
                    <option value="{{$data->id}}">{{$data->name}}</option>
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
        <a href="#" style="margin-left: 25% !important" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/project/project_quality_review_search') }}','project_quality_review_search_form','example2')">Search</a>
    </form>    
</div>