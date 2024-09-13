@extends(theme('layouts.master'))
{{--@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{$blog->title??''}} @endsection--}}
@section('title'){{$blog->title??''}} | {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}}@endsection

@section('meta_title'){{$blog->title}}@endsection
@section('meta_description'){{$blog->title}}@endsection

{{--@section('meta_description')--}}
{{--    <meta name="description" content="{{html_entity_decode($blog->description)}} ">--}}
{{--    <meta property="og:description" content="{{html_entity_decode($blog->description)}}">--}}
{{--@endsection--}}

@section('css') @endsection
@section('js') @endsection
@section('og_image'){{asset($blog->image)}}@endsection
@section('mainContent')


    <x-blog-details-page-section :blog="$blog"/>
    

@endsection
