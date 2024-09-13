<div>
    <div class="testmonial_area testmonial-area" style="background-image: url('{{asset('/').'public/frontend/testmonial_area.jpg'}}'); padding: 70px 0 70px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section__title text-center mb_80">
                        <h3 style="font-size: 40px;font-family: 'Hind Siliguri', sans-serif;">{{@$homeContent->testimonial_title}}</h3>
                        <p style="font-family: 'Hind Siliguri', sans-serif;">
                            {{@$homeContent->testimonial_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="testmonail_active owl-carousel">
                        @if(@$testimonials != "")
                            @foreach ($testimonials as $testimonial)
                                <div class="single_testmonial">
                                    <div class="testmonial_header d-flex align-items-center">
                                        <div class="thumb profile_info ">
                                            <div class="profile_img">
                                                <div class="testimonialImage"
                                                     style="background-image: url('{{getTestimonialImage($testimonial->image)}}')"></div>
                                            </div>

                                        </div>
                                        <div class="reviewer_name">
                                            <h4 style="font-family: 'Hind Siliguri'">{{@$testimonial->author}}</h4>
                                            <h6 style="font-family: 'Hind Siliguri'">{{@$testimonial->profession}}</h6>
                                            <div class="rate d-flex align-items-center">

                                                @for($i=1;$i<=$testimonial->star;$i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                    <p style="font-family: 'Hind Siliguri'" > “{{@$testimonial->body}}”</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
