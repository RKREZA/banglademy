<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{ __('common.Action') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">
        @if (permissionCheck('bundle.update'))
            <a href="{{route('bundle.edit',['id'=>$data->id])}}" class="dropdown-item">{{__('common.Edit')}}</a>
        @endif

        @if (permissionCheck('course.store'))
            <a onclick="confirm_modal('{{route('bundle.delete', $data->id)}}')"
               class="dropdown-item edit_brand">{{ __('common.Delete')  }}</a>
        @endif

        @if (permissionCheck('course.store'))
            <a href="{{route('course.index',['id'=>$data->id])}}"
               class="dropdown-item">{{ __('bundleSubscription.Add course')  }}</a>
        @endif


    </div>
</div>


