<div>
    <div class="service_cta_area" style="background-image: url('{{asset('/').'public/frontend/instructor.png'}}');padding: 70px 0 70px; position: relative; background-repeat: no-repeat; background-size: cover; background-position: center center; ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row">
                        <div class="  col-lg-6 m-auto">
                            <div class="single_cta_service ">
                                <div class="thumb">
                                    <img src="{{asset(@$homeContent->become_instructor_logo)}}" alt="">
                                </div>
                                <div class="cta_service_info">
                                    <h4 style="font-family: 'Hind Siliguri', sans-serif;">  {{@$homeContent->become_instructor_title}}</h4>
                                    <p style="font-family: 'Hind Siliguri', sans-serif;">  {{@$homeContent->become_instructor_sub_title}}</p>
                                    <a href="{{route('becomeInstructor')}}" class="theme_btn small_btn">{{__('frontend.Start Teaching')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
