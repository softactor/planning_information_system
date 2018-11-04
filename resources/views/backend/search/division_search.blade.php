<div class="search_area">
    <form class="form-inline" id="search_division" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <div class="col-sm-8">
                <input type="text" class="form-control" id="div1" placeholder="Division Name" name="dvname" value="{{ old('dvname') }}">
            </div>    
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/division/search_division') }}','search_division','example2')">Search</a>
    </form>    
</div>