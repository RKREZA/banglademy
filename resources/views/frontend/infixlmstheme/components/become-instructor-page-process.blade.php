<div>
    <section class="work_process bg-white" style="padding-top: 50px; padding-bottom: 70px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="section__title  text-center mb_50">
                        <h3>
                            {{$work->section}}
                        </h3>
                        <p>
                            {{$work->title}}

                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col-md-5 col-xl-4">
                    <div class="work_process_content">
                        @if(isset($processes))
                            @foreach($processes as $key=>$p)
                                <div class="single_work_process">
                                    <div class="list_number">
                                        0{{++$key}}
                                    </div>
                                    <h4>{{$p->title}}</h4>
                                    <p>
                                        {{$p->description}}
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-7 col-xl-7">
                    <div class="work_process_video">
                        <div class="video_img">
                            <img src="{{asset($work->image)}}" alt="#"
                                 class="img-fluid">
                            <a href="{{youtubeVideo($work->video)}}" class="popup_video popup-video"><i
                                    class="fas fa-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
