<div class="search_area">
    <form class="form-inline" id="search_constituency" action="/action_page.php">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="form-group">
            <div class="col-sm-8">
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ old('name') }}">
            </div>    
        </div>
        <div class="form-group">
            <div class="col-sm-8">
                <input type="text" class="form-control" id="const_id" placeholder="Constituency" name="const_id" value="{{ old('const_id') }}">
            </div>    
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="all" value="all" > All</label>
        </div>
        &nbsp;
        <a href="#" class="btn btn-default" onclick="searchFilterData('{{ url('/admin/constituency/searchConstituency') }}','search_constituency','example2')">Search</a>
    </form>    
</div>