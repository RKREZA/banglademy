@extends('backend.master')


@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('bundleSubscription.instructor Course Position')}} </h1>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">

                            <div class="">
                                <table id="" class="table ">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">{{__('subscription.Title')}}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($block as $key => $plan)
                                        <tr data-item="{{$plan->id}}">
                                            <td>
                                                <i class="ti-menu"></i>
                                            </td>

                                            <td>{{@$plan->title}}</td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
@push('scripts')
    @include('bundlesubscription::script')
@endpush

