@if (permissionCheck('leave_types.index'))
    @php

        $leave = false;

        if(request()->is('leave') || request()->is('leave/*'))
        {
            $leave = true;
        }

    @endphp

    <li class="{{ $leave ?'mm-active' : '' }}">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="fas fa-print"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('leave.Leave') }}</span>
            </div>
        </a>
        <ul>
            @if(permissionCheck('leave_types.index'))
                <li>
                    <a href="{{ route('leave_types.index') }}"
                       class="{{request()->is('leave/types') ? 'active' : ''}}">{{ __('leave.Leave Type') }}</a>
                </li>
            @endif
            @if(permissionCheck('leave_types.index'))
                <li>
                    <a href="{{ route('leave_define.index') }}"
                       class="{{request()->is('leave/define-lists') ? 'active' : ''}}">{{ __('leave.Leave Define') }}</a>
                </li>
            @endif
            @if(permissionCheck('apply_leave.index'))
                <li>
                    <a href="{{ route('apply_leave.index') }}"
                       class="{{request()->is('leave/apply') ? 'active' : ''}}">{{ __('leave.Apply Leave') }}</a>
                </li>
            @endif
            @if(permissionCheck('approved_index'))
                <li>
                    <a href="{{ route('approved_index') }}"
                       class="{{request()->is('leave/approved') ? 'active' : ''}}">{{ __('leave.Approve Leave Request') }}</a>
                </li>
            @endif



            @if(permissionCheck('pending_index'))
                <li>
                    <a href="{{ route('pending_index') }}"
                       class="{{request()->is('leave/pending') ? 'active' : ''}}">{{ __('leave.Pending Leave') }}</a>
                </li>
            @endif

            @if(permissionCheck('holidays.index'))
                <li>
                    <a href="{{ route('holidays.index') }}"
                       class="{{request()->is('leave/holidays') || request()->is('leave/holidays/*')  ? 'active' : ''}}">{{ __('leave.Holyday Setup') }}</a>
                </li>
            @endif

            @if(permissionCheck('carry.forward'))
                <li>
                    <a href="{{ route('carry.forward') }}"
                       class="{{request()->is('leave/carry-forward') ? 'active' : ''}}">{{ __('leave.Carry Forward') }}</a>
                </li>
            @endif
        </ul>
    </li>
@endif


@if (permissionCheck('human_resource'))
    @php

        $hr = false;
        $attendance = false;
        $events = false;
        $location = false;
        $occupational_groups= false;

        if(request()->is('occupational_groups/*'))
        {
            $occupational_groups = true;
        }

        if(request()->is('hr/*'))
        {
            $hr = true;
        }
        if(request()->is('attendance/*'))
        {
            $attendance = true;
        }
        if(request()->is('events') || request()->is('events/*'))
        {
            $events = true;
        }
        if(request()->is('location/*'))
        {
            $location = true;
        }

    @endphp


    <li class="{{$occupational_groups || $hr || $attendance|| $events ?'mm-active' : '' }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="true">
            <div class="nav_icon_small">
                <span class="fas fa-users"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('common.Human Resource') }}</span>
            </div>
        </a>
        <ul>
            @if (permissionCheck('staffs.index'))
                <li>
                    <a href="{{ route('staffs.index') }}" class="{{request()->is('hr/staffs') || request()->is('hr/staffs/*') ? 'active' : ''}}">{{ __('common.Staff') }}</a>
                </li>
            @endif

            @if (permissionCheck('hr.department.index'))
                <li>
                    <a href="{{ route('hr.department.index') }}" class="{{request()->is('hr/department') || request()->is('hr/department/*') ? 'active' : ''}}">{{ __('leave.Department') }}</a>
                </li>
            @endif
            @if (permissionCheck('permission.roles.index'))
                <li>
                    <a href="{{ route('permission.roles.index') }}" class="{{request()->is('hr/role-permission/*') ? 'active' : '/*'}}">{{ __('role.Role') }}</a>
                </li>
            @endif
            @if (permissionCheck('instructor_attendance.create'))
                <li>
                    <a href="{{ route('instructor_attendance.create') }}" class="{{request()->routeIs('instructor_attendance.create') ? 'active' : ''}}">{{ __('attendance.Instructor Attendance') }}</a>
                </li>
            @endif
            @if (permissionCheck('attendances.index'))
                <li>
                    <a href="{{ route('attendances.index') }}" class="{{request()->is('attendance/hr/attendance') ? 'active' : ''}}">{{ __('attendance.Attendance') }}</a>
                </li>
            @endif
            @if (permissionCheck('attendance_report.index'))
                <li>
                    <a href="{{ route('attendance_report.index') }}" class="{{ request()->is('attendance/hr/attendance/*') ? 'active' : ''}}">{{ __('attendance.Attendance Report') }}</a>
                </li>
            @endif

            @if (permissionCheck('staffs.index'))
                <li>
                    <a href="{{ route('staffs.settings') }}" class="{{ request()->is('hr/settings/*') ? 'active' : ''}}">{{ __('common.Settings') }}</a>
                </li>
            @endif

            @if(isModuleActive('Account'))
                @if(permissionCheck('payroll'))
                    <li>
                        <a href="{{route('payroll')}}"> Payroll</a>
                    </li>
                @endif
                @if(permissionCheck('payroll') )
                    <li>
                        <a href="{{route('payroll-report')}}"> Payroll Report</a>
                    </li>
                @endif
            @endif
        </ul>
    </li>
@endif
