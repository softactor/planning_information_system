<div class="search_area">
    <form class="form-inline" id="search_ministry" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <input type="text" name="ministry_code" placeholder="Ministry Code">
        </div>
        <div class="form-group">
            <input type="text" name="ministry_name" placeholder="Name">
        </div>
        <div class="form-group">
            <input type="text" name="ministry_short_name" placeholder="Short Name">
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/ministry/searchMinistry') }}','search_ministry','example2')">Search</a>
    </form>    
</div>