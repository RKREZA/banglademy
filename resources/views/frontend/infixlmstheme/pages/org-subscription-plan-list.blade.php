@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |
{{__('org-subscription.My Plan')}}
@endsection
@section('css')
    <link href="{{asset('public/frontend/infixlmstheme/css/org-subscription.css')}}" rel="stylesheet"/>
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/my_course.js')}}"></script>
@endsection

@section('mainContent')
    <x-my-org-subscription-plan-list-section :plan="$planId"  :request="$request"/>
@endsection
