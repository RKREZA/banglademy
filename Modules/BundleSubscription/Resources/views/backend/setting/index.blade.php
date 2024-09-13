@extends('setting::layouts.master')

@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('subscription.Settings')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}} </a>

                    <a href="#">{{__('subscription.Settings')}}</a>
                </div>
            </div>
        </div>
    </section>
    @include("backend.partials.alertMessage")

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="">
                        <div class="row">

                            <div class="col-lg-12">

                                <div class="tab-content " id="myTabContent">

                                    <div class="tab-pane fade white_box_30px show active" id="Activation"
                                         role="tabpanel" aria-labelledby="Activation-tab">
                                        <div class="main-title mb-25">


                                            <form action="{{route('bundle.setting.store')}}"
                                                  method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf

                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('subscription.Admin Commission Rate') }}
                                                                (%)</label>
                                                            <input class="primary_input_field"
                                                                   placeholder="Please enter admin commission"
                                                                   type="number"
                                                                   name="" min="0" max="100"
                                                                   oninput="planCalCommission()"
                                                                   id="admin_comm"
                                                                   value="{{100-$setting->commission_rate}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-3">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('subscription.Instructor Commission Rate') }}
                                                                (%)</label>
                                                            <input class="primary_input_field" placeholder="0"
                                                                   type="number" id="instructor_comm"
                                                                   name="commission_rate" min="0" max="100" readonly
                                                                   value="{{$setting->commission_rate}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('bundleSubscription.Show instructor profile  bundle') }}
                                                            </label>
                                                            <label class="switch_toggle  mt-2"
                                                                   for="show_bundle_in_instructor_profile">
                                                                <input type="checkbox" class="status_enable_disable"
                                                                       name="show_bundle_in_instructor_profile"
                                                                       id="show_bundle_in_instructor_profile"
                                                                       {{Settings('show_bundle_in_instructor_profile')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>

                                                        </div>
                                                    </div>


                                                    <div class="col-xl-3">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('bundleSubscription.Show Review') }}
                                                            </label>
                                                            <label class="switch_toggle  mt-2"
                                                                   for="show_review_for_bundle_subscription">
                                                                <input type="checkbox" class="status_enable_disable"
                                                                       name="show_review_for_bundle_subscription"
                                                                       id="show_review_for_bundle_subscription"
                                                                       {{Settings('show_review_for_bundle_subscription')==1?'checked':''}}
                                                                       value="1">
                                                                <i class="slider round"></i>
                                                            </label>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="submit_btn text-center mt-4">
                                                    <button class="primary_btn_large" type="submit"
                                                            id=""><i
                                                            class="ti-check"></i> {{ __('common.Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('setting::page_components.script')
