@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('Modules/CourseOffer/Resources/assets/style.css')}}">
@endpush
@php
    $table_name=''
@endphp
@section('table'){{$table_name}}@endsection

@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('frontendmanage.Course Offer')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">{{__('courses.Courses')}}</a>
                    <a href="#">{{__('frontendmanage.Course Offer')}}</a>
                </div>
            </div>
        </div>
    </section>




    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('courses.Offer Setting')}} </h4>
                        </div>
                        <form action="{{route('courseOffer')}}" method="POST">
                            @csrf
                            <div class="row">


                                <div class="col-lg-4 ">

                                    <label class="primary_input_label"
                                           for="offer_type">{{__('courses.Offer Type')}}</label>
                                    <div class="input-effect">
                                        <select class="primary_select" name="offer_type" id="offer_type">
                                            <option data-display="{{__('common.Select')}} {{__('courses.Offer Type')}}"
                                                    value="">{{__('common.Select')}} {{__('courses.Offer Type')}}</option>
                                            <option
                                                value="0" {{Settings('offer_type')==0?'selected':''}}>{{__('courses.Fixed')}}</option>
                                            <option
                                                value="1" {{Settings('offer_type')==1?'selected':''}}>{{__('courses.Percentage')}}
                                                (%)
                                            </option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-4 ">

                                    <label class="primary_input_label"
                                           for="offer_amount">{{__('courses.Amount')}}
                                        /{{__('courses.Percentage')}}</label>
                                    <div class="input-effect">
                                        <input type="number" placeholder="{{__('courses.Amount')}}"
                                               class="primary_input_field name"
                                               name="offer_amount" min="0" value="{{Settings('offer_amount')}}">

                                    </div>
                                </div>

                                <div class="col-lg-4   ">
                                    <div class="search_course_btn mt_35  ">
                                        <button type="submit"
                                                class="primary-btn radius_30px mr-10 fix-gr-bg"
                                                style="">{{__('common.Save')}} </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @lang('common.Add') {{__('frontendmanage.Course Offer')}}
                                </h3>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 card pt-4 pb-4">
                                    <div id="accordion">
                                        <div class="card mt-10">
                                            <div class="card-header" id="courses">
                                                <h5 class="mb-0 collapsed create-title" data-toggle="collapse"
                                                    data-target="#coursePage"
                                                    aria-expanded="false" aria-controls="coursePage">
                                                    <button class="btn btn-link cust-btn-link add_btn_link">
                                                        @lang('frontendmanage.Courses')
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="coursePage" class="collapse show" aria-labelledby="courses"
                                                 aria-expanded="true" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-15">

                                                                <select name="courses[]" id="courseInput" required
                                                                        class="primary_multiselect mb-15 e1" multiple>
                                                                    @foreach ($courses as $key => $course)
                                                                        <option
                                                                            value="{{ $course->id }}">{{ $course->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="row">
                                                                    <div class="col-lg-5">
                                                                        <input type="checkbox" id="coursesCheckbox"
                                                                               class="common-checkbox">
                                                                        <label for="coursesCheckbox"
                                                                               class="mt-3">@lang('frontendmanage.Select All')</label>
                                                                    </div>
                                                                    <div class="col-lg-7">
                                                                        <button id="add_course_page_btn" type="submit"
                                                                                class="primary-btn small fix-gr-bg  mt-3  submit_btn"
                                                                                data-toggle="tooltip"
                                                                                title="" data-original-title="">
                                                                            <span class="ti-check"></span>
                                                                            @lang('common.Add')
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-30">{{__('frontendmanage.Course Offer')}}  {{__('common.List')}} </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" id="courseList">
                            @include('courseoffer::list')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade admin-query" id="deleteSubmenuItem">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.Delete') </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>@lang('common.Are you sure to delete ?')</h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">@lang('common.Cancel')</button>
                            <input type="hidden" name="id" id="item-delete" value="">
                            <a class="primary-btn fix-gr-bg" id="delete-item" href="#">@lang('common.Delete')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="bundle_course_delete_url" value="{{ route('removeOfferCourse') }}">
        <input type="hidden" id="course_add_url" value="{{route('addOfferCourse')}}">
        <input type="hidden" id="header_token" value="{{csrf_token()}}">

    </section>
@endsection
@push('scripts')
    @include('courseoffer::script')
@endpush

