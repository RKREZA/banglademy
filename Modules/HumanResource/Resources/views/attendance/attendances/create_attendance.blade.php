@if ($today_class_info != null)
    @if (permissionCheck('attendances.index'))
        <form class="" action="{{ route('attendances.store') }}" method="post">
            @csrf
            <input type="hidden" name="date" value="{{$date}}">
            <input type="hidden" name="course_id" value="{{ $course_id }}">
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
                                <th scope="col">{{ __('attendance.Note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <input type="hidden" name="user[]" value="{{ $user->id }}">
                                        <input type="hidden" name="meeting_duration" value="{{$today_class_info->meeting_duration}}">
                                        <input type="hidden" name="start_time" value="{{$today_class_info->start_time}}">
                                        <input type="hidden" name="end_time" value="{{$today_class_info->end_time}}">
                                        <div class="d-flex radio-btn-flex">
                                            <div class="mr-20">
                                                <input type="radio" name="attendance[{{$user->id}}]" id="attendanceP{{$user->id}}" value="P" @if (attendanceCheck($user->id, 'P',$date)) checked @endif class="common-radio attendanceP">
                                                <label for="attendanceP{{$user->id}}">{{__('common.Present')}}</label>
                                            </div>
                                            <div class="mr-20">
                                                <input type="radio" name="attendance[{{$user->id}}]" id="attendanceL{{$user->id}}" value="L" @if (attendanceCheck($user->id, 'L',$date)) checked @endif class="common-radio">
                                                <label for="attendanceL{{$user->id}}">{{__('common.Late')}}</label>
                                            </div>
                                            <div class="mr-20">
                                                <input type="radio" name="attendance[{{$user->id}}]" id="attendanceA{{$user->id}}" value="A" @if (attendanceCheck($user->id, 'A',$date)) checked @endif class="common-radio">
                                                <label for="attendanceA{{$user->id}}">{{__('common.Absent')}}</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="attendance[{{$user->id}}]" id="attendanceH{{$user->id}}" value="F" @if (attendanceCheck($user->id, 'H',$date)) checked @endif class="common-radio">
                                                <label for="attendanceH{{$user->id}}">{{__('common.Holiday')}}</label>
                                            </div>
                                        </div>
                                        @php
                                            $start_time=date_create($today_class_info->start_time);
                                            $start_time= date_format($start_time,'h:i:s A');

                                            $end_time=date_create($today_class_info->end_time);
                                            $end_time= date_format($end_time,'h:i:s A');
                                        @endphp
                                        <div class="col-lg-12 d-flex">
                                              <div class="col-xl-6">
                                                    <div class="input-effect">
                                                        <label>Entering Time <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" type="text" name="entering_time[{{$user->id}}]" autocomplete="off" value="{{attendanceInfo($user->id,$date)? attendanceInfo($user->id,$date)->entering_time :$start_time }}">
                                                    </div>
                                             </div>
                                              <div class="col-xl-6">
                                                    <div class="input-effect">
                                                        <label>Leaving Time <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" type="text" name="leaving_time[{{$user->id}}]" autocomplete="off" value="{{ attendanceInfo($user->id,$date)? attendanceInfo($user->id,$date)->leaving_time :$end_time }}">
                                                    </div>
                                             </div>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="primary_input mb-25">
                                            <input name="note_{{ $user->id }}" class="primary_input_field name" @if (attendanceNote($user->id)) value="{{ Note($user->id) }}" @else value="" @endif placeholder="Note" type="text">
                                        </div>
                                    </td>
                                </tr>
                            @empty
                               <tr>
                                   <td>
                                       <h4 class="my-3">Student Not Found</h4>
                                   </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
@else
    <h4 class="my-3">Class Not Found</h4>
@endif
