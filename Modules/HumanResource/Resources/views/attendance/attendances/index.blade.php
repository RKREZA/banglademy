@extends('backend.master')
@section('mainContent')
    @include("backend.partials.alertMessage")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('attendance.Attendance') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('attendance.Select Course') }}</label>
                                    <select class="primary_select mb-15 role_type" name="course_id" id="course_id" >
                                        <option selected disabled>{{__('attendance.Choose One')}}</option>
                                        @if(\Illuminate\Support\Facades\Auth::user()->role_id ==5)
                                            @foreach (\Modules\CourseSetting\Entities\Course::where('type', 3)->where('user_id', \Illuminate\Support\Facades\Auth::id())->get() as $course)
                                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endforeach
                                        @else
                                            @foreach (\Modules\CourseSetting\Entities\Course::where('type', 3)->get() as $course)
                                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <span class="text-danger">{{$errors->first('course_id')}}</span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('sale.Date') }} *</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date"
                                                           class="primary_input_field primary-input date form-control"
                                                           id="startDate" type="text" name="date"
                                                           value="{{date('m/d/Y')}}" autocomplete="off">
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <button type="button" class="primary-btn btn-sm fix-gr-bg" id="get_attendance"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="create_form">

    </div>
@include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        $('#get_attendance').on('click', function(){
            get_user();
        });
        function get_user()
        {
            $(".create_form").html('');
            var course_id = $('#course_id').val();
            var date = $('#startDate').val();
            if (course_id && date)
            {
                $.post('{{ route('get_user_by_role') }}',{_token:'{{ csrf_token() }}', course_id:course_id,date:date}, function(data){
                    $(".create_form").html(data);
                    $('select').niceSelect();
                });
            }
        }
    </script>

    <script>

        $('.datetimepicker').datetimepicker({
            // format: 'LT',
        });


    </script>
@endpush
