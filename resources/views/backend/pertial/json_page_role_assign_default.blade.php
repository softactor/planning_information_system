@foreach ($all_screen_page as $data)
<tr>
    <td>{{ $data->commonconf_name }}</td>
    <td>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="add[]" value="{{ $data->id }}">
            </label>
        </div>
    </td>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="edit[]" value="{{ $data->id }}"></label>
        </div>
    </td>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="delete[]" value="{{ $data->id }}"></label>
        </div>
    </td>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="view[]" value="{{ $data->id }}"></label>
        </div>
    </td>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="print[]" value="{{ $data->id }}"></label>
        </div>
    </td>
</tr>
@endforeach