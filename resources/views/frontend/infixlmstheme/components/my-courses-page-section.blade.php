<div>
    <div class="main_content_iner main_content_padding">
        <div class="container">
            <div class="my_courses_wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title3 margin-50">
                            <h3>
                                @if( routeIs('myClasses'))
                                    {{__('courses.Live Class')}}
                                @elseif( routeIs('myQuizzes'))
                                    {{__('courses.My Quizzes')}}
                                @else
                                    {{__('courses.My Courses')}}
                                @endif
                            </h3>
                        </div>
                    </div>

                    @php
                        if (routeIs('myClasses')){
                            $search_text = trans('frontend.Search My Classes');
                            $search_route ='';
                        }elseif (routeIs('myQuizzes')){
                            $search_text = trans('frontend.Search My Quizzes');
                            $search_route ='';
                        }else{
                            $search_text = trans('frontend.Search My Courses');
                            $search_route ='';
                        }
                    @endphp
                    <div class="col-xl-6 col-md-6">
                        <div class="short_select d-flex align-items-center pt-0 pb-3">
                            <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Filter By')}}:</h5>
                            <input type="hidden" id="siteUrl" value="{{route(\Request::route()->getName())}}">
                            <select class="theme_select my-course-select w-50" id="categoryFilter">
                                <option value=""
                                        data-display="{{__('frontend.All Categories')}}">{{__('frontend.All Categories')}}</option>
                                @foreach($categories  as $category)
                                    <option
                                        value="{{$category->id}}" {{@$category_id==$category->id?'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class=" col-xl-6 col-md-6">
                        <form action="{{route(\Request::route()->getName())}}">
                            <div class="input-group theme_search_field pt-0 pb-3 float-right w-50">
                                <div class="input-group-prepend">
                                    <button class="btn" type="button" id="button-addon1"><i
                                            class="ti-search"></i>
                                    </button>
                                </div>

                                <input type="text" class="form-control" name="search"
                                       placeholder="{{$search_text}}" value="{{$search}}"
                                       onfocus="this.placeholder = ''"
                                       onblur="this.placeholder = '{{$search_text}}'">

                            </div>
                        </form>
                    </div>
                    @if(isset($courses))
                        @foreach ($courses as $SingleCourse)
                            @php
                                $course=$SingleCourse->course;
                            @endphp
                            <div class="col-xl-4 col-md-6">
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
                                            <div class="course_less_students mb-1" style="display: flex; height: 26px; ">
                                                @if(!empty($course->discount_price))
                                                    <p style="font-weight: 500; font-family: 'Hind Siliguri', sans-serif; color: #f57224;">{{( ceil($course->price-$course->discount_price)/$course->price*100) }}% off</p>
                                                    <p style="text-decoration: line-through; color: #9e9e9e; padding-left: 7px">
                                                        {{$course->price}} TK</p>
                                                @else
                                                @endif
                                            </div>

                                            <a href=" {{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}" class=" d-flex justify-content-center theme_btn btn-block" style="border-radius: 0; padding: 15px 0; letter-spacing: 1px;"  >
                                                Continue Course
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
                                @endif
                            </div>
                        @endforeach
                    @endif
                    @if(count($courses)==0)
                        <div class="col-12">
                            <div class="section__title3 margin_50">
                                @if( routeIs('myClasses'))
                                    <p class="text-center">{{__('student.No Class Purchased Yet')}}!</p>
                                @elseif( routeIs('myQuizzes'))
                                    <p class="text-center">{{__('student.No Quiz Purchased Yet')}}!</p>
                                @else
                                    <p class="text-center">{{__('student.No Course Purchased Yet')}}!</p>
                                @endif

                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
