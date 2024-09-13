@extends('backend.master')
@push('styles')

@endpush


@section('mainContent')

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('bundleSubscription.Bundle Plan')}} </h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">{{__('bundleSubscription.Bundle Plan')}}</a>
                    <a href="#">{{__('bundleSubscription.Bundle Plan List')}}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('bundleSubscription.Bundle Plan List')}}</h3>

                            <ul class="d-flex">
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" data-toggle="modal"
                                       id="add_plan_btn"
                                       data-target="#add_plan" href="#"><i
                                            class="ti-plus"></i>{{__('bundleSubscription.Add Bundle Plan')}}</a></li>
                            </ul>

                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">

                            <div class="">
                                <table id="BundleList" class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('bundleSubscription.Title')}}</th>
                                        <th scope="col">{{__('bundleSubscription.Author')}}</th>
                                        <th scope="col">{{__('bundleSubscription.Price')}}</th>
                                        <th scope="col">{{__('bundleSubscription.description')}}</th>
                                        <th scope="col">{{__('bundleSubscription.Days')}}</th>
                                        <th scope="col">{{__('common.Status')}}</th>
                                        <th scope="col">{{__('common.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade admin-query" id="add_plan">
                    <div class="modal-dialog modal_1000px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('bundleSubscription.Add Bundle Plan')}}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form action="{{route('bundle.store')}}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('bundleSubscription.Title')}}
                                                    <strong class="text-danger">*</strong></label>
                                                <input class="primary_input_field" name="title" placeholder="-"
                                                       required
                                                       type="text" id="addTitle"
                                                       value="{{ old('title') }}" {{$errors->first('title') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('subscription.Price')}}  </label>
                                                <input class="primary_input_field" name="price" placeholder="0"
                                                       step="any"
                                                       type="number" min="0" id="addPrice"
                                                       value="{{ old('price') }}" {{$errors->first('price') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('subscription.Days')}} </label>
                                                <input class="primary_input_field" name="days" placeholder="0"
                                                       type="number" min="0" id="addDays"
                                                       value="{{ old('days',0) }}" {{$errors->first('days') ? 'autofocus' : ''}}>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{__('bundleSubscription.description')}} </label>


                                                <textarea class="primary_textarea height_128" name="about" id="addAbout"
                                                          cols="30" rows="10">{{ old('about') }}</textarea>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-12 text-center pt_15">
                                        <div class="d-flex justify-content-center">
                                            <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                    type="submit"><i
                                                    class="ti-check"></i> {{__('common.Save')}} {{__('subscription.Plan')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </section>


    <input type="hidden" name="datatable_url" id="datatable_url" value="{{ route('bundle.datatable') }}">
    <input type="hidden" name="datatable_url" id="no_data_show_msg"
           value="{{ __("common.No data available in the table") }}">
    @include('backend.partials.delete_modal')
@endsection


@push('scripts')

    @include('bundlesubscription::backend.bundle_course.script')



    <script>
        (function ($) {
            "use strict";
            $('#BundleList').DataTable({
                bLengthChange: true,
                "bDestroy": true,
                processing: true,
                serverSide: true,
                "ajax": $.fn.dataTable.pipeline({
                    url: $("#datatable_url").val(),
                    pages: 5,
                }),

                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'price', name: 'price'},
                    {data: 'about', name: 'about'},
                    {data: 'days', name: 'days'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},

                ],
                language: {
                    emptyTable: $("#no_data_show_msg").val(),
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: '{{ __("common.Quick Search") }}',
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>"
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="far fa-copy"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __("common.Copy") }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="far fa-file-excel"></i>',
                        titleAttr: '{{ __("common.Excel") }}',
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },

                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="far fa-file-alt"></i>',
                        titleAttr: '{{ __("common.CSV") }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="far fa-file-pdf"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: '{{ __("common.PDF") }}',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        header: true,
                        customize: function (doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: '{{ __("common.Print") }}',
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ['colvisRestore']
                    }
                ],
                columnDefs: [{
                    visible: false
                }],
                responsive: true,
            });
        })(jQuery);

    </script>

@endpush

