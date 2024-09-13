<div>
    <div class="blog_area" style="padding: 70px 0 70px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="section__title text-center mb_80">
                        <h3 style="font-size: 40px; font-family: 'Hind Siliguri', sans-serif;">
                            {{@$homeContent->article_title}}
                        </h3>
                        <p style="font-family: 'Hind Siliguri', sans-serif;">
                            {{@$homeContent->article_sub_title}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(isset($blogs))
                    @foreach($blogs as $blog)
                        <div class="col-lg-6 col-xl-3 col-md-6">

                            <div class="news-card">
                                <img class="news-card-tn" src="{{ file_exists($blog->thumbnail) ? asset($blog->thumbnail) : asset('public/\uploads/course_sample.png') }}" >
                                <a href="{{route('blogDetails',[$blog->slug])}}">
                                    <h3 style=" font-family: 'Hind Siliguri', sans-serif;">{{$blog->title}}</h3>
                                </a>
                                <a href="{{route('blogDetails',[$blog->slug])}}">Read more <i class="fas fa-arrow-right"></i></a>
                            </div>

                        </div>
                    @endforeach
                @endif
                <div class="row col-md-12">
                    <div class="col-12 text-center pt-5">
                        <a href="{{route('blogs')}}"
                           class="theme_btn">{{__('frontend.View All Articles & News')}}</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
