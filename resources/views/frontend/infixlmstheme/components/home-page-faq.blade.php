<div>
    <div class="blog_area" style="padding: 70px 0 70px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section__title text-center mb_80">
                        <h3 style="font-size: 40px; font-family: 'Hind Siliguri', sans-serif;">
                            {{@$homeContent->home_page_faq_title}}
                        </h3>
                        <p style="font-family: 'Hind Siliguri', sans-serif;">
                            {{@$homeContent->home_page_faq_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="container" style="max-width: 1140px;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="theme_according mb_100" id="accordion1">
                            @foreach($faqs->take(5) as $key=>$faq)
                                <div class="card">
                                    <div class="card-header pink_bg" id="headingFour{{$key}}">
                                        <h5 class="mb-0">
                                            <button  style="font-family: 'Hind Siliguri';" class="btn btn-link text_white collapsed"
                                                    data-toggle="collapse"
                                                    data-target="#collapseFour{{$key}}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseFour{{$key}}">
                                                {{$faq->question}}
                                            </button>
                                        </h5>
                                    </div>
                                    <div class="collapse" id="collapseFour{{$key}}"
                                         aria-labelledby="headingFour{{$key}}"
                                         data-parent="#accordion1">
                                        <div class="card-body">
                                            <div class="curriculam_list">

                                                <div class="curriculam_single">
                                                    <div class="curriculam_left">

                                                        <span>{!! $faq->answer !!}</span>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="theme_according mb_100" id="accordion1">
                            @foreach($faqs->skip(5) as $key=>$faq)
                                <div class="card">
                                    <div class="card-header pink_bg" id="headingFour{{$key}}">
                                        <h5 class="mb-0" style="font-family: 'Hind Siliguri', sans-serif;">
                                            <button style="font-family: 'Hind Siliguri';" class="btn btn-link text_white collapsed"
                                                    data-toggle="collapse"
                                                    data-target="#collapseFour{{$key}}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseFour{{$key}}">
                                                {{$faq->question}}
                                            </button>
                                        </h5>
                                    </div>
                                    <div class="collapse" id="collapseFour{{$key}}"
                                         aria-labelledby="headingFour{{$key}}"
                                         data-parent="#accordion1">
                                        <div class="card-body">
                                            <div class="curriculam_list">

                                                <div class="curriculam_single">
                                                    <div class="curriculam_left">

                                                        <span>{!! $faq->answer !!}</span>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>


                </div>
            </div>


        </div>
    </div>
</div>
