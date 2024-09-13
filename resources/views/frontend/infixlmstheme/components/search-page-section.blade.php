<div>
    <div class="courses_area" style="padding: 70px 0 70px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xl-3">
                    <x-class-page-section-sidebar :level="$level" :type="$type" :categories="$categories"
                                                  :category="$category" :languages="$languages" :language="$language" :mode="$mode"/>
                </div>
                <div class="col-lg-8 col-xl-9">

                    <div class="row">
                        <div class="col-12">
                            <div class="box_header d-flex flex-wrap align-items-center justify-content-between">

                                <h5 class="font_16 f_w_500 ">
                                    @if(isset($search) && !empty($search))

                                        {{__('courses.Search result for')}} "{{$search}}
                                        "<br style="line-break: auto">
                                        @if($courses->count()==0)

                                        @else
                                            <span
                                                    class="subtitle">{{$total}} {{__('coupons.Topics are available')}}</span>
                                        @endif
                                    @endif
                                </h5>

                                <div class="box_header_right mb_30">
                                    <div class="short_select d-flex align-items-center">
                                        <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Order By')}}:</h5>
                                        <select class="small_select" id="order">
                                            <option data-display="None">{{__('frontend.None')}}</option>
                                            <option
                                                    value="price" {{$order=="price"?'selected':''}}>{{__('frontend.Price')}}</option>
                                            <option
                                                    value="date" {{$order=="date"?'selected':''}}>{{__('frontend.Date')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($courses))
                            @foreach ($courses as $course)
                                <div class="col-lg-6 col-xl-4">
                                    @if($course->type==1)
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
                                                <div class="course_less_students mb-1" style="display: flex;">
                                                    @if(!empty($course->discount_price))
                                                        <p style="font-weight: 500; font-family: 'Hind Siliguri', sans-serif; color: #f57224;">{{( ceil($course->price-$course->discount_price)/$course->price*100) }}% off</p>
                                                        <p style="text-decoration: line-through; color: #9e9e9e; padding-left: 7px">
                                                            {{$course->price}} TK</p>
                                                    @else
                                                    @endif
                                                </div>

                                                <a href="" class=" d-flex justify-content-center theme_btn btn-block cart_store" style="border-radius: 0; padding: 15px 0; letter-spacing: 1px;"  data-id="{{$course->id}}">
                                                    <i class="fas fa-shopping-cart mr-2"></i>{{$course->discount_price}} TK
                                                </a>

                                            </div>
                                        </div>
                                    @elseif($course->type==2)
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
                                                <div class="course_less_students mb-1" style="display: flex;">
                                                    @if(!empty($course->discount_price))
                                                        <p style="font-weight: 500; font-family: 'Hind Siliguri', sans-serif; color: #f57224;">{{( ceil($course->price-$course->discount_price)/$course->price*100) }}% off</p>
                                                        <p style="text-decoration: line-through; color: #9e9e9e; padding-left: 7px">
                                                            {{$course->price}} TK</p>
                                                    @else
                                                    @endif
                                                </div>

                                                <a href="" class=" d-flex justify-content-center theme_btn btn-block cart_store" style="border-radius: 0; padding: 15px 0; letter-spacing: 1px;"  data-id="{{$course->id}}">
                                                    <i class="fas fa-shopping-cart mr-2"></i>{{$course->discount_price}} TK
                                                </a>

                                            </div>
                                        </div>
                                    @elseif($course->type==3)
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

                                                <div class="course_less_students mb-1" style="display: flex;">
                                                    @if(!empty($course->discount_price))
                                                        <p style="font-weight: 500; font-family: 'Hind Siliguri', sans-serif; color: #f57224;">{{( ceil($course->price-$course->discount_price)/$course->price*100) }}% off</p>
                                                        <p style="text-decoration: line-through; color: #9e9e9e; padding-left: 7px">
                                                            {{$course->price}} TK</p>
                                                    @else
                                                    @endif
                                                </div>


                                                <a href="" class=" d-flex justify-content-center theme_btn btn-block cart_store" style="border-radius: 0; padding: 15px 0; letter-spacing: 1px;"  data-id="{{$course->id}}">
                                                    <i class="fas fa-shopping-cart mr-2"></i>{{$course->discount_price}} TK
                                                </a>

                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                        @if(count($courses)==0)

                            <div class="col-lg-12">
                                <div
                                        class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                                    <h1>
                                        <div class="thumb">
                                            <img style="width: 50px"
                                                 src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                                 alt="">
                                            @if(!isset($search))
                                                {{__('frontend.No Course Found')}}
                                            @else
                                                {{__('frontend.No results found for')}} {{$search}}
                                            @endif
                                        </div>

                                    </h1>
                                </div>
                            </div>

                        @endif
                    </div>

                    {{ $courses->appends(Request::all())->links() }}
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" class="class_route" name="class_route" value="{{url()->current()}}">

    <input type="hidden" class="search" value="{{isset($search)?$search:''}}">
</div>
