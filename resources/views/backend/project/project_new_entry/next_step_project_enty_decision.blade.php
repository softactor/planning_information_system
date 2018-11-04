@if ($success_message = Session::get('next_success'))
<div class="alert alert-success success_entry_next">
  <strong>Success!</strong> <?php if(isset($success_message) && !empty($success_message)){ echo $success_message;} ?>
  <?php
    $no_link    =   Session::get('no_link');
    $yes_link   =   Session::get('yes_link');
  ?>
  <a href="{{ url($no_link) }}" class="btn btn-info pull-right" role="button">NO</a>
  <a href="{{ url($yes_link) }}" class="btn btn-info pull-right" role="button">YES</a>
</div>
@endif