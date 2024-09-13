<div>
    <div class="course_area section_spacing" style="padding: 70px 0 70px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_30">
                        <h3 style="font-size: 40px; font-family: 'Hind Siliguri', sans-serif">
                            {{@$homeContent->course_title}}


                        </h3>
                        <p style="font-family: 'Hind Siliguri', sans-serif">
                            {{@$homeContent->course_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(isset($top_courses))
                    @foreach($top_courses as $course)
                        <div class="col-lg-4 col-xl-3 col-md-6 mt-5">
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

                                    @if($course->upcoming==1)
                                    <button type="button" class=" d-flex justify-content-center theme_btn btn-block " style="border-radius: 0; padding: 15px 0; letter-spacing: 1px;" >
                                        Upcoming
                                    </button>
                                    @else
                                        <a href="" class="d-flex justify-content-center theme_btn btn-block cart_store" style="border-radius: 0; padding: 15px 0; letter-spacing: 1px;"  data-id="{{$course->id}}">
                                            <i class="fas fa-shopping-cart mr-2"></i>{{empty($course->discount_price)?$course->price:$course->discount_price}} TK
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-12 text-center pt_70">
                    <a href="{{route('courses')}}"
                       class="theme_btn">{{__('frontend.View All Courses')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
