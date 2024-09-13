<div>
    <div class="main_content_iner main_content_padding">
        <div class="container">
            <div class="row align-items-center pt-3">
                <div class="col-lg-6 ">
                    <div class="cat_welcome_text mb_20">
                        <h3>{{@$wish_string}}, {{Auth::user()->name}} </h3>
                        <p>{{@$date}}</p>
                    </div>
                </div>
                <div class="{{Settings('student_dashboard_card_view')==0?'col-lg-6':'col-lg-12'}} ">

                    @if(Settings('student_dashboard_card_view')==0)
                        <div class="row">
                            <div class="col-md-4">
                                <h4>
                                    @if($total_spent!=0)
                                        {{getPriceFormat($total_spent)}}
                                    @else
                                        {{Settings('currency_symbol') ??'৳'}}  0
                                    @endif
                                </h4>
                                <p>{{__('frontend.Total Spent')}}</p>
                            </div>
                            <div class="col-md-4">
                                <h4>{{@$total_purchase}}</h4>
                                <p>{{__('frontend.Course Purchased')}}</p>
                            </div>
                            <div class="col-md-4">
                                <h4>
                                    @if(Auth::user()->balance==0)
                                        {{Settings('currency_symbol') ??'৳'}} 0
                                    @else
                                        {{getPriceFormat(Auth::user()->balance)}}
                                    @endif
                                </h4>
                                <p>{{__('frontend.Balance')}}</p>
                            </div>
                        </div>
                    @else

                        <div class="dashboard_card d-flex justify-content-between gap_10  dashboard_card">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <h4 class="pb-0 mb-0">
                                            @if($total_spent!=0)
                                                {{getPriceFormat($total_spent)}}
                                            @else
                                                {{Settings('currency_symbol') ??'৳'}}  0
                                            @endif
                                        </h4>
                                        <p class="">{{__('frontend.Total Spent')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <h4 class="pb-0 mb-0">{{@$total_purchase}}</h4>
                                        <p class="">{{__('frontend.Course Purchased')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <h4 class="pb-0 mb-0">
                                            @if(Auth::user()->balance==0)
                                                {{Settings('currency_symbol') ??'৳'}} 0
                                            @else
                                                {{getPriceFormat(Auth::user()->balance)}}
                                            @endif
                                        </h4>
                                        <p>{{__('frontend.Balance')}}</p>
                                    </div>
                                </div>
                                @php
                                    $total =\Illuminate\Support\Facades\Auth::user()->totalStudentCourses();
                                @endphp
                                <div class="col-md-4">
                                    <div class="card">
                                        <h4 class="pb-0 mb-0">
                                            {{$total['process']}}

                                        </h4>
                                        <p>{{__('frontend.Course In Progress')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <h4 class="pb-0 mb-0">
                                            {{$total['complete']}}
                                        </h4>
                                        <p>{{__('frontend.Completed Courses')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <h4 class="pb-0 mb-0">
                                            {{\Illuminate\Support\Facades\Auth::user()->totalCertificate()}}
                                        </h4>
                                        <p>{{__('frontend.Certificates')}}</p>
                                    </div>
                                </div>
                            </div>

{{--                            <div class="card">--}}
{{--                                <h4 class="pb-0 mb-0">--}}
{{--                                    @if($total_spent!=0)--}}
{{--                                        {{getPriceFormat($total_spent)}}--}}
{{--                                    @else--}}
{{--                                        {{Settings('currency_symbol') ??'৳'}}  0--}}
{{--                                    @endif--}}
{{--                                </h4>--}}
{{--                                <p class="">{{__('frontend.Total Spent')}}</p>--}}
{{--                            </div>--}}

{{--                            <div class="card">--}}
{{--                                <h4 class="pb-0 mb-0">{{@$total_purchase}}</h4>--}}
{{--                                <p class="">{{__('frontend.Course Purchased')}}</p>--}}
{{--                            </div>--}}

{{--                            <div class="card">--}}
{{--                                <h4 class="pb-0 mb-0">--}}
{{--                                    @if(Auth::user()->balance==0)--}}
{{--                                        {{Settings('currency_symbol') ??'৳'}} 0--}}
{{--                                    @else--}}
{{--                                        {{getPriceFormat(Auth::user()->balance)}}--}}
{{--                                    @endif--}}
{{--                                </h4>--}}
{{--                                <p>{{__('frontend.Balance')}}</p>--}}
{{--                            </div>--}}
{{--                            @php--}}
{{--                                $total =\Illuminate\Support\Facades\Auth::user()->totalStudentCourses();--}}

{{--                            @endphp--}}
{{--                            <div class="card">--}}
{{--                                <h4 class="pb-0 mb-0">--}}
{{--                                    {{$total['process']}}--}}

{{--                                </h4>--}}
{{--                                <p>{{__('frontend.Course In Progress')}}</p>--}}
{{--                            </div>--}}

{{--                            <div class="card">--}}
{{--                                <h4 class="pb-0 mb-0">--}}
{{--                                    {{$total['complete']}}--}}
{{--                                </h4>--}}
{{--                                <p>{{__('frontend.Completed Courses')}}</p>--}}
{{--                            </div>--}}

{{--                            <div class="card">--}}
{{--                                <h4 class="pb-0 mb-0">--}}
{{--                                    {{\Illuminate\Support\Facades\Auth::user()->totalCertificate()}}--}}
{{--                                </h4>--}}
{{--                                <p>{{__('frontend.Certificates')}}</p>--}}
{{--                            </div>--}}
                        </div>


                    @endif

                </div>
            </div>
        </div>

        <br>
        <div class="container">
            <div class="col-12 pl-0">
                <!-- dashboard_banner  -->
                @if($mycourse)
                    @foreach($mycourse as $key=>$single_course)
                        @if($key<1)
                            @php
                                $course =$single_course->course;
                            @endphp
                            <div class="dashboard_banner">
                                <div class="thumb">
                                    <img class="thumb w-100" src="{{getCourseImage($course->thumbnail)}}" alt="">
                                </div>
                                <div class="banner_info">
                                    <h4>
                                        <a href="{{route('continueCourse',[$course->slug])}}">
                                            {{$course->title}}
                                        </a>
                                    </h4>
                                    <p>{!! shortDetails($course->about,200) !!}</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{round($course->loginUserTotalPercentage)}}%"
                                             aria-valuenow="25"
                                             aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="course_qualification">
                                        <p> {{round($course->loginUserTotalPercentage)}}% {{__('student.Complete')}}</p>
                                        <div class="rating_star text-right pt-2">

                                            @php
                                                $PickId=$course->id;
                                            @endphp

                                            @if(!$course->isLoginUserReview)
                                                <div
                                                        class="star_icon d-flex align-items-center justify-content-end">
                                                    <a class="rating">
                                                        <input type="radio" id="star5" name="rating"
                                                               value="5"
                                                               class="rating"/><label
                                                                class="full" for="star5" id="star5"
                                                                title="Awesome - 5 stars"
                                                                onclick="Rates(5, {{@$PickId }})"></label>

                                                        <input type="radio" id="star4" name="rating"
                                                               value="4"
                                                               class="rating"/><label
                                                                class="full" for="star4"
                                                                title="Pretty good - 4 stars"
                                                                onclick="Rates(4, {{@$PickId }})"></label>

                                                        <input type="radio" id="star3" name="rating"
                                                               value="3"
                                                               class="rating"/><label
                                                                class="full" for="star3"
                                                                title="Meh - 3 stars"
                                                                onclick="Rates(3, {{@$PickId }})"></label>

                                                        <input type="radio" id="star2" name="rating"
                                                               value="2"
                                                               class="rating"/><label
                                                                class="full" for="star2"
                                                                title="Kinda bad - 2 stars"
                                                                onclick="Rates(2, {{@$PickId }})"></label>

                                                        <input type="radio" id="star1" name="rating"
                                                               value="1"
                                                               class="rating"/><label
                                                                class="full" for="star1"
                                                                title="Bad  - 1 star"
                                                                onclick="Rates(1,{{@$PickId }})"></label>

                                                    </a>
                                                </div>
                                            @else
                                                <div class="rating_cart">
                                                    <div class="rateing">
                                                        <span> {{$course->totalReview}}/5</span>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>


            <div class="recommended_courses">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3 margin_50">
                            <h3>{{__('student.Recommended For You')}}</h3>
                            <p>{{__('student.Are you ready for your next lesson')}}?</p>
                        </div>
                    </div>

                    @if(isset($courses))
                        @foreach($courses as $course)
                            <div class="col-lg-6 col-xl-4">
                                <div class="couse_wizged" style=" box-shadow: 0 10px 15px 0 rgb(0 0 0 / 5%);">
                                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                                        <div class="thumb">

                                            <div class="thumb_inner lazy"
                                                 data-src="{{ file_exists($course->thumbnail) ? asset($course->thumbnail) : asset('public/\uploads/course_sample.png') }}">
                                            </div>
                                        </div>
                                    </a>
                                    <div class="course_content" style="padding: 20px;">
                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                                            <h4 class="noBrake" title=" {{$course->title}}">
                                                {{$course->title}}
                                            </h4>
                                        </a>
                                        <div class="rating_star mb-2" style="display: flex;">

                                            <div class="stars mr-3">
                                                @php
                                                    $userRating = userRating($course->user_id);
                                                    $main_stars= $userRating['rating'] ;

                                                    $stars=intval($userRating['rating']);
                                                @endphp
                                                @for ($i = 0; $i <  $stars; $i++)
                                                    <i class="fas fa-star" style="color: #ffc107;"></i>
                                                @endfor
                                                @if ($main_stars>$stars)
                                                    <i class="fas fa-star-half" style="color: #ffc107;"></i>
                                                @endif
                                                @if($main_stars==0)
                                                    @for ($i = 0; $i <  5; $i++)
                                                        <i class="far fa-star" style="color: #ffc107;"></i>
                                                    @endfor
                                                @endif
                                            </div>
                                            <p>{{@$userRating['rating']}}
                                                ({{@$userRating['total']}} {{__('frontend.Rating')}})</p>
                                        </div>
                                        <div class="course_less_students mt-3 mb-3">
                                            <a> <i class="ti-agenda"></i> {{count($course->lessons)}}
                                                {{__('frontend.Lessons')}}</a>
                                            <a>
                                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                                            </a>
                                        </div>
                                        <div class="course_less_students mb-1" style="display: flex; height: 26px; ">
                                            @if(!empty($course->discount_price))
                                                <p style="font-weight: 500; font-family: 'Hind Siliguri', sans-serif; color: #f57224;">{{( ceil($course->price-$course->discount_price)/$course->price*100) }}% off</p>
                                                <p style="text-decoration: line-through; color: #9e9e9e; padding-left: 7px">
                                                    {{$course->price}} TK</p>
                                            @else
                                            @endif
                                        </div>

                                        <a href="" class=" d-flex justify-content-center theme_btn btn-block cart_store" style="border-radius: 0; padding: 15px 0; letter-spacing: 1px;"  data-id="{{$course->id}}">
                                            <i class="fas fa-shopping-cart mr-2"></i>{{empty($course->discount_price)?$course->price:$course->discount_price}} TK
                                        </a>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>


    </div>
    <div class="modal cs_modal fade admin-query" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('frontend.Review') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><i
                                class="ti-close "></i></button>
                </div>

                <form action="{{route('submitReview')}}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="course_id" id="rating_course_id"
                               value="">
                        <input type="hidden" name="rating" id="rating_value" value="">

                        <div class="text-center">
                                                                <textarea class="lms_summernote" name="review"
                                                                          id=""
                                                                          placeholder="{{__('frontend.Write your review') }}"
                                                                          cols="30"
                                                                          rows="10">{{old('review')}}</textarea>
                            <span class="text-danger" role="alert">{{$errors->first('review')}}</span>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="theme_line_btn mr-2"
                                    data-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <button class="theme_btn "
                                    type="submit">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
