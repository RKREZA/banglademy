<div>
    <div class="blog_page_wrapper">
        <div class="container">
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
            </div>
            {{ $blogs->appends(Request::all())->links() }}
        </div>
    </div>
</div>
