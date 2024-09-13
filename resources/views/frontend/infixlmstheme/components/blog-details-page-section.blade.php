<div>
    <div class="blog_details_area" style="padding-top: 70px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 ">
                    <!-- single_blog_details  -->
                    <div class="single_blog_details">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="blog_title">
                                    <h3 class="mb-0" style="font-family: 'Hind Siliguri', sans-serif">{{$blog->title}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="blog_details_banner">
                            <img class="w-100" src="{{getBlogImage($blog->image)}}" alt="">
                        </div>
                        <div class="row">
                            <div class="col-xl-9 offset-lg-1">
                                <p class="mb_25">

                                    {!! $blog->description !!}
                                </p>
                                <br>

                                <x-blog-details-share-section :blog="$blog"/>

                                <h4 style="padding: 20px 0 5px;">You may also like:</h4>
                                @if(isset($relatedBlogs))
                                    @foreach ($relatedBlogs as $relatedBlog)
                                        <p style="margin-top: 5px;">
                                            <span>- </span>
                                            <a class="relatedBlog" style=" font-weight: bold; font-family: 'Hind Siliguri'; font-size: 18px;" href="{{route('blogDetails',[$relatedBlog->slug])}}" >{{$relatedBlog->title}}</a>
                                        </p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
