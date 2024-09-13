@extends('backend.master')
@push('styles')

@endpush


@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('bundleSubscription.Edit Bundle Plan')}} </h1>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">


                <div class="white_box mb_30">
                    <div class="justify-content-center">

                        <form action="{{ route('bundle.update') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $bundlePlan->id }}">

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('subscription.Title')}} <strong
                                            class="text-danger">*</strong></label>
                                    <input class="primary_input_field" name="title" placeholder="-"
                                           required
                                           type="text" id="editTitle"
                                           value="{{ $bundlePlan->title }}" {{$errors->first('title') ? 'autofocus' : ''}}>
                                </div>
                            </div>


                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('bundleSubscription.Price')}} <strong
                                            class="text-danger">*</strong></label>
                                    <input class="primary_input_field" name="price" placeholder="-"
                                           type="number" id="editPrice"
                                           value="{{ $bundlePlan->price }}" {{$errors->first('price') ? 'autofocus' : ''}}>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('subscription.Days')}} </label>
                                    <input class="primary_input_field" name="days" placeholder="-"
                                           type="number" id="editDays"
                                           value="{{ $bundlePlan->days }}" {{$errors->first('days') ? 'autofocus' : ''}}>
                                </div>
                            </div>



                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for="">{{__('bundleSubscription.description')}} </label>


                                    <textarea class="primary_textarea height_128" name="about" id="editAbout" cols="30" rows="10">{{ $bundlePlan->about }}</textarea>

                                </div>
                            </div>



                            <div class="col-lg-10 text-center pt_15">
                                <div class="d-flex justify-content-center">
                                    <button class="primary-btn semi_large2  fix-gr-bg"
                                            id="save_button_parent" type="submit"><i
                                            class="ti-check"></i> {{__('bundleSubscription.Update Bundle Plan')}}
                                    </button>
                                </div>
                            </div>
                        </form>


                    </div>


        </div>
    </section>

@endsection


