@if ($alert_message = Session::get('success'))
<div class="alert alert-success">
    <strong>Success!</strong> {{ $alert_message}} 
</div>
@endif
@if ($alert_message = Session::get('error'))
<div class="alert alert-danger">
    <strong>Info!</strong> {{ $alert_message}}
</div>
@endif
@if ($alert_message = Session::get('warning'))
<div class="alert alert-warning">
    <strong>Warning!</strong> {{ $alert_message}}
</div>
@endif
@if ($alert_message = Session::get('info'))
<div class="alert alert-info">
    <strong>Danger!</strong> {{ $alert_message}}
</div>
@endif
<div class="alert alert-success json_alert_message" id='success_message'>
    <strong>Success!</strong> <span id='message'></span> 
</div>
<div class="alert alert-info json_alert_message" id='info_message'>
    <strong>Info!</strong> {{ $alert_message}}
</div>
<div class="alert alert-warning json_alert_message" id='warning_message'>
    <strong>Warning!</strong> {{ $alert_message}}
</div>
<div class="alert alert-danger json_alert_message" id='danger_message'>
    <strong>Danger!</strong> {{ $alert_message}}
</div>
