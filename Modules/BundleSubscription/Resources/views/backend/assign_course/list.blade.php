@if(count($assigns)>0)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div id="accordion">

                        @foreach($assigns as $key => $assign)

                            <div class="card accordion_card"
                                 id="accordion_{{$assign->id}}">
                                <div class="card-header item_header"
                                     id="heading_{{$assign->id}}">
                                    <div class="dd-handle">
                                        <div class="float-left">
                                            {{$assign->course->title}}

                                            @php
                                                if ($assign->course->type==1){
                                                   echo '(Course)';
                                               }elseif($assign->course->type==2){
echo '(Quiz)';
                                               }else{
echo '(Class)';
                                               }
                                            @endphp


                                        </div>
                                        <div class="float-right ">
                                            <a href="javascript:void(0);"
                                               data-id="{{$assign->id}}"
                                               class="primary-btn small fix-gr-bg text-center mt-2 button deleteBtn">
                                                <i class="ti-close"></i>
                                            </a>
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
@else
    <div class="card">
        <div class="card-body text-center">
            @lang('frontendmanage.Not Found Data')
        </div>
    </div>
@endif
