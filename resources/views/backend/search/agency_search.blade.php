<div class="search_area">
    <form class="form-inline" id="search_agency" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <input type="text" class="form-control" id="agency1" placeholder="Agency Name" name="agency_name" value="{{ old('agency_name') }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="short" placeholder="Agency Short Name" name="agency_short_name" value="{{ old('agency_short_name') }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="code" placeholder="Agency Code" name="agency_code" value="{{ old('agency_code') }}">
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/agency/searchAgency') }}','search_agency','example2')">Search</a>
    </form>    
</div>