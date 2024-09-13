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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('attendance.Instructor Attendance') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box_50px box_shadow_white">
                        <form action="{{route('instructor_attendance.create')}}" method="get">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="date">{{ __('common.Date') }} *</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="date" type="text" name="date"
                                                               value="{{date('m/d/Y',strtotime($date))}}" autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <button type="submit" class="primary-btn btn-sm mt-30 fix-gr-bg"><i class="ti-search"></i>{{ __('attendance.Search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (count($users) > 0)
            @if (permissionCheck('attendance.index'))
                <form class="" action="{{ route('instructor_attendance.store') }}" method="post">
                @csrf
                <input type="hidden" name="date" value="{{$date}}">
                <div class="col-lg-12 mb-2 mt-3">
                    <div class="d-flex">
                        <button type="submit" class="primary-btn btn-sm fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}</button>
                    </div>
                </div>
            @endif
            <div class="common_QA_section QA_section_heading_custom th_padding_l0">
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <div class="">
                        <table class="table Crm_table_active2 pt-0 shadow_none pt-0 pb-0">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('common.ID') }}</th>
                                <th scope="col">{{ __('common.Name') }}</th>
                                <th scope="col">{{ __('attendance.Attendance') }}</th>
                                <th scope="col">{{ __('attendance.Late Hours') }}</th>
                                <th scope="col">{{ __('attendance.Note') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <input type="hidden" name="user[]" value="{{ $user->id }}">
                                        <div class="d-flex radio-btn-flex">
                                            <div class="mr-20">
                                                <input data-id="{{$user->id}}" type="radio" name="attendance[{{$user->id}}]" id="attendanceP{{$user->id}}" value="P" @if (attendanceCheck($user->id, 'P',$date)) checked @endif class="common-radio attendanceP attendance attendance_{{$user->id}}">
                                                <label for="attendanceP{{$user->id}}">{{__('common.Present')}}</label>
                                            </div>
                                            <div class="mr-20">
                                                <input data-id="{{$user->id}}" type="radio" name="attendance[{{$user->id}}]" id="attendanceL{{$user->id}}" value="L" @if (attendanceCheck($user->id, 'L',$date)) checked @endif class="common-radio attendance attendance_{{$user->id}}">
                                                <label for="attendanceL{{$user->id}}">{{__('common.Late')}}</label>
                                            </div>
                                            <div class="mr-20">
                                                <input data-id="{{$user->id}}" type="radio" name="attendance[{{$user->id}}]" id="attendanceA{{$user->id}}" value="A" @if (attendanceCheck($user->id, 'A',$date)) checked @endif class="common-radio attendance attendance_{{$user->id}}">
                                                <label for="attendanceA{{$user->id}}">{{__('common.Absent')}}</label>
                                            </div>
                                            <div>
                                                <input data-id="{{$user->id}}" type="radio" name="attendance[{{$user->id}}]" id="attendanceH{{$user->id}}" value="H" @if (attendanceCheck($user->id, 'H',$date)) checked @endif class="common-radio attendance attendance_{{$user->id}}">
                                                <label for="attendanceH{{$user->id}}">{{__('common.Holiday')}}</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="primary_input mb-25">
                                            <input @if (!attendanceCheck($user->id, 'L',$date)) readonly  @endif  value="{{LateNote($user->id,$date)}}" name="late_note_{{ $user->id }}" class="primary_input_field late_note late_note_{{ $user->id }}"  placeholder="Late Hours" type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="primary_input mb-25">
                                            <input name="note_{{ $user->id }}" class="primary_input_field name" @if (attendanceNoteDateWise($user->id,$date)) value="{{ NoteDateWise($user->id,$date) }}" @else value="" @endif placeholder="Note" type="text">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    @else
        <h4 class="my-3">{{__('attendance.No instructor found!')}}</h4>
    @endif

@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function(){
                $(document).on('change', '.attendance', function(event){
                    let id = $(this).data('id');
                    if($('.attendance_'+id+':checked').val() === 'L')
                    {
                        $('.late_note_'+id).attr('readonly', false);

                    } else {
                        $('.late_note_'+id).attr('readonly', true);
                    }
                });
            });
        })(jQuery);

    </script>
@endpush

