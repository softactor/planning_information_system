@foreach ($all_screen_page as $data)
<tr>
    <td><?php echo $data['commonconf_name']; ?></td>
    <td>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="add[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['add']) { ?> checked <?php } ?>>
            </label>
        </div>
    </td>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="edit[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['edit']) { ?> checked <?php } ?>></label>
        </div>
    </td>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="delete[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['delete']) { ?> checked <?php } ?>></label>
        </div>
    </td>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="view[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['view']) { ?> checked <?php } ?>></label>
        </div>
    </td>
    <td>
        <div class="checkbox">
            <label><input type="checkbox" name="print[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['print']) { ?> checked <?php } ?>></label>
        </div>
    </td>
</tr>
@endforeach