@if (permissionCheck('change.status'))
    <label  data-item="{{$data->id}}" class="switch_toggle" for="active_checkbox{{$data->id}}">
        <input type="checkbox" class="status_enable_disable" onchange="update_status(this)"
               id="active_checkbox{{$data->id}}" value="{{ $data->id}}"
            {{ $data->status == 1 ? "checked" : "" }}><i class="slider round"></i>
    </label>
@endif


