@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Blogs')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')

    <div>
        <div class="breadcrumb_area bradcam_bg_2"
             style="background-image: url('{{asset($frontendContent->blog_page_banner)}}');height: 300px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcam_wrap d-flex justify-content-center" style=" max-width: none;">
                        <span>
                            {{$frontendContent->blog_page_title}}
                        </span>
                            <h3 style="font-size: 40px; font-family: 'Hind Siliguri', sans-serif">
                                {{$frontendContent->blog_page_sub_title}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <x-blog-page-section/>

@endsection
