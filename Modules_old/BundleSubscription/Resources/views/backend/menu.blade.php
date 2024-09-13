<li>
    <a href="#" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small"><span class="fas fa-images"></span></div>
        <div class="nav_title"><span>{{__('bundleSubscription.Bundle Subscription')}}</span></div>
    </a>
    <ul>
        @if (permissionCheck('bundle.subscription'))
            <li><a href="{{ route('bundle.course') }}">   {{ __('bundleSubscription.Bundle Course') }}</a></li>
        @endif
        @if (permissionCheck('bundle.setting.index'))
            <li><a href="{{ route('bundle.setting.index') }}">   {{ __('bundleSubscription.Bundle Setting') }}</a></li>
        @endif

    </ul>
</li>
